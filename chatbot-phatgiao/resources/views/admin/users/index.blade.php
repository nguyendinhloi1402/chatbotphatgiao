@extends('layouts.admin')

@section('content')
<div class="container">
  <h3 class="mb-4">📋 Danh sách người dùng</h3>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <!-- Form tìm kiếm -->
  <form method="GET" action="{{ route('admin.users.index') }}" class="mb-4 row g-2">
    <div class="col-md-4">
      <input type="text" name="search" class="form-control" placeholder="🔍 Tên hoặc email..."
             value="{{ request('search') }}">
    </div>
    <div class="col-auto">
      <button class="btn btn-outline-primary">Tìm</button>
    </div>
  </form>

  <table class="table table-bordered align-middle">
    <thead class="table-light">
      <tr>
        <th>ID</th>
        <th>Họ tên</th>
        <th>Email</th>
        <th>Vai trò</th>
        <th>Thao tác</th>
      </tr>
    </thead>
    <tbody>
      @forelse($users as $user)
        <tr>
          <td>{{ $user->id }}</td>
          <td>{{ $user->name }}</td>
          <td>{{ $user->email }}</td>
          <td><span class="badge bg-{{ $user->role === 'admin' ? 'warning text-dark' : 'secondary' }}">
            {{ ucfirst($user->role) }}
          </span></td>
          <td class="d-flex gap-2">
            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-info">
              <i class="bi bi-pencil"></i> Sửa
            </a>
            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Xác nhận xóa?')">
              @csrf
              @method('DELETE')
              <button class="btn btn-sm btn-outline-danger">
                <i class="bi bi-trash"></i>
              </button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="5" class="text-center">Chưa có người dùng</td></tr>
      @endforelse
    </tbody>
  </table>

  {{ $users->withQueryString()->links() }}
</div>
@endsection
