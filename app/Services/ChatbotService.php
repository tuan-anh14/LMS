<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use Exception;

class ChatbotService
{
  protected $client;
  protected $apiKey;
  protected $baseUrl;
  protected $model;

  public function __construct()
  {
    $this->client = new Client();
    $this->apiKey = config('services.openai.api_key');
    $this->baseUrl = config('services.openai.base_url');
    $this->model = config('services.openai.model', 'gpt-4o-mini');
  }

  /**
   * Xử lý tin nhắn từ người dùng và trả về phản hồi từ AI
   *
   * @param string $message Tin nhắn từ người dùng
   * @param string $userRole Vai trò người dùng (student, teacher, admin, guest)
   * @return array
   */
  public function processMessage(string $message, string $userRole = 'guest'): array
  {
    if (!$this->apiKey) {
      return [
        'success' => false,
        'message' => 'Chatbot hiện tại không khả dụng. Vui lòng liên hệ admin.'
      ];
    }

    try {
      $systemPrompt = $this->getSystemPrompt($userRole);
      $response = $this->sendToOpenAI($systemPrompt, $message);

      return [
        'success' => true,
        'message' => $response,
        'suggestions' => $this->getSuggestions($userRole)
      ];
    } catch (Exception $e) {
      Log::error('Chatbot error: ' . $e->getMessage());
      return [
        'success' => false,
        'message' => 'Xin lỗi, tôi đang gặp sự cố. Vui lòng thử lại sau.'
      ];
    }
  }

