<!-- Chatbot AI Component -->
<div x-data="chatbot()" x-cloak class="fixed bottom-6 right-6 z-50">
  <!-- Chatbot Toggle Button -->
  <button @click="toggleChat()"
    class="relative bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500 hover:from-blue-600 hover:via-purple-600 hover:to-pink-600 text-white rounded-full p-5 shadow-2xl transition-all duration-500 transform hover:scale-110 group floating-animation"
    :class="{ 'hidden': isOpen }">
    <!-- Pulse Animation -->
    <div class="absolute -inset-2 bg-gradient-to-br from-blue-400 to-purple-400 rounded-full blur opacity-75 group-hover:opacity-100 animate-pulse"></div>

    <!-- Main Icon -->
    <div class="relative">
      <svg class="w-9 h-9 transform transition-transform duration-300 group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
      </svg>
    </div>

    <!-- Notification Badge -->
    <div class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 rounded-full flex items-center justify-center">
      <span class="text-sm font-bold text-white">AI</span>
    </div>
  </button>

  <!-- Chatbot Window -->
  <div x-show="isOpen"
    x-transition:enter="transition ease-out duration-400"
    x-transition:enter-start="opacity-0 transform scale-90 translate-y-4"
    x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 transform scale-100 translate-y-0"
    x-transition:leave-end="opacity-0 transform scale-90 translate-y-4"
    class="bg-white rounded-2xl shadow-2xl border border-gray-100 w-[420px] h-[700px] flex flex-col backdrop-blur-sm">

    <!-- Header -->
    <div class="relative bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500 text-white p-5 rounded-t-2xl flex justify-between items-center overflow-hidden">
      <!-- Background Pattern -->
      <div class="absolute inset-0 bg-white bg-opacity-10 backdrop-blur-sm"></div>
      <div class="absolute -top-4 -right-4 w-24 h-24 bg-white bg-opacity-10 rounded-full"></div>
      <div class="absolute -bottom-2 -left-2 w-20 h-20 bg-white bg-opacity-5 rounded-full"></div>

      <div class="relative flex items-center space-x-4">
        <div class="bg-white bg-opacity-25 backdrop-blur-sm rounded-2xl p-3 shadow-lg">
          <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
        <div>
          <h3 class="font-bold text-xl tracking-wide">Trợ lý AI LMS</h3>
          <p class="text-base text-white text-opacity-90 font-medium">Hướng dẫn thông minh • <span class="text-yellow-300">Online</span></p>
        </div>
      </div>

      <button @click="toggleChat()" class="relative text-white hover:text-gray-200 p-3 hover:bg-white hover:bg-opacity-20 rounded-xl transition-all duration-200 group">
        <svg class="w-6 h-6 transform group-hover:rotate-90 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
      </button>
    </div>

    <!-- Chat Messages -->
    <div class="flex-1 overflow-y-auto p-6 space-y-5 bg-gradient-to-b from-gray-50 to-white chatbot-scrollbar" x-ref="messagesContainer">
      <!-- Welcome Message -->
      <div x-show="!hasStarted" class="space-y-6">
        <div class="bg-gradient-to-br from-blue-50 to-purple-50 border border-blue-100 rounded-2xl p-6 shadow-sm">
          <div class="flex items-start space-x-4">
            <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-500 rounded-full flex items-center justify-center">
              <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
            <div class="flex-1">
              <p class="text-gray-700 text-base leading-relaxed font-medium" x-text="welcomeMessage"></p>
            </div>
          </div>
        </div>

        <!-- Quick Suggestions -->
        <div class="space-y-4">
          <div class="flex items-center space-x-3">
            <span class="text-xl">💡</span>
            <p class="text-base text-gray-600 font-semibold">Gợi ý câu hỏi:</p>
          </div>
          <template x-for="suggestion in suggestions" :key="suggestion">
            <button @click="sendSuggestion(suggestion)"
              class="w-full text-left bg-gradient-to-r from-blue-50 to-indigo-50 hover:from-blue-100 hover:to-indigo-100 border border-blue-200 hover:border-blue-300 text-blue-800 text-base p-5 rounded-xl transition-all duration-300 transform hover:scale-[1.02] hover:shadow-md group">
              <div class="flex items-center justify-between">
                <span class="flex-1 font-medium" x-text="suggestion"></span>
                <svg class="w-5 h-5 text-blue-400 opacity-0 group-hover:opacity-100 transition-opacity duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
              </div>
            </button>
          </template>
        </div>

        <!-- FAQ Section -->
        <div x-show="faqItems.length > 0" class="space-y-4">
          <div class="flex items-center space-x-3">
            <span class="text-xl">❓</span>
            <p class="text-base text-gray-600 font-semibold">Câu hỏi thường gặp:</p>
          </div>
          <template x-for="item in faqItems.slice(0, 3)" :key="item.question">
            <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition-shadow duration-200">
              <p class="font-semibold text-base text-gray-800 mb-3" x-text="item.question"></p>
              <p class="text-sm text-gray-600 leading-relaxed" x-text="item.answer"></p>
            </div>
          </template>
        </div>
      </div>

      <!-- Messages -->
      <template x-for="message in messages" :key="message.id">
        <div class="flex items-end space-x-3" :class="message.isUser ? 'justify-end flex-row-reverse space-x-reverse' : 'justify-start'">
          <!-- Avatar -->
          <div class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center"
            :class="message.isUser ? 'bg-gradient-to-br from-blue-500 to-purple-500' : 'bg-gradient-to-br from-gray-400 to-gray-500'">
            <template x-if="message.isUser">
              <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 2C5.58 2 2 5.58 2 10s3.58 8 8 8 8-3.58 8-8-3.58-8-8-8zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 12.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"></path>
              </svg>
            </template>
            <template x-if="!message.isUser">
              <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </template>
          </div>

          <!-- Message Bubble -->
          <div class="max-w-sm lg:max-w-lg px-5 py-4 rounded-2xl shadow-sm relative message-bubble"
            :class="message.isUser ? 'bg-gradient-to-br from-blue-500 to-purple-500 text-white rounded-br-md' : 'bg-white border border-gray-200 text-gray-800 rounded-bl-md'">
            <!-- Message Tail -->
            <div class="absolute w-4 h-4 transform rotate-45"
              :class="message.isUser ? 'bg-purple-500 -right-1 bottom-3' : 'bg-white border-l border-b border-gray-200 -left-1 bottom-3'"></div>

            <p class="text-base whitespace-pre-wrap leading-relaxed font-medium" x-text="message.content"></p>
            <p class="text-sm mt-3 opacity-70 font-normal"
              :class="message.isUser ? 'text-blue-100' : 'text-gray-500'"
              x-text="message.time"></p>
          </div>
        </div>
      </template>

      <!-- Loading indicator -->
      <div x-show="isLoading" class="flex justify-start items-end space-x-3">
        <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-gray-400 to-gray-500 rounded-full flex items-center justify-center">
          <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
        <div class="bg-white border border-gray-200 max-w-sm lg:max-w-lg px-5 py-4 rounded-2xl rounded-bl-md shadow-sm relative">
          <div class="absolute w-4 h-4 bg-white border-l border-b border-gray-200 transform rotate-45 -left-1 bottom-3"></div>
          <div class="flex items-center space-x-3">
            <div class="flex space-x-1">
              <div class="w-3 h-3 bg-gradient-to-r from-blue-400 to-purple-400 rounded-full animate-bounce"></div>
              <div class="w-3 h-3 bg-gradient-to-r from-purple-400 to-pink-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
              <div class="w-3 h-3 bg-gradient-to-r from-pink-400 to-blue-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
            </div>
            <span class="text-sm text-gray-500 font-medium">AI đang suy nghĩ...</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Input Area -->
    <div class="border-t border-gray-100 bg-white p-6 rounded-b-2xl">
      <form @submit.prevent="sendMessage()" class="flex items-center space-x-4">
        <div class="flex-1 relative">
          <textarea x-model="currentMessage"
            placeholder="Nhập câu hỏi của bạn..."
            rows="1"
            class="w-full border-2 border-gray-200 rounded-2xl px-5 py-4 text-base focus:outline-none focus:ring-0 focus:border-blue-400 resize-none transition-colors duration-200 bg-gray-50 focus:bg-white"
            :disabled="isLoading"
            maxlength="1000"
            @input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'"
            style="min-height: 52px; max-height: 140px;"></textarea>

          <!-- Character Count -->
          <div class="absolute bottom-2 right-4 text-sm text-gray-400" x-show="currentMessage.length > 0">
            <span x-text="currentMessage.length"></span>/1000
          </div>
        </div>

        <button type="submit"
          :disabled="isLoading || !currentMessage.trim()"
          class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 disabled:from-gray-300 disabled:to-gray-400 text-white rounded-2xl transition-all duration-200 transform hover:scale-105 disabled:hover:scale-100 shadow-lg hover:shadow-xl disabled:shadow-sm flex items-center justify-center group">
          <template x-if="!isLoading">
            <svg class="w-6 h-6 transform group-hover:translate-x-0.5 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
            </svg>
          </template>
          <template x-if="isLoading">
            <svg class="w-6 h-6 animate-spin" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
          </template>
        </button>
      </form>

      <!-- Quick Actions -->
      <div x-show="hasStarted && !isLoading" class="flex flex-wrap gap-3 mt-5">
        <button @click="showFAQ()"
          class="inline-flex items-center px-4 py-2.5 text-sm font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-full transition-colors duration-200">
          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
          Xem FAQ
        </button>
        <button @click="clearChat()"
          class="inline-flex items-center px-4 py-2.5 text-sm font-medium text-gray-600 bg-gray-50 hover:bg-gray-100 rounded-full transition-colors duration-200">
          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
          </svg>
          Xóa chat
        </button>
        <div class="flex-1"></div>
        <div class="text-sm text-gray-400 flex items-center">
          <div class="w-3 h-3 bg-green-400 rounded-full mr-2 animate-pulse"></div>
          Powered by AI
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  function chatbot() {
    return {
      isOpen: false,
      isLoading: false,
      hasStarted: false,
      currentMessage: '',
      messages: [],
      suggestions: [],
      faqItems: [],
      welcomeMessage: '',
      userRole: 'guest',
      userName: 'Khách',

      init() {
        this.loadInitialData();
      },

      toggleChat() {
        this.isOpen = !this.isOpen;
        if (this.isOpen && !this.hasStarted) {
          this.loadInitialData();
        }
      },

      async loadInitialData() {
        try {
          const response = await fetch('/chatbot/initial-data');
          const data = await response.json();

          if (data.success) {
            this.welcomeMessage = data.welcome_message;
            this.suggestions = data.suggestions || [];
            this.userRole = data.user_role;
            this.userName = data.user_name;
          }
        } catch (error) {
          console.error('Error loading initial data:', error);
          this.welcomeMessage = 'Xin chào! Tôi là trợ lý AI của hệ thống LMS. Tôi có thể giúp gì cho bạn?';
        }

        this.loadFAQ();
      },

      async loadFAQ() {
        try {
          const response = await fetch('/chatbot/faq');
          const data = await response.json();

          if (data.success) {
            this.faqItems = data.faq || [];
          }
        } catch (error) {
          console.error('Error loading FAQ:', error);
        }
      },

      async sendMessage() {
        if (!this.currentMessage.trim() || this.isLoading) return;

        const userMessage = this.currentMessage.trim();
        this.hasStarted = true;

        // Add user message
        this.addMessage(userMessage, true);
        this.currentMessage = '';
        this.isLoading = true;

        try {
          const response = await fetch('/chatbot/send-message', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
              message: userMessage
            })
          });

          const data = await response.json();

          if (data.success) {
            this.addMessage(data.message, false);
            if (data.suggestions) {
              this.suggestions = data.suggestions;
            }
          } else {
            this.addMessage('Xin lỗi, tôi đang gặp sự cố. Vui lòng thử lại sau.', false);
          }
        } catch (error) {
          console.error('Error sending message:', error);
          this.addMessage('Đã xảy ra lỗi kết nối. Vui lòng kiểm tra mạng và thử lại.', false);
        } finally {
          this.isLoading = false;
          this.scrollToBottom();
        }
      },

      sendSuggestion(suggestion) {
        this.currentMessage = suggestion;
        this.sendMessage();
      },

      addMessage(content, isUser) {
        this.messages.push({
          id: Date.now(),
          content: content,
          isUser: isUser,
          time: new Date().toLocaleTimeString('vi-VN', {
            hour: '2-digit',
            minute: '2-digit'
          })
        });

        this.$nextTick(() => {
          // Add entrance animation to new message
          const messageElements = this.$refs.messagesContainer.querySelectorAll('.message-bubble');
          const lastMessage = messageElements[messageElements.length - 1];
          if (lastMessage) {
            lastMessage.style.opacity = '0';
            lastMessage.style.transform = 'translateY(10px)';
            setTimeout(() => {
              lastMessage.style.transition = 'all 0.3s ease-out';
              lastMessage.style.opacity = '1';
              lastMessage.style.transform = 'translateY(0)';
            }, 50);
          }

          this.scrollToBottom();
        });
      },

      scrollToBottom() {
        const container = this.$refs.messagesContainer;
        if (container) {
          container.scrollTop = container.scrollHeight;
        }
      },

      showFAQ() {
        let faqText = "📋 Câu hỏi thường gặp:\n\n";
        this.faqItems.forEach((item, index) => {
          faqText += `${index + 1}. ${item.question}\n${item.answer}\n\n`;
        });
        this.addMessage(faqText, false);
      },

      clearChat() {
        this.messages = [];
        this.hasStarted = false;
        this.currentMessage = '';
      }
    }
  }
