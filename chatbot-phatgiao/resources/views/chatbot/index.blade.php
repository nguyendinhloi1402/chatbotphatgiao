<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> Chatbot Phật giáo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'M PLUS Rounded 1c', sans-serif;
      background: #f3f4f6 url('https://i.imgur.com/TFX7vZq.jpg') no-repeat center center;
      background-size: cover;
    }

    .container-chat {
      display: flex;
      height: 100vh;
      backdrop-filter: blur(4px);
      position: relative;
      transition: all 0.3s ease;
    }

    .sidebar {
      width: 360px;
      background-color: rgba(255,255,255,0.95);
      border-right: 1px solid #dee2e6;
      padding: 1rem;
      display: flex;
      flex-direction: column;
      height: 100vh;
      overflow: hidden;
      transition: transform 0.3s ease;
    }

    .sidebar ul {
      overflow-y: auto;
      flex: 1;
    }

    .sidebar.collapsed {
      transform: translateX(-100%);
    }

    .container-chat.fullscreen .chatbox {
      width: 100% !important;
    }

    .container-chat.fullscreen .sidebar {
      display: none !important;
    }

    .chatbox {
      flex: 1;
      display: flex;
      flex-direction: column;
      padding: 1.5rem;
      background-color: rgba(255,255,255,0.95);
      height: 100vh;
      overflow: hidden;
      transition: width 0.3s ease;
    }

    .messages {
      flex: 1;
      overflow-y: auto;
      margin-bottom: 1rem;
      padding-right: 0.5rem;
    }

    .message {
      max-width: 75%;
      padding: 12px 16px;
      border-radius: 16px;
      margin-bottom: 10px;
      white-space: pre-wrap;
      line-height: 1.6;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
    }

    .user-msg {
      background-color: #e6f4ea;
      color: #234d20;
      margin-left: auto;
      text-align: right;
    }

    .bot-msg {
      background-color: #fff9e6;
      color: #5b4e00;
      margin-right: auto;
      text-align: left;
      border-left: 4px solid #e0c97f;
      font-style: italic;
      position: relative;
    }

    .copy-btn {
      font-size: 0.8rem;
      position: absolute;
      top: 8px;
      right: 12px;
      padding: 2px 6px;
      border-radius: 8px;
      background: #f5f5f5;
      border: 1px solid #ccc;
      cursor: pointer;
      transition: background 0.3s;
    }

    .copy-btn:hover {
      background-color: #ddd;
    }

    .chat-header h4 {
      margin-bottom: 4px;
    }

    .chat-header p {
      font-size: 0.95rem;
      color: #6c757d;
    }

    .user-info .btn {
      font-size: 1rem;
      padding: 6px 12px;
      border-radius: 8px;
    }

    .user-info {
      font-size: 1.1rem;
    }

    .chat-form input::placeholder {
      color: #999;
    }

    #toggleSidebarBtn {
      z-index: 999;
      position: fixed;
      top: 10px;
      left: 20px;
    }
  </style>
