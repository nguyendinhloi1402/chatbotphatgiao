@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4><i class="bi bi-plus-circle"></i> Thêm Bài viết mới</h4>
    <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary btn-sm">← Quay lại</a>
</div>

<form action="{{ route('admin.posts.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="title" class="form-label">Tiêu đề</label>
        <input type="text" class="form-control" id="title" name="title" required>
    </div>

    <div class="mb-3">
        <label for="slug" class="form-label">Slug (tự động hoặc tùy chọn)</label>
        <input type="text" class="form-control" id="slug" name="slug">
    </div>

    <div class="mb-3">
        <label for="content" class="form-label">Nội dung</label>
        <textarea class="form-control" id="content" name="content" rows="8"></textarea>
    </div>

    <button type="submit" class="btn btn-success">💾 Lưu bài viết</button>
</form>
@endsection
