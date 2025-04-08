<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>🙏 Chào mừng đến với Chatbot Phật giáo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'M PLUS Rounded 1c', sans-serif;
      background: linear-gradient(to top, #edf4ec, #ffffff);
      overflow: hidden;
    }

    .bg-overlay {
      background: url('https://i.imgur.com/tbqsHbH.jpg') no-repeat center center fixed;
      background-size: cover;
      position: fixed;
      top: 0; left: 0;
      width: 100%;
      height: 100%;
      z-index: -3;
      filter: blur(6px);
    }

    .clouds {
      position: absolute;
      width: 200%;
      height: 100%;
      background: url('https://i.imgur.com/F5r2DNh.png') repeat-x;
      animation: moveClouds 80s linear infinite;
      opacity: 0.12;
      z-index: -2;
    }

    .wave {
      position: absolute;
      bottom: 0;
      width: 100%;
      height: 120px;
      background: url('https://i.imgur.com/3I6pDNK.png') repeat-x;
      animation: waveAnim 30s linear infinite;
      opacity: 0.25;
      z-index: -1;
    }

    @keyframes moveClouds {
      from { background-position-x: 0; }
      to   { background-position-x: -1000px; }
    }

    @keyframes waveAnim {
      0% { background-position-x: 0; }
      100% { background-position-x: 1000px; }
    }

    .overlay-content {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      padding: 2rem;
      position: relative;
      z-index: 1;
    }

    h1 {
      font-size: 3rem;
      font-weight: bold;
      color: #2f471f;
      margin-bottom: 1rem;
    }

    .icon-om {
      font-size: 2.5rem;
      color: #7b5e2a;
      margin-bottom: 10px;
    }

    .quote {
      font-size: 1.5rem;
      font-style: italic;
      max-width: 700px;
      color: #3d3d3d;
      padding: 0 1rem;
      line-height: 1.7;
      min-height: 80px;
    }

    .buttons {
      margin-top: 2.5rem;
    }

    .buttons a {
      margin: 0 10px;
      padding: 0.75rem 2.2rem;
      font-size: 1.15rem;
      border-radius: 12px;
      transition: 0.3s ease;
    }

    .buttons a:hover {
      transform: scale(1.05);
    }

    .footer {
      position: absolute;
      bottom: 10px;
      width: 100%;
      text-align: center;
      font-size: 0.95rem;
      color: #666;
    }

    @media (max-width: 600px) {
      h1 { font-size: 2rem; }
      .quote { font-size: 1.2rem; }
    }
  </style>
</head>
<body>
  @php
    $quotes = [
        "Tâm là gốc của muôn pháp. (Nhất thiết duy tâm tạo)",
        "Không có con đường dẫn đến hạnh phúc. Hạnh phúc chính là con đường.",
        "Buông bỏ không phải là mất, mà là được thảnh thơi.",
        "Thân ở đâu, tâm ở đó – thì an lạc sinh khởi.",
        "Ngồi yên, thở nhẹ – thế giới tự yên bình.",
        "Lời nói đẹp là hoa sen nở trong vườn tâm.",
        "Không tìm cầu bên ngoài. Hãy trở về nương tựa nơi chính mình.",
        "Một nụ cười là khởi đầu của bình an.",
        "Thở vào an, thở ra lạc.",
        "Giữ chánh niệm là giữ hạnh phúc."
    ];
    $quote = $quotes[array_rand($quotes)];
  @endphp

  <div class="bg-overlay"></div>
  <div class="clouds"></div>
  <div class="wave"></div>

  <div class="overlay-content">
    <div class="icon-om">🕉️</div>
    <h1>🙏 Hệ thống Chatbot Phật giáo</h1>
    <p class="quote"><span id="quote-text"></span></p>

    <div class="buttons">
      <a href="/login" class="btn btn-success shadow">Đăng nhập</a>
      <a href="/register" class="btn btn-outline-success">Đăng ký</a>
    </div>
  </div>

  <div class="footer">
    ✨ Nam mô A Di Đà Phật – Chatbot Phật giáo © {{ date('Y') }} ✨
  </div>

  @auth
    <script>window.location.href = "/chat";</script>
  @endauth

  <script>
    const quote = @json($quote);
    const textEl = document.getElementById("quote-text");
    let i = 0;

    function typeEffect() {
      if (i < quote.length) {
        textEl.innerHTML += quote.charAt(i);
        i++;
        setTimeout(typeEffect, 40);
      }
    }

    window.onload = () => {
      typeEffect();
    };
  </script>
</body>
</html>
