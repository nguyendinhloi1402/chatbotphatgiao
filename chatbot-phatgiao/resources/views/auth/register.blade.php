@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c&display=swap');

    body {
        background-color: #f0f4f8;
        background-image: url('https://i.imgur.com/TFX7vZq.jpg');
        background-repeat: no-repeat;
        background-size: cover;
        font-family: 'M PLUS Rounded 1c', sans-serif;
    }

    .register-wrapper {
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 2rem;
        backdrop-filter: blur(4px);
    }

    .register-card {
        width: 100%;
        max-width: 600px;
        border-radius: 24px;
        padding: 3rem;
        background: rgba(255, 255, 255, 0.92);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        font-size: 1.1rem;
    }

    .register-card h3 {
        font-weight: bold;
        font-size: 2rem;
        margin-bottom: 0.25rem;
        color: #212529;
    }

    .register-card .sub-title {
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

    .btn-register {
        background-color: #0d6efd;
        color: white;
        font-size: 1.25rem;
        font-weight: bold;
        border: none;
        border-radius: 12px;
        padding: 0.75rem;
        width: 100%;
    }

    .btn-register:hover {
        background-color: #0b5ed7;
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

    .register-card a {
        font-size: 1rem;
        text-decoration: none;
    }
</style>

<div class="register-wrapper">
    <div class="register-card">
        <div class="text-center mb-4">
            <h3>Đăng ký tài khoản</h3>
            <p class="sub-title">Tham gia cộng đồng Phật tử cùng Chatbot trí tuệ nhân tạo 🙏</p>
        </div>

        <form id="registerForm" method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="form-group-horizontal mb-4">
                <label class="form-label" for="name">Họ tên</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}"
                       class="form-control @error('name') is-invalid @enderror"
                       placeholder="Nhập họ tên..." required autofocus>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email -->
            <div class="form-group-horizontal mb-4">
                <label class="form-label" for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                       class="form-control @error('email') is-invalid @enderror"
                       placeholder="Nhập email..." required>
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

            <!-- Confirm Password -->
            <div class="form-group-horizontal mb-4">
                <label class="form-label" for="password_confirmation">Xác nhận</label>
                <input id="password_confirmation" type="password" name="password_confirmation"
                       class="form-control"
                       placeholder="Xác nhận mật khẩu..." required>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex gap-3 mb-4">
                <button type="submit" class="btn-register">Đăng ký</button>
                <button type="button" class="btn-cancel" onclick="resetForm()">Huỷ</button>
            </div>

            <!-- Login link -->
            <div class="text-center">
                <a href="{{ route('login') }}">🔒 Đã có tài khoản? <strong>Đăng nhập</strong></a>
            </div>
        </form>
    </div>
</div>

<script>
    function resetForm() {
        document.getElementById('registerForm').reset();
    }
</script>
@endsection
