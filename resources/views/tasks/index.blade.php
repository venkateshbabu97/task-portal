@extends('layouts.app')

@section('content')
<h2>My Tasks</h2>

<table class="table table-bordered mt-3">
    <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Status</th>
            <th>Requester</th>
            <th>Assignee</th>
            <th>Created</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tasks as $task)
        <tr>
            <td>{{ $task->id }}</td>
            <td>{{ $task->title }}</td>
            <td>
                <span class="badge 
                    @if($task->status === 'OPEN') bg-primary
                    @elseif($task->status === 'IN_PROGRESS') bg-warning
                    @elseif($task->status === 'COMPLETED') bg-success
                    @elseif($task->status === 'CANCELLED') bg-danger
                    @else bg-secondary @endif">
                    {{ $task->status }}
                </span>
            </td>
            <td>{{ $task->requester->name ?? '-' }}</td>
            <td>{{ $task->assignee->name ?? '-' }}</td>
            <td>{{ $task->created_at->diffForHumans() }}</td>
            <td>
                <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-sm btn-outline-primary">View</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
