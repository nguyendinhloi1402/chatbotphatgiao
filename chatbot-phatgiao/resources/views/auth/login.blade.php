@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c&display=swap');

    body {
        background-color: #f0f4f8;
        background-image: url('https://i.imgur.com/TFX7vZq.jpg'); /* Hình nền hoa sen nhẹ */
        background-repeat: no-repeat;
        background-size: cover;
        font-family: 'M PLUS Rounded 1c', sans-serif;
    }

    .login-wrapper {
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 2rem;
        backdrop-filter: blur(4px);
    }

    .login-card {
        width: 100%;
        max-width: 600px;
        border-radius: 24px;
        padding: 3rem;
        background: rgba(255, 255, 255, 0.92);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        font-size: 1.1rem;
    }

    .login-card h3 {
        font-weight: bold;
        font-size: 2rem;
        margin-bottom: 0.25rem;
        color: #212529;
    }

    .login-card .sub-title {
        font-size: 1rem;
        color: #6c757d;
        margin-bottom: 1.25rem;
    }

    .form-group-horizontal {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-group-horizontal .form-label {
        width: 100px;
        margin-bottom: 0;
        font-weight: 600;
    }

    .form-group-horizontal .form-control {
        flex: 1;
        height: 50px;
        font-size: 1.05rem;
        border-radius: 12px;
    }

    .login-card .form-check-label {
        font-size: 1rem;
    }

    .btn-login {
        background-color: #198754;
        color: white;
        font-size: 1.25rem;
        font-weight: bold;
        border: none;
        border-radius: 12px;
        padding: 0.75rem;
        width: 100%;
    }

    .btn-login:hover {
        background-color: #157347;
    }

    .btn-cancel {
        background-color: #e0e0e0;
        font-size: 1.1rem;
        border: none;
        border-radius: 12px;
        padding: 0.75rem;
        width: 100%;
        color: #333;
    }

    .btn-cancel:hover {
        background-color: #d6d6d6;
    }

    .login-card a {
        font-size: 1rem;
        text-decoration: none;
    }
</style>

<div class="login-wrapper">
    <div class="login-card">
        <div class="text-center mb-4">
            <h3>Đăng nhập Chatbot Phật giáo</h3>
            <p class="sub-title">Hệ thống hỗ trợ Phật tử bằng trí tuệ nhân tạo 🌸</p>
        </div>

        <form id="loginForm" method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="form-group-horizontal mb-4">
                <label class="form-label" for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                       class="form-control @error('email') is-invalid @enderror"
                       placeholder="Nhập email..." required autofocus>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group-horizontal mb-4">
                <label class="form-label" for="password">Mật khẩu</label>
                <input id="password" type="password" name="password"
                       class="form-control @error('password') is-invalid @enderror"
                       placeholder="Nhập mật khẩu..." required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Remember -->
            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex gap-3 mb-4">
                <button type="submit" class="btn-login">Đăng nhập</button>
                <button type="button" class="btn-cancel" onclick="resetForm()">Huỷ</button>
            </div>

            <!-- Register link -->
            <div class="text-center">
                <a href="{{ route('register') }}">📚 Chưa có tài khoản? <strong>Đăng ký</strong></a>
            </div>
        </form>
    </div>
</div>

<script>
    function resetForm() {
        document.getElementById('loginForm').reset();
    }
</script>
@endsection
