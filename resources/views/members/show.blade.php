@extends('layouts.app')

@section('content')
    <div class="card p-4 shadow-lg border-1">
        <!-- Page Title -->
        <div class="text-center mb-4">
            <h1 class="display-4 font-weight-bold text-primary">
                <i class="fas fa-user"></i> Member Details
            </h1>
            <hr class="my-4" style="border-top: 2px solid #007bff; width: 50%;">
        </div>

        <!-- Member Information List -->
        <div class="shadow-sm rounded">
            <ul class="list-group">
                <!-- Display Member ID -->
                <li class="list-group-item">
                    <strong>Member ID:</strong> {{ $member->member_id }}
                </li>

                <!-- Display User's Name -->
                <li class="list-group-item">
                    <strong>User:</strong> {{ $member->user ? $member->user->name : 'N/A' }}
                </li>

                <!-- Display Group's Name -->
                <li class="list-group-item">
                    <strong>Group:</strong> {{ $member->group ? $member->group->group_name : 'N/A' }}
                </li>

                <!-- Display Join Date -->
                <li class="list-group-item">
                    <strong>Join Date:</strong> {{ \Carbon\Carbon::parse($member->join_date)->format('d M, Y') }}
                </li>

                <!-- Display Status -->
                <li class="list-group-item">
                    <strong>Status:</strong> {{ ucfirst($member->status) }}
                </li>

                <!-- Display Role in Group -->
                <li class="list-group-item">
                    <strong>Role:</strong> {{ $member->role_in_group }}
                </li>
            </ul>
        </div>

        <!-- Back to Members List Button -->
        <div class="text-center mt-4">
            <a href="{{ route('members.index') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-arrow-left"></i> Back to Members List
            </a>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        /* Page Title Styling */
        .text-center h1 {
            font-size: 2.5rem;
            font-weight: 600;
            letter-spacing: 1px;
            text-shadow: 2px 2px 4px rgba(0, 123, 255, 0.3);
        }

        /* List Group Item Styling */
        .list-group-item {
            font-size: 1rem;
            padding: 15px;
        }

        /* Button Styling */
        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0069d9;
        }

        .btn-lg {
            font-size: 1.2rem;
            padding: 10px 20px;
        }

        /* Margin and Spacing */
        .mb-4 {
            margin-bottom: 2rem;
        }
    </style>
@endsection
