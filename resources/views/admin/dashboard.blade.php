@extends('layouts.app')

@section('content')
<h2>Admin Dashboard</h2>

<table class="table table-bordered mt-3">
    <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Status</th>
            <th>Requester</th>
            <th>Assignee</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tasks as $task)
        <tr>
            <td>{{ $task->id }}</td>
            <td>{{ $task->title }}</td>
            <td><span class="badge bg-info">{{ $task->status }}</span></td>
            <td>{{ $task->requester->name }}</td>
            <td>{{ $task->assignee->name ?? 'None' }}</td>
            <td>
                <form action="{{ route('admin.reassign', $task->id) }}" method="POST" class="d-inline">
                    @csrf
                    <select name="assignee_id" class="form-select form-select-sm d-inline w-auto">
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" @selected($task->assignee_id == $user->id)>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                    <button class="btn btn-sm btn-outline-success">Reassign</button>
                </form>

                <form action="{{ route('admin.cancel', $task->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button class="btn btn-sm btn-outline-danger">Cancel</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