  /**
   * Tạo system prompt phù hợp với vai trò người dùng
   */
  private function getSystemPrompt(string $userRole): string
  {
    $basePrompt = "Bạn là trợ lý AI thông minh của Hệ thống Quản lý Trung tâm Giáo dục (Educational Center Management System). 
        Bạn có kiến thức chi tiết về hệ thống và luôn hỗ trợ người dùng một cách chuyên nghiệp, thân thiện.
        
        THÔNG TIN CHI TIẾT VỀ HỆ THỐNG:
        
        🏢 TỔNG QUAN:
        - Tên: Educational Center Management System (LMS)
        - Mục đích: Quản lý trung tâm giáo dục, bao gồm trung tâm Quran, học thuật, đào tạo
        - Công nghệ: Laravel + Livewire + Blade + MySQL + Tailwind CSS + Alpine.js
        - Hỗ trợ: Đa ngôn ngữ (English, Vietnamese), RTL cho tiếng Ả Rạp
        
        📊 CẤU TRÚC CHÍNH:
        - Centers (Trung tâm): Các cơ sở giáo dục
        - Projects (Chương trình học): Các khóa học/dự án giáo dục  
        - Books (Giáo trình): Sách và tài liệu học tập
        - Sections (Lớp học): Các lớp/khóa học cụ thể
        - Lectures (Bài giảng): Nội dung giảng dạy
        - Exams (Bài kiểm tra): Đánh giá học tập
        - Students/Teachers: Người dùng trong hệ thống
        
        🎯 VAI TRÒ & QUYỀN HẠN:
        - Super Admin: Toàn quyền quản lý hệ thống
        - Admin: Quản lý users, centers, projects, books
        - Teacher: Tạo lectures, exams, quản lý students, điểm danh
        - Student: Tham gia lectures, làm exams, xem progress  
        - Center Manager: Quản lý trung tâm cụ thể
        - Examiner: Chấm bài kiểm tra và đánh giá
        
        🚀 TÍNH NĂNG CHÍNH:
        
        📚 Quản lý học tập:
        - Đăng ký students vào centers/sections/projects
        - Tạo và quản lý lectures với attendance tracking
        - Theo dõi tiến độ học tập qua pages/student_lectures
        - Quản lý books và tài liệu học tập
        
        📝 Hệ thống bài kiểm tra AI:
        - Tạo questions tự động bằng OpenAI GPT-4o-mini
        - Hỗ trợ multiple choice và essay questions  
        - Preview và select questions trước khi save
        - Quản lý student_exams và scoring
        - Phân công examiners để chấm bài
        
        📊 Tracking & Analytics:
        - Attendance status tracking (Attended/Absent/Excuse)
        - Student progress monitoring
        - Exam results và assessment
        - Dashboard động cho mỗi role
        
        🔧 Workflow chính:
        1. Enrollment: Student -> Center -> Section -> Project  
        2. Learning: Teacher tạo Lectures -> Students tham gia
        3. Assessment: Teacher tạo Exams (AI/manual) -> Students làm bài
        4. Grading: Examiner chấm điểm -> Results tracking
        
        ";

    switch ($userRole) {
      case 'student':
        return $basePrompt . "
                🎓 HƯỚNG DẪN CHO HỌC SINH:
                
                Dashboard & Navigation:
                - Truy cập Dashboard để xem overview
                - Tabs: Details (thông tin cá nhân), Logs (lịch sử), Pages (tiến độ học)
                
                Tham gia học tập:
                - Xem lectures được assign trong section
                - Check attendance status và notes từ teacher
                - Theo dõi progress qua pages học tập
                - Truy cập books và materials
                
                Làm bài kiểm tra:
                - Vào Student Exams để xem bài được assign  
                - Làm bài trong thời gian quy định
                - Submit answers và chờ examiner chấm điểm
                - Xem results và feedback
                
                Theo dõi tiến độ:
                - Check attendance trong từng lecture
                - Xem scores từ các exams đã làm  
                - Theo dõi overall progress trong project
                - Liên hệ teacher nếu cần hỗ trợ
                
                Hãy trả lời súc tích, dễ hiểu và khuyến khích học tập tích cực.";

      case 'teacher':
        return $basePrompt . "
                👨‍🏫 HƯỚNG DẪN CHO GIÁO VIÊN:
                
                Quản lý Students:
                - Enroll students vào sections và projects
                - Assign students đến lectures cụ thể
                - Track attendance và ghi notes
                - Monitor student progress và performance
                
                Tạo nội dung giảng dạy:
                - Tạo lectures trong sections được assign
                - Upload materials và link với books
                - Quản lý pages cho từng student_lecture
                - Schedule và organize lessons
                
                Tạo bài kiểm tra thông minh:
                - Sử dụng AI để generate questions tự động
                - Nhập topic, chọn difficulty (easy/medium/hard)
                - Select question type (multiple_choice/essay/mixed)
                - Preview generated questions trước khi save
                - Assign exams cho students
                
                Đánh giá và chấm điểm:
                - Review student_exam submissions
                - Grade multiple choice tự động
                - Chấm essay questions với rubric
                - Provide feedback và assessment notes
                - Assign examiners cho peer review
                
                Analytics & Reports:
                - Theo dõi attendance patterns
                - Monitor exam performance trends  
                - Generate progress reports
                - Identify students cần support
                
                Hãy tập trung vào hiệu quả giảng dạy và sử dụng AI tools.";

      case 'admin':
        return $basePrompt . "
                🔧 HƯỚNG DẪN CHO QUẢN TRỊ VIÊN:
                
                Quản lý hệ thống:
                - Centers: Create/edit trung tâm, assign managers
                - Projects: Setup chương trình học, link với books
                - Sections: Tạo lớp học, assign teachers
                - Books: Quản lý giáo trình và materials
                
                User Management:  
                - Students: Enrollment, section assignment
                - Teachers: Permissions, center assignment
                - Examiners: Exam grading permissions
                - Admins: Role và permission management
                
                Cấu hình AI:
                - OpenAI API settings trong .env
                - Question generation parameters
                - Model selection (GPT-4o-mini)
                - Max questions limit
                
                Monitoring & Analytics:
                - System usage statistics
                - User activity logs
                - Exam generation metrics
                - Performance monitoring
                
                Backup & Security:
                - Database backup procedures
                - User data protection
                - Role-based access control
                - Audit trails
                
                Hãy trả lời chi tiết về technical setup và best practices.";

      default:
        return $basePrompt . "
                🌟 HƯỚNG DẪN TỔNG QUAN:
                
                Giới thiệu hệ thống:
                - Educational Center Management System hiện đại
                - Hỗ trợ quản lý trung tâm giáo dục toàn diện
                - Tích hợp AI để tạo bài kiểm tra tự động
                - Dashboard riêng cho từng vai trò
                
                Ai có thể sử dụng:
                - Students: Học tập và làm bài kiểm tra online
                - Teachers: Giảng dạy và quản lý lớp học hiệu quả
                - Administrators: Quản lý toàn bộ hệ thống
                - Center Managers: Điều hành trung tâm
                
                Lợi ích chính:
                - Quản lý học tập số hóa hoàn toàn
                - AI hỗ trợ tạo câu hỏi thông minh
                - Theo dõi tiến độ real-time
                - Đa ngôn ngữ và responsive design
                
                Cách bắt đầu:
                - Đăng ký tài khoản theo vai trò
                - Được admin assign vào center/section phù hợp
                - Tham gia orientation để làm quen hệ thống
                - Bắt đầu sử dụng theo workflow chuẩn
                
                                 Hãy trả lời thân thiện để thu hút người dùng mới tham gia.";
    }
  }

