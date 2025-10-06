@extends('layouts.app')

@section('content')
<h2>Task #{{ $task->id }} - {{ $task->title }}</h2>

<div class="card mb-3">
    <div class="card-body">
        <p><strong>Description:</strong> {{ $task->description }}</p>
        <p><strong>Status:</strong>
            <span class="badge bg-info">{{ $task->status }}</span>
        </p>
        <p><strong>Requester:</strong> {{ $task->requester->name }}</p>
        <p><strong>Assignee:</strong> {{ $task->assignee->name ?? 'Unassigned' }}</p>
    </div>
</div>

@if(auth()->user()->role->name !== 'Contributor')
<div class="card mb-3">
    <div class="card-header">Update Status</div>
    <div class="card-body">
        <form action="{{ route('tasks.updateStatus', $task->id) }}" method="POST">
            @csrf
            <select name="status" class="form-select w-50 d-inline">
                <option value="OPEN" @selected($task->status=='OPEN')>OPEN</option>
                <option value="IN_PROGRESS" @selected($task->status=='IN_PROGRESS')>IN PROGRESS</option>
                <option value="COMPLETED" @selected($task->status=='COMPLETED')>COMPLETED</option>
                <option value="VERIFIED" @selected($task->status=='VERIFIED')>VERIFIED</option>
                <option value="CANCELLED" @selected($task->status=='CANCELLED')>CANCELLED</option>
            </select>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endif

<div class="card">
    <div class="card-header">Comments</div>
    <div class="card-body">
        @foreach($task->comments as $comment)
            <div class="border-bottom mb-2 pb-2">
                <strong>{{ $comment->author->name }}</strong>:
                {{ $comment->body }}
                <br>
                <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
            </div>
        @endforeach

        <form action="{{ route('comments.store', $task->id) }}" method="POST">
            @csrf
            <textarea name="body" class="form-control" placeholder="Add a comment..." required></textarea>
            <button class="btn btn-sm btn-secondary mt-2">Post Comment</button>
        </form>
    </div>
</div>
@endsection
