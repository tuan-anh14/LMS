<?php

namespace App\Http\Controllers;

use App\Services\ChatbotService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ChatbotController extends Controller
{
  protected $chatbotService;

  public function __construct(ChatbotService $chatbotService)
  {
    $this->chatbotService = $chatbotService;
  }

  /**
   * Xử lý tin nhắn từ người dùng
   */
  public function sendMessage(Request $request): JsonResponse
  {
    $request->validate([
      'message' => 'required|string|max:1000'
    ]);

    $message = $request->input('message');
    $userRole = $this->getUserRole();

    $response = $this->chatbotService->processMessage($message, $userRole);

    return response()->json([
      'success' => $response['success'],
      'message' => $response['message'],
      'suggestions' => $response['suggestions'] ?? [],
      'user_role' => $userRole
    ]);
  }

  /**
   * Lấy câu hỏi thường gặp
   */
  public function getFAQ(): JsonResponse
  {
    $userRole = $this->getUserRole();
    $faq = $this->chatbotService->getFAQ($userRole);

    return response()->json([
      'success' => true,
      'faq' => $faq,
      'user_role' => $userRole
    ]);
  }

  /**
   * Lấy thông tin khởi tạo chatbot
   */
  public function getInitialData(): JsonResponse
  {
    $userRole = $this->getUserRole();

    $welcomeMessage = $this->getWelcomeMessage($userRole);
    $suggestions = $this->getSuggestions($userRole);

    return response()->json([
      'success' => true,
      'welcome_message' => $welcomeMessage,
      'suggestions' => $suggestions,
      'user_role' => $userRole,
      'user_name' => Auth::check() ? Auth::user()->name : 'Khách'
    ]);
  }

  /**
   * Xác định vai trò người dùng
   */
  private function getUserRole(): string
  {
    if (!Auth::check()) {
      return 'guest';
    }

    $user = Auth::user();

    // Kiểm tra role dựa trên Laratrust
    if ($user->hasRole('super_admin') || $user->hasRole('admin')) {
      return 'admin';
    } elseif ($user->hasRole('teacher') || $user->hasRole('examiner') || $user->hasRole('center_manager')) {
      return 'teacher';
    } elseif ($user->hasRole('student')) {
      return 'student';
    }

    return 'guest';
  }

  /**
   * Tạo tin nhắn chào mừng theo vai trò
   */
  private function getWelcomeMessage(string $userRole): string
  {
    $userName = Auth::check() ? Auth::user()->name : 'bạn';

    switch ($userRole) {
      case 'student':
        return "Xin chào {$userName}! 👋 Tôi là trợ lý AI của hệ thống LMS. Tôi có thể giúp bạn:\n\n📚 Hướng dẫn sử dụng các tính năng học tập\n📝 Cách làm bài kiểm tra trực tuyến\n📊 Xem điểm số và tiến độ học tập\n📞 Liên hệ với giáo viên\n\nHãy hỏi tôi bất cứ điều gì!";

      case 'teacher':
        return "Xin chào Giáo viên {$userName}! 👨‍🏫 Tôi là trợ lý AI hỗ trợ giảng dạy. Tôi có thể giúp bạn:\n\n🎯 Tạo bài kiểm tra tự động bằng AI\n👥 Quản lý lớp học hiệu quả\n📊 Theo dõi tiến độ học sinh\n✅ Chấm điểm và đánh giá\n📋 Quản lý điểm danh\n\nHãy hỏi tôi về bất kỳ tính năng nào!";

      case 'admin':
        return "Xin chào Quản trị viên {$userName}! 🔧 Tôi là trợ lý AI hệ thống. Tôi có thể hỗ trợ bạn:\n\n👥 Quản lý người dùng và phân quyền\n🏢 Quản lý trung tâm và khóa học\n⚙️ Cấu hình hệ thống\n📈 Xem báo cáo tổng quan\n🔒 Bảo mật và backup\n\nTôi sẵn sàng giải đáp mọi thắc mắc!";

      default:
        return "Xin chào {$userName}! 🌟 Chào mừng đến với Hệ thống Quản lý Trung tâm Giáo dục!\n\nTôi là trợ lý AI thông minh, sẵn sàng hướng dẫn bạn:\n\n🔐 Đăng ký và đăng nhập\n📖 Tìm hiểu về các tính năng\n🎯 Chọn vai trò phù hợp\n💡 Lợi ích của hệ thống\n\nHãy hỏi tôi bất cứ điều gì bạn muốn biết!";
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
          'Làm thế nào để xem lịch học của tôi?',
          'Cách làm bài kiểm tra trực tuyến?',
          'Làm sao để xem điểm số?',
          'Cách liên hệ với giáo viên?'
        ];

      case 'teacher':
        return [
          'Cách tạo bài kiểm tra tự động?',
          'Làm thế nào để quản lý lớp học?',
          'Cách sử dụng AI để tạo câu hỏi?',
          'Làm sao để chấm điểm nhanh?'
        ];

      case 'admin':
        return [
          'Cách quản lý người dùng?',
          'Làm thế nào để xem báo cáo hệ thống?',
          'Cách cấu hình OpenAI?',
          'Làm sao để backup dữ liệu?'
        ];

      default:
        return [
          'Hệ thống này có những tính năng gì?',
          'Cách đăng ký tài khoản?',
          'Phân biệt vai trò học sinh và giáo viên?',
          'Tôi có thể học gì ở đây?'
        ];
    }
  }
}