</head>
<body>
  <div class="container-chat" id="chatContainer">
    <!-- Sidebar toggle button -->
    <button id="toggleSidebarBtn" class="btn btn-light shadow-sm rounded-circle">
      <i class="bi bi-layout-sidebar-inset fs-5" id="toggleIcon"></i>
    </button>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0 ms-5">Lịch sử chat</h5>
        <form action="/chat/new" method="GET">
          <button class="btn btn-sm btn-outline-primary">
            <i class="bi bi-plus-circle"></i> Mới
          </button>
        </form>
      </div>
      <input type="text" id="search" oninput="filterChats()" class="form-control mb-3" placeholder="🔍 Tìm đoạn chat...">
      <ul class="list-group" id="conversation-list">
        @foreach($conversations as $conv)
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <a href="/conversations/{{ $conv->id }}" class="text-decoration-none flex-grow-1">
              {{ $conv->title ?? 'Chat #' . $conv->id }}
            </a>
            <form method="POST" action="/conversations/{{ $conv->id }}" onsubmit="return confirm('Xóa đoạn chat này?')">
              @csrf
              @method('DELETE')
              <button class="btn btn-sm btn-outline-danger ms-2">
                <i class="bi bi-trash"></i>
              </button>
            </form>
          </li>
        @endforeach
      </ul>
    </div>

    <!-- Chatbox -->
    <div class="chatbox">
      @auth
      <div class="d-flex justify-content-end align-items-center mb-2">
        <div class="d-flex align-items-center gap-3 user-info">
          <div class="fw-semibold">👤 {{ Auth::user()->name }}</div>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-secondary btn-sm fw-bold">Đăng xuất</button>
          </form>
        </div>
      </div>
      @endauth

      <div class="chat-header text-center mb-3">
        <h4 class="mb-1">🙏 Hệ thống Chatbot Phật giáo</h4>
        <p class="text-muted">Hỏi đáp giáo lý – Thiền định – Tâm linh – Nhân quả 🌸</p>
      </div>

      <div class="messages" id="chat-messages">
        @foreach ($history as $item)
          <!-- Tin nhắn người dùng -->
          <div class="message user-msg">
            <strong>💬 Bạn:</strong><br>
            {{ $item['question'] }}
          </div>

          <!-- Tin nhắn từ bot -->
          <div class="message bot-msg">
            <strong>🌸 Bot:</strong>
            <button class="copy-btn" onclick="copyToClipboard(this)">📋</button>
            <div class="bot-content mt-2">
              {!! nl2br(e($item['answer'])) !!}
            </div>
          </div>
        @endforeach

        <div id="typing-indicator" class="message bot-msg d-none">
          <strong>Bot:</strong> <span id="typing-text"><em>Đang gõ...</em></span>
        </div>
      </div>

      <!-- Chat form -->
      <form method="POST" action="/chat" onsubmit="showLoading()" class="chat-form d-flex align-items-center gap-2 bg-white border rounded-4 px-3 py-2 shadow-sm" style="margin-top: auto;">
        @csrf
        <i class="bi bi-chat-text fs-4 text-muted"></i>
        <input
          type="text"
          name="question"
          class="form-control border-0 shadow-none"
          placeholder="Hỏi điều gì về Phật giáo hôm nay..."
          required
          autofocus
          style="font-size: 1.05rem; background: transparent;"
        >
        <button type="submit" class="btn btn-success rounded-pill px-4 fw-semibold d-flex align-items-center gap-1" id="sendBtn">
          <i class="bi bi-send"></i> Gửi
        </button>
      </form>

      <!-- Clear -->
      <form action="/chat/clear" method="POST" class="text-end mt-2">
        @csrf
        <button class="btn btn-outline-danger btn-sm">🗑️ Xóa đoạn chat</button>
      </form>
    </div>
  </div>

  <!-- Scripts -->
  <script>
    const chatBox = document.getElementById("chat-messages");
    chatBox.scrollTop = chatBox.scrollHeight;

    function showLoading() {
      const btn = document.getElementById("sendBtn");
      btn.disabled = true;
      btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Đang gửi...';

      const typing = document.getElementById("typing-indicator");
      const textEl = document.getElementById("typing-text");

      typing.classList.remove("d-none");
      textEl.innerHTML = "";

      const typingText = "Bot: Đang gõ câu trả lời...";
      let index = 0;

      const interval = setInterval(() => {
        if (index < typingText.length) {
          textEl.innerHTML += typingText.charAt(index);
          index++;
          chatBox.scrollTop = chatBox.scrollHeight;
        } else {
          clearInterval(interval);
        }
      }, 50);
    }

    function filterChats() {
      const input = document.getElementById("search").value.toLowerCase();
      const items = document.querySelectorAll("#conversation-list li");
      items.forEach(item => {
        const text = item.innerText.toLowerCase();
        item.style.display = text.includes(input) ? "" : "none";
      });
    }

    function copyToClipboard(btn) {
      const content = btn.closest('.bot-msg').querySelector('.bot-content').innerText;
      navigator.clipboard.writeText(content).then(() => {
        btn.innerText = '✅';
        setTimeout(() => btn.innerText = '📋', 1500);
      });
    }

    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('toggleSidebarBtn');
    const toggleIcon = document.getElementById('toggleIcon');
    const container = document.getElementById('chatContainer');

    toggleBtn.addEventListener('click', () => {
      sidebar.classList.toggle('collapsed');
      toggleIcon.classList.toggle('bi-layout-sidebar-inset');
      toggleIcon.classList.toggle('bi-layout-sidebar-reverse');
      container.classList.toggle('fullscreen');
    });
  </script>
</body>
</html>