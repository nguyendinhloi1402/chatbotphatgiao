@extends('layouts.admin')

@section('content')
<h4 class="mb-3">✏️ Sửa Trang: {{ $page->title }}</h4>

<form action="{{ route('admin.pages.update', $page) }}" method="POST">
  @csrf
  @method('PUT')

  <div class="mb-3">
    <label class="form-label">Tiêu đề</label>
    <input type="text" name="title" value="{{ $page->title }}" class="form-control" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Slug</label>
    <input type="text" name="slug" value="{{ $page->slug }}" class="form-control" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Nội dung</label>
    <textarea name="content" rows="6" class="form-control" required>{{ $page->content }}</textarea>
  </div>

  <button type="submit" class="btn btn-primary">Cập nhật</button>
  <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">Quay lại</a>
</form>
@endsection
