<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\File;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function index()
    {
        $files = File::latest()->get();
        return view('admin.files.index', compact('files'));
    }

    public function create()
    {
        return view('admin.files.upload');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // max 10MB
        ]);

        $uploaded = $request->file('file');
        $path = $uploaded->store('uploads', 'public');

        $file = new File();
        $file->name = $uploaded->getClientOriginalName();
        $file->path = $path;
        $file->mime_type = $uploaded->getClientMimeType();
        $file->size = $uploaded->getSize();
        $file->save();

        return redirect()->route('admin.files.index')->with('success', 'Tải file lên thành công!');
    }
}
