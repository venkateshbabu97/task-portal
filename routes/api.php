use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AdminController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Requester
    Route::middleware('role:Requester')->group(function () {
        Route::post('/tasks', [TaskController::class, 'store']);
        Route::get('/tasks/mine', [TaskController::class, 'myTasks']);
    });

    // Contributor
    Route::middleware('role:Contributor')->group(function () {
        Route::post('/tasks/{task}/comments', [CommentController::class, 'store']);
    });

    // Admin
    Route::middleware('role:Admin')->group(function () {
        Route::get('/admin/tasks', [AdminController::class, 'index']);
        Route::post('/admin/tasks/{task}/reassign', [AdminController::class, 'reassign']);
        Route::post('/admin/tasks/{task}/cancel', [AdminController::class, 'cancel']);
    });

    // Common
    Route::get('/tasks', [TaskController::class, 'index']);
    Route::get('/tasks/{id}', [TaskController::class, 'show']);
});
