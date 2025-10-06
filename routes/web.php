<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| All routes that use sessions, authentication, or Blade views
| must go inside the 'web' middleware group.
|--------------------------------------------------------------------------
*/

Route::middleware('web')->group(function () {

    // 🔹 Authentication Routes
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'webLogin'])->name('web.login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // 🔹 Debug Route (to confirm session works)
    Route::get('/debug-auth', function () {
        $user = Auth::user();
        return [
            'logged_in' => Auth::check(),
            'user' => $user,
            'role' => $user?->role->name,
        ];
    });

    // 🔹 Default Redirect
    Route::get('/', function () {
        return redirect()->route('tasks.index');
    });

    // 🔹 Protected Routes (only for logged-in users)
    Route::middleware(['auth'])->group(function () {

        // Requester / Contributor Routes
        Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
        Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
        Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
        Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
        Route::post('/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');

        // Comments
        Route::post('/tasks/{task}/comments', [CommentController::class, 'store'])->name('comments.store');

        // Admin-only Routes
        Route::middleware('can:isAdmin')->group(function () {
            Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
            Route::post('/admin/tasks/{task}/reassign', [AdminController::class, 'reassign'])->name('admin.reassign');
            Route::post('/admin/tasks/{task}/cancel', [AdminController::class, 'cancel'])->name('admin.cancel');
        });
    });
});
