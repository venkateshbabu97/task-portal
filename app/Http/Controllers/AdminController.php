<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $tasks = Task::with(['requester', 'assignee'])->latest()->get();
        $users = User::all();

        return view('admin.dashboard', compact('tasks', 'users'));
    }

    public function reassign(Request $request, Task $task)
    {
        $request->validate(['assignee_id' => 'required|exists:users,id']);
        $oldAssignee = $task->assignee_id;

        $task->update(['assignee_id' => $request->assignee_id]);

        AuditLog::create([
            'user_id' => Auth::id(),
            'auditable_type' => Task::class,
            'auditable_id' => $task->id,
            'action' => 'reassigned',
            'old_values' => ['assignee_id' => $oldAssignee],
            'new_values' => ['assignee_id' => $request->assignee_id],
        ]);

        return back()->with('success', 'Task reassigned successfully!');
    }

    public function cancel(Task $task)
    {
        $oldStatus = $task->status;
        $task->update(['status' => 'CANCELLED']);

        AuditLog::create([
            'user_id' => Auth::id(),
            'auditable_type' => Task::class,
            'auditable_id' => $task->id,
            'action' => 'cancelled',
            'old_values' => ['status' => $oldStatus],
            'new_values' => ['status' => 'CANCELLED'],
        ]);

        return back()->with('success', 'Task cancelled successfully!');
    }
}
