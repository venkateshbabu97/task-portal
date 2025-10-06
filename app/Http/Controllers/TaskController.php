<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role->name === 'Admin') {
            $tasks = Task::with(['requester', 'assignee'])->latest()->get();
        } elseif ($user->role->name === 'Requester') {
            $tasks = Task::where('requester_id', $user->id)->with(['assignee'])->get();
        } else { // Contributor
            $tasks = Task::where('assignee_id', $user->id)->with(['requester'])->get();
        }

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->role->name !== 'Requester') {
            return back()->with('error', 'Only requesters can create tasks');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $task = Task::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? '',
            'requester_id' => $user->id,
            'status' => 'OPEN',
        ]);

        AuditLog::create([
            'user_id' => $user->id,
            'auditable_type' => Task::class,
            'auditable_id' => $task->id,
            'action' => 'created',
            'new_values' => $task->toArray(),
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully!');
    }

    public function show(Task $task)
    {
        $task->load('comments.author', 'requester', 'assignee');
        return view('tasks.show', compact('task'));
    }

    public function updateStatus(Request $request, Task $task)
    {
        $user = Auth::user();
        $validated = $request->validate(['status' => 'required|in:OPEN,IN_PROGRESS,COMPLETED,VERIFIED,CANCELLED']);

        $oldStatus = $task->status;
        $task->update(['status' => $validated['status']]);

        AuditLog::create([
            'user_id' => $user->id,
            'auditable_type' => Task::class,
            'auditable_id' => $task->id,
            'action' => 'status_changed',
            'old_values' => ['status' => $oldStatus],
            'new_values' => ['status' => $validated['status']],
        ]);

        return redirect()->route('tasks.show', $task->id)->with('success', 'Status updated successfully!');
    }
}
