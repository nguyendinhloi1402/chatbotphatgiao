@extends('layouts.admin')

@section('content')
<h4 class="mb-3">📝 Tạo Trang mới</h4>

<form action="{{ route('admin.pages.store') }}" method="POST">
  @csrf
  <div class="mb-3">
    <label for="title" class="form-label">Tiêu đề</label>
    <input type="text" name="title" class="form-control" required>
  </div>

  <div class="mb-3">
    <label for="slug" class="form-label">Slug (đường dẫn)</label>
    <input type="text" name="slug" class="form-control" placeholder="vd: gioi-thieu" required>
  </div>

  <div class="mb-3">
    <label for="content" class="form-label">Nội dung</label>
    <textarea name="content" rows="6" class="form-control" required></textarea>
  </div>

  <button type="submit" class="btn btn-success">Lưu</button>
  <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">Huỷ</a>
</form>
@endsection
