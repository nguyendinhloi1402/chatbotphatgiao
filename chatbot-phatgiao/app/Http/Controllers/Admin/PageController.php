<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use Illuminate\Support\Str;

class PageController extends Controller
{
    // Danh sách trang
    public function index()
    {
        $pages = Page::latest()->get();
        return view('admin.pages.index', compact('pages'));
    }

    // Hiển thị form tạo
    public function create()
    {
        return view('admin.pages.create');
    }

    // Lưu trang mới
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|unique:pages,slug',
            'content' => 'required',
        ]);

        Page::create([
            'title' => $request->title,
            'slug' => Str::slug($request->slug),
            'content' => $request->content,
        ]);

        return redirect()->route('admin.pages.index')->with('success', 'Đã tạo trang thành công!');
    }

    // Hiển thị form sửa
    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    // Cập nhật trang
    public function update(Request $request, Page $page)
    {
        $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|unique:pages,slug,' . $page->id,
            'content' => 'required',
        ]);

        $page->update([
            'title' => $request->title,
            'slug' => Str::slug($request->slug),
            'content' => $request->content,
        ]);

        return redirect()->route('admin.pages.index')->with('success', 'Đã cập nhật trang!');
    }

    // Xoá trang
    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->route('admin.pages.index')->with('success', 'Đã xoá trang!');
    }
}

