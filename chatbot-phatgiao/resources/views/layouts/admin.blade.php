<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>🌟 Quản trị Chatbot</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f8f9fa;
    }

    .wrapper {
      display: flex;
    }

    .sidebar {
      width: 250px;
      background-color: #212529;
      min-height: 100vh;
      transition: all 0.3s;
    }

    .sidebar.collapsed {
      width: 80px;
    }

    .sidebar .nav-link {
      color: #f8f9fa;
      padding: 10px 15px;
      border-radius: 8px;
      margin: 4px 0;
    }

    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
      background-color: #495057;
      color: #ffc107;
    }

    .sidebar .logo {
      font-size: 1.3rem;
      font-weight: bold;
      color: #fff;
      margin: 1rem 1rem 1.5rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .content {
      flex: 1;
      padding: 2rem;
    }

    .topbar {
      display: flex;
      justify-content: flex-end;
      align-items: center;
      margin-bottom: 1.5rem;
    }

    .dropdown-toggle::after {
      display: none;
    }

    .sidebar-toggler {
      background: none;
      border: none;
      color: #fff;
      font-size: 1.25rem;
    }
  </style>
</head>
<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
      <div class="logo d-flex justify-content-between align-items-center">
        <span>📋 Admin</span>
        <button class="sidebar-toggler" onclick="toggleSidebar()">
          <i class="bi bi-list"></i>
        </button>
      </div>

      <ul class="nav flex-column px-2">
        <li><a href="{{ route('admin.dashboard') }}" class="nav-link"><i class="bi bi-house-door me-2"></i> <span class="link-text">Trang chính</span></a></li>
        <li><a href="{{ route('admin.users.index') }}" class="nav-link"><i class="bi bi-people me-2"></i> <span class="link-text">Người dùng</span></a></li>
        <li><a href="/admin/pages" class="nav-link"><i class="bi bi-file-earmark-text me-2"></i> <span class="link-text">Trang tĩnh</span></a></li>
        <li><a href="/admin/posts" class="nav-link"><i class="bi bi-journal-text me-2"></i> <span class="link-text">Bài viết</span></a></li>
        <li><a href="/admin/files" class="nav-link"><i class="bi bi-folder me-2"></i> <span class="link-text">Thư viện</span></a></li>
        <li><a href="/" class="nav-link"><i class="bi bi-box-arrow-left me-2"></i> <span class="link-text">Về chatbot</span></a></li>
      </ul>
    </div>

    <!-- Content -->
    <div class="content">
      <div class="topbar">
        <div class="dropdown">
          <a href="#" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown">
            👤 {{ Auth::user()->name }}
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Hồ sơ</a></li>
            <li>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="dropdown-item text-danger" type="submit">
                  <i class="bi bi-box-arrow-right"></i> Đăng xuất
                </button>
              </form>
            </li>
          </ul>
        </div>
      </div>

      @yield('content')
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      sidebar.classList.toggle('collapsed');
    }
  </script>
</body>
</html>
