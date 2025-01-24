@extends('layouts.app')

@section('content')
    <div class="card p-4 shadow-lg border-1">
        <!-- Page Title -->
        <div class="text-center mb-4">
            <h1 class="display-4 font-weight-bold text-primary">{{ $group->group_name }}</h1>
            <p class="text-muted">{{ $group->group_description ?? 'No description provided.' }}</p>
            <hr class="my-2" style="border-top: 3px solid #007bff; width: 60%;">
        </div>

        <!-- Group Status -->
        <div class="mb-4 text-center">
            <p class="lead">
                <strong>Status:</strong>
                <span class="{{ $group->is_active ? 'text-success' : 'text-danger' }}">
                    {{ $group->is_active ? 'Active' : 'Inactive' }}
                </span>
            </p>
        </div>

        <!-- Users in this Group -->
        <h3 class="mb-3 text-center">Users in this Group</h3>
        <div class="mb-4 text-center" style="max-height: 300px; overflow-y: auto;">
            @if ($group->users && $group->users->isEmpty())
                <p class="text-center">No users are currently in this group.</p>
            @elseif ($group->users)
                <ul class="list-group">
                    @foreach ($group->users as $user)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $user->name }}</strong> <small>({{ $user->email }})</small>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-center text-danger">Unable to fetch users for this group.</p>
            @endif
        </div>

        <!-- Back to Groups List Button -->
        <div class="mt-4 text-center">
            <a href="{{ route('groups.index') }}" class="btn btn-secondary btn-lg">
                <i class="fas fa-arrow-left"></i> Back to Groups
            </a>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        /* Page Title Styling */
        .text-center h1 {
            font-size: 3rem;
            font-weight: 700;
            letter-spacing: 2px;
            text-shadow: 3px 3px 6px rgba(0, 123, 255, 0.4);
        }

        /* Status Styling */
        .lead {
            font-size: 1.2rem;
        }

        .text-success {
            color: #28a745 !important;
            font-weight: bold;
        }

        .text-danger {
            color: #dc3545 !important;
            font-weight: bold;
        }

        /* Button Styling */
        .btn-secondary {
            background-color: #6c757d;
            border: none;
            font-size: 1.1rem;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .btn-lg {
            font-size: 1.2rem;
            padding: 12px 25px;
        }

        /* List Group Item Styling */
        .list-group-item {
            font-size: 1.1rem;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .list-group-item:hover {
            background-color: #f8f9fa;
        }

        /* Margin and Spacing */
        .mb-4 {
            margin-bottom: 2rem;
        }

        .mb-3 {
            margin-bottom: 1.5rem;
        }

        hr {
            margin-top: 30px;
            margin-bottom: 30px;
        }

        /* Small Text Styling */
        small {
            font-size: 0.9rem;
            color: #6c757d;
        }
    </style>
@endsection