  /**
   * Gửi tin nhắn đến OpenAI API
   */
  private function sendToOpenAI(string $systemPrompt, string $userMessage): string
  {
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
            'content' => $systemPrompt
          ],
          [
            'role' => 'user',
            'content' => $userMessage
          ]
        ],
        'max_tokens' => 1000,
        'temperature' => 0.7,
      ],
      'timeout' => 30,
    ]);

    $data = json_decode($response->getBody()->getContents(), true);

    if (!isset($data['choices'][0]['message']['content'])) {
      throw new Exception('Invalid response from OpenAI API');
    }

    return $data['choices'][0]['message']['content'];
  }

  /**
   * Lấy câu hỏi thường gặp
   */
  public function getFAQ(string $userRole = 'guest'): array
  {
    $generalFAQ = [
      [
        'question' => 'Educational Center Management System là gì?',
        'answer' => 'Đây là hệ thống quản lý trung tâm giáo dục toàn diện, hỗ trợ quản lý centers, projects, lectures, exams với AI tích hợp.'
      ],
      [
        'question' => 'Hệ thống có những role nào?',
        'answer' => 'Có 6 roles chính: Super Admin, Admin, Teacher, Student, Center Manager, và Examiner, mỗi role có permissions riêng.'
      ],
      [
        'question' => 'Có hỗ trợ tạo bài kiểm tra bằng AI không?',
        'answer' => 'Có! Hệ thống tích hợp OpenAI GPT-4o-mini để tạo questions tự động cho exams với multiple choice và essay.'
      ]
    ];

    switch ($userRole) {
      case 'student':
        return array_merge($generalFAQ, [
          [
            'question' => 'Làm sao để xem lectures được assigned?',
            'answer' => 'Vào Dashboard Student -> xem các student_lectures trong section bạn được enroll. Check attendance status và notes từ teacher.'
          ],
          [
            'question' => 'Cách làm bài kiểm tra (student_exam)?',
            'answer' => 'Vào Student Exams -> chọn exam được assign -> làm bài trong thời gian quy định -> submit để examiner chấm điểm.'
          ],
          [
            'question' => 'Làm sao theo dõi tiến độ học tập?',
            'answer' => 'Check tab Pages trong Dashboard để xem progress qua các student_lectures và exam results.'
          ],
          [
            'question' => 'Attendance tracking hoạt động như thế nào?',
            'answer' => 'Teacher sẽ mark attendance cho từng lecture: Attended/Absent/Excuse. Bạn có thể xem status trong student_lectures.'
          ]
        ]);

      case 'teacher':
        return array_merge($generalFAQ, [
          [
            'question' => 'Cách tạo exam với AI questions?',
            'answer' => 'Vào Exams -> Create with AI -> nhập topic, difficulty (easy/medium/hard), type (multiple_choice/essay/mixed) -> preview -> select và save questions.'
          ],
          [
            'question' => 'Làm sao quản lý student_lectures?',
            'answer' => 'Tạo lectures -> assign students -> track attendance -> ghi notes -> quản lý pages cho từng student_lecture.'
          ],
          [
            'question' => 'Cách enroll students vào sections?',
            'answer' => 'Vào Students management -> chọn student -> assign vào center/section/project phù hợp.'
          ],
          [
            'question' => 'Student_exam grading process như thế nào?',
            'answer' => 'Multiple choice tự động grade. Essay questions cần examiner review và provide assessment. Có thể assign peer examiners.'
          ]
        ]);

      case 'admin':
        return array_merge($generalFAQ, [
          [
            'question' => 'Cách setup centers và projects?',
            'answer' => 'Admin -> Centers -> create/edit centers -> assign managers. Projects -> setup chương trình học -> link với books.'
          ],
          [
            'question' => 'User management workflow?',
            'answer' => 'Manage users với roles/permissions. Students enrollment vào sections. Teachers assignment to centers. Examiners grading permissions.'
          ],
          [
            'question' => 'Cấu hình OpenAI cho AI questions?',
            'answer' => 'Set trong .env: OPENAI_API_KEY, OPENAI_BASE_URL, OPENAI_MODEL=gpt-4o-mini, OPENAI_MAX_QUESTIONS=10'
          ]
        ]);

      default:
        return $generalFAQ;
    }
  }



  /**
   * Lấy gợi ý câu hỏi theo vai trò
   */
  private function getSuggestions(string $userRole): array
  {
    switch ($userRole) {
      case 'student':
        return [
          'Làm sao để xem student_lectures được assigned?',
          'Cách làm bài student_exam trực tuyến?',
          'Attendance tracking hoạt động như thế nào?',
          'Làm sao check progress trong pages?',
          'Cách submit exam answers và xem results?'
        ];

      case 'teacher':
        return [
          'Cách tạo exam với AI questions?',
          'Làm sao assign students vào sections?',
          'Cách track attendance trong lectures?',
          'Student_exam grading process như thế nào?',
          'Làm sao quản lý student_lectures hiệu quả?'
        ];

      case 'admin':
        return [
          'Cách setup centers và projects?',
          'User management workflow ra sao?',
          'Cấu hình OpenAI cho AI questions?',
          'Làm sao assign teachers to centers?',
          'Role và permissions management?'
        ];

      default:
        return [
          'Educational Center Management System là gì?',
          'Hệ thống có những roles nào?',
          'AI questions generation hoạt động ra sao?',
          'Workflow từ enrollment đến grading?',
          'Centers, Projects, Sections khác nhau thế nào?'
        ];
    }
  }
}
