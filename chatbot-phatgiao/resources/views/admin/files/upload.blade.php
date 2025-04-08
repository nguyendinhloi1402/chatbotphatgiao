@extends('layouts.admin')

@section('content')
<div class="container">
    <h4 class="mb-4">📤 Tải file lên thư viện</h4>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.files.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" class="form-control mb-3" required>
        <button class="btn btn-primary"><i class="bi bi-upload"></i> Tải lên</button>
    </form>
</div>
@endsection
