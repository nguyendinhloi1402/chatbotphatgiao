// File: resources/views/admin/posts/index.blade.php

@extends('layouts.admin')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold">📝 Bài viết</h4>
    <a href="{{ route('admin.posts.create') }}" class="btn btn-success">
        <i class="bi bi-plus-circle"></i> Thêm bài viết
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Tiêu đề</th>
            <th>Slug</th>
            <th>Ngày tạo</th>
            <th width="150">Hành động</th>
        </tr>
    </thead>
    <tbody>
        @forelse($posts as $post)
        <tr>
            <td>{{ $post->title }}</td>
            <td>{{ $post->slug }}</td>
            <td>{{ $post->created_at->format('d/m/Y') }}</td>
            <td>
                <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-sm btn-warning">Sửa</a>
                <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="d-inline" onsubmit="return confirm('Xoá?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Xoá</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="4">Chưa có bài viết nào.</td></tr>
        @endforelse
    </tbody>
</table>

{{ $posts->links() }}
@endsection
