@extends('layouts.app')

@section('title', 'Task Detail - AttendanceHub')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}?v={{ time() }}">
<link rel="stylesheet" href="{{ asset('assets/css/tasks.css') }}?v={{ time() }}">
@endsection

@section('content')
<div class="tasks-header">
    <div class="header-content">
        <div class="header-text">
            <h1>Task Detail</h1>
            <p>Detail informasi tugas</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('tasks.index') }}" class="header-btn" title="Back to Tasks">
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>
    </div>
</div>

<div class="tasks-content">
    <div class="task-detail-card">
        <h2>{{ $task->title }}</h2>
        <p class="mb-2">{{ $task->description ?? '-' }}</p>
        <div class="task-meta mb-3">
            <span class="priority-badge priority-{{ $task->priority }}">{{ ucfirst($task->priority) }}</span>
            <span class="status-badge status-{{ $task->status }}">{{ ucfirst(str_replace('_', ' ', $task->status)) }}</span>
            @if($task->due_date)
                <span><i class="fas fa-calendar"></i> Due: {{ $task->due_date->format('M j, Y H:i') }}</span>
            @endif
            @if($task->department)
                <span><i class="fas fa-building"></i> {{ $task->department->name }}</span>
            @endif
        </div>
        <div class="mb-3">
            <strong>Created By:</strong> {{ $task->creator ? $task->creator->name : '-' }}<br>
            <strong>Created At:</strong> {{ $task->created_at->format('M j, Y H:i') }}
        </div>
        <div class="mb-3">
            <strong>Assigned Users:</strong>
            <ul>
                @foreach($task->assignments as $assignment)
                    <li>
                        {{ $assignment->user ? $assignment->user->name : '-' }}
                        ({{ ucfirst($assignment->status) }})
                        @if($assignment->notes)
                            - Notes: {{ $assignment->notes }}
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="mb-3">
            <strong>Estimated Hours:</strong> {{ $task->estimated_hours ?? '-' }}<br>
            <strong>Actual Hours:</strong> {{ $task->actual_hours ?? '-' }}
        </div>
        @if($task->completion_notes)
            <div class="mb-3">
                <strong>Completion Notes:</strong> {{ $task->completion_notes }}
            </div>
        @endif
    </div>
</div>
@endsection