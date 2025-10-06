<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Task;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $taskId)
    {
        $request->validate([
            'body' => 'required|string',
        ]);

        $task = Task::findOrFail($taskId);
        $user = Auth::user();

        $comment = Comment::create([
            'task_id' => $task->id,
            'author_id' => $user->id,
            'body' => $request->body,
        ]);

        AuditLog::create([
            'user_id' => $user->id,
            'auditable_type' => Task::class,
            'auditable_id' => $task->id,
            'action' => 'comment_added',
            'new_values' => ['body' => $request->body],
        ]);

        return back()->with('success', 'Comment added successfully!');
    }
}
