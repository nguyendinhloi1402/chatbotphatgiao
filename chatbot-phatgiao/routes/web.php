<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\FileController;

// Trang welcome (khi chưa đăng nhập)
Route::get('/', function () {
    return view('welcome');
});

// Điều hướng sau đăng nhập theo vai trò
Route::get('/dashboard', function () {
    $user = auth()->user();
    return $user && $user->role === 'admin'
        ? redirect()->route('admin.dashboard')
        : redirect('/chat');
})->middleware(['auth', 'verified'])->name('dashboard');

// 🌿 Người dùng (user) - cần đăng nhập
Route::middleware(['auth'])->group(function () {
    // Trang cá nhân
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Chatbot Phật giáo
    Route::get('/chat', [ChatbotController::class, 'index']);
    Route::post('/chat', [ChatbotController::class, 'chat']);
    Route::post('/chat/clear', [ChatbotController::class, 'clear']);
    Route::get('/chat/new', [ChatbotController::class, 'newConversation']);

    // Cuộc trò chuyện
    Route::get('/conversations', [ConversationController::class, 'index']);
    Route::get('/conversations/{id}', [ConversationController::class, 'show']);
    Route::delete('/conversations/{id}', [ConversationController::class, 'destroy']);
});

// 🌟 Quản trị admin
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    // Trang chính admin
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    // Quản lý người dùng (chỉ index, edit, update, delete)
    Route::resource('users', UserController::class)
        ->names('users')
        ->except(['create', 'store', 'show']);

    // Trang tĩnh
    Route::resource('pages', PageController::class);

    // Bài viết: FULL CRUD (bao gồm cả create & store)
    Route::resource('posts', PostController::class)->names('posts');

    // Upload File / Thư viện
    Route::get('/files', [FileController::class, 'index'])->name('files.index');
    Route::get('/files/upload', [FileController::class, 'create'])->name('files.create');
    Route::post('/files', [FileController::class, 'store'])->name('files.store');
});

require __DIR__.'/auth.php';
