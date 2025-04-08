@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4>📄 Danh sách Trang tĩnh</h4>
  <a href="{{ route('admin.pages.create') }}" class="btn btn-success">
    <i class="bi bi-plus-circle"></i> Thêm trang
  </a>
</div>

<table class="table table-bordered table-hover bg-white shadow-sm">
  <thead class="table-light">
    <tr>
      <th>Tiêu đề</th>
      <th>Slug</th>
      <th>Ngày tạo</th>
      <th width="150">Hành động</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($pages as $page)
      <tr>
        <td>{{ $page->title }}</td>
        <td>{{ $page->slug }}</td>
        <td>{{ $page->created_at->format('d/m/Y') }}</td>
        <td>
          <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-sm btn-primary">Sửa</a>
          <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" class="d-inline" onsubmit="return confirm('Xoá trang này?')">
            @csrf
            @method('DELETE')
            <button class="btn btn-sm btn-danger">Xoá</button>
          </form>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
@endsection