</script>

<style>
  [x-cloak] {
    display: none !important;
  }

  /* Custom scrollbar for chat messages */
  .chatbot-scrollbar::-webkit-scrollbar {
    width: 4px;
  }

  .chatbot-scrollbar::-webkit-scrollbar-track {
    background: transparent;
  }

  .chatbot-scrollbar::-webkit-scrollbar-thumb {
    background: linear-gradient(45deg, #3b82f6, #8b5cf6);
    border-radius: 2px;
  }

  .chatbot-scrollbar::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(45deg, #2563eb, #7c3aed);
  }

  /* Smooth message entrance animation */
  @keyframes messageSlideIn {
    from {
      opacity: 0;
      transform: translateY(10px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .message-enter {
    animation: messageSlideIn 0.3s ease-out forwards;
  }

  /* Floating button animation */
  @keyframes float {

    0%,
    100% {
      transform: translateY(0px);
    }

    50% {
      transform: translateY(-3px);
    }
  }

  .floating-animation {
    animation: float 3s ease-in-out infinite;
  }

  /* Gradient text animation */
  @keyframes gradientShift {
    0% {
      background-position: 0% 50%;
    }

    50% {
      background-position: 100% 50%;
    }

    100% {
      background-position: 0% 50%;
    }
  }

  .gradient-text {
    background: linear-gradient(-45deg, #3b82f6, #8b5cf6, #ec4899, #3b82f6);
    background-size: 400% 400%;
    animation: gradientShift 3s ease infinite;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
  }

  /* Typing animation for loading */
  @keyframes typing {

    0%,
    60%,
    100% {
      transform: translateY(0);
    }

    30% {
      transform: translateY(-10px);
    }
  }

  .typing-dot:nth-child(1) {
    animation-delay: 0ms;
  }

  .typing-dot:nth-child(2) {
    animation-delay: 100ms;
  }

  .typing-dot:nth-child(3) {
    animation-delay: 200ms;
  }

  /* Message bubble hover effect */
  .message-bubble {
    transition: all 0.2s ease;
  }

  .message-bubble:hover {
    transform: scale(1.01);
  }

  /* Smooth transitions */
  .smooth-transition {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  }
</style>