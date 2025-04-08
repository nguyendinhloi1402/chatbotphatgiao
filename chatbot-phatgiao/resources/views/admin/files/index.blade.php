@extends('layouts.admin')

@section('content')
<div class="container">
    <h4 class="mb-4">📁 Thư viện File</h4>

    <a href="{{ route('admin.files.create') }}" class="btn btn-success mb-3">
        <i class="bi bi-cloud-arrow-up"></i> Tải file mới
    </a>

    @if($files->count())
        <div class="row">
            @foreach($files as $file)
                <div class="col-md-3 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <p class="mb-2"><strong>{{ $file->name }}</strong></p>
                            <a href="{{ asset('storage/' . $file->path) }}" class="btn btn-outline-primary btn-sm" target="_blank">
                                <i class="bi bi-box-arrow-up-right"></i> Xem
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>Chưa có file nào được tải lên.</p>
    @endif
</div>
@endsection

