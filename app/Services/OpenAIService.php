<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use Exception;

class OpenAIService
{
  protected $client;
  protected $apiKey;
  protected $baseUrl;
  protected $model;
  protected $maxQuestions;

  public function __construct()
  {
    $this->client = new Client();
    $this->apiKey = config('services.openai.api_key');
    $this->baseUrl = config('services.openai.base_url');
    $this->model = config('services.openai.model');
    $this->maxQuestions = config('services.openai.max_questions', 10);
  }

  /**
   * Generate questions using GPT-4o-mini
   *
   * @param string $topic Chủ đề để tạo câu hỏi
   * @param int $count Số lượng câu hỏi (tối đa 10)
   * @param string $difficulty Độ khó (easy, medium, hard)
   * @param string $type Loại câu hỏi (multiple_choice, essay, mixed)
   * @return array
   */
  public function generateQuestions(string $topic, int $count = 5, string $difficulty = 'medium', string $type = 'mixed'): array
  {
    if (!$this->apiKey) {
      throw new Exception('OpenAI API key is not configured');
    }

    // Giới hạn số lượng câu hỏi tối đa
    $count = min($count, $this->maxQuestions);

    $prompt = $this->buildPrompt($topic, $count, $difficulty, $type);

    try {
      $response = $this->client->post($this->baseUrl . '/chat/completions', [
        'headers' => [
          'Authorization' => 'Bearer ' . $this->apiKey,
          'Content-Type' => 'application/json',
        ],
        'json' => [
          'model' => $this->model,
          'messages' => [
            [
              'role' => 'system',
              'content' => 'Bạn là một giáo viên chuyên nghiệp có kinh nghiệm tạo câu hỏi kiểm tra. Bạn luôn tạo ra những câu hỏi chất lượng cao, phù hợp với chương trình học.'
            ],
            [
              'role' => 'user',
              'content' => $prompt
            ]
          ],
          'max_tokens' => 3000,
          'temperature' => 0.7,
        ],
        'timeout' => 30,
      ]);

      $data = json_decode($response->getBody()->getContents(), true);

      if (!isset($data['choices'][0]['message']['content'])) {
        throw new Exception('Invalid response from OpenAI API');
      }

      return $this->parseResponse($data['choices'][0]['message']['content']);
    } catch (RequestException $e) {
      Log::error('OpenAI API request failed: ' . $e->getMessage());
      throw new Exception('Failed to generate questions: ' . $e->getMessage());
    } catch (Exception $e) {
      Log::error('OpenAI service error: ' . $e->getMessage());
      throw $e;
    }
  }

  /**
   * Build the prompt for generating questions
   */
  private function buildPrompt(string $topic, int $count, string $difficulty, string $type): string
  {
    $difficultyText = [
      'easy' => 'dễ (cơ bản)',
      'medium' => 'trung bình (vừa phải)',
      'hard' => 'khó (nâng cao)'
    ];

    $typeText = [
      'multiple_choice' => 'trắc nghiệm (4 lựa chọn)',
      'essay' => 'tự luận',
      'mixed' => 'kết hợp cả trắc nghiệm và tự luận'
    ];

    return "Hãy tạo {$count} câu hỏi về chủ đề '{$topic}' với độ khó {$difficultyText[$difficulty]} và loại câu hỏi {$typeText[$type]}.

Yêu cầu định dạng trả về JSON như sau:
{
    \"questions\": [
        {
            \"content\": \"Nội dung câu hỏi\",
            \"type\": \"multiple_choice\" hoặc \"essay\",
            \"options\": [\"A. Lựa chọn 1\", \"B. Lựa chọn 2\", \"C. Lựa chọn 3\", \"D. Lựa chọn 4\"],
            \"correct_answer\": \"A\" (đối với trắc nghiệm) hoặc \"Gợi ý đáp án\" (đối với tự luận),
            \"points\": 1
        }
    ]
}

Lưu ý:
- Đối với câu hỏi trắc nghiệm: phải có đúng 4 lựa chọn A, B, C, D và chỉ rõ đáp án đúng
- Đối với câu hỏi tự luận: correct_answer là gợi ý đáp án hoặc hướng dẫn chấm điểm
- Câu hỏi phải rõ ràng, chính xác và phù hợp với chủ đề
- Trả về đúng định dạng JSON, không có văn bản thừa";
  }

  /**
   * Parse the AI response and extract questions
   */
  private function parseResponse(string $response): array
  {
    try {
      // Loại bỏ markdown code blocks nếu có
      $response = preg_replace('/```json\s*/', '', $response);
      $response = preg_replace('/```\s*$/', '', $response);
      $response = trim($response);

      $data = json_decode($response, true);

      if (json_last_error() !== JSON_ERROR_NONE) {
        Log::error('JSON decode error: ' . json_last_error_msg());
        throw new Exception('Invalid JSON response from AI');
      }

      if (!isset($data['questions']) || !is_array($data['questions'])) {
        throw new Exception('No questions found in AI response');
      }

      $questions = [];
      foreach ($data['questions'] as $question) {
        if (empty($question['content']) || empty($question['type'])) {
          continue;
        }

        $questionData = [
          'content' => $question['content'],
          'type' => $question['type'],
          'points' => $question['points'] ?? 1,
          'correct_answer' => $question['correct_answer'] ?? null,
          'options' => null
        ];

        // Xử lý options cho câu hỏi trắc nghiệm
        if ($question['type'] === 'multiple_choice' && isset($question['options'])) {
          $questionData['options'] = $question['options'];
        }

        $questions[] = $questionData;
      }

      return $questions;
    } catch (Exception $e) {
      Log::error('Error parsing AI response: ' . $e->getMessage());
      Log::error('Raw response: ' . $response);
      throw new Exception('Failed to parse AI response: ' . $e->getMessage());
    }
  }
}
