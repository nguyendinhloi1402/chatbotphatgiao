@extends('layouts.admin')

@section('content')
<div class="container">
  <h3 class="mb-4">🧑‍💼 Chỉnh sửa người dùng</h3>

  @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
      <label for="name" class="form-label">Họ tên</label>
      <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
             class="form-control @error('name') is-invalid @enderror">
      @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
             class="form-control @error('email') is-invalid @enderror">
      @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="role" class="form-label">Vai trò</label>
      <select name="role" id="role" class="form-select">
        <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Người dùng</option>
        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Quản trị</option>
      </select>
    </div>

    <div class="mb-3">
      <label for="password" class="form-label">Mật khẩu (nếu muốn thay đổi)</label>
      <input type="password" name="password" id="password" class="form-control">
    </div>

    <button type="submit" class="btn btn-success">Lưu thay đổi</button>
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Quay lại</a>
  </form>
</div>
@endsection
