@extends('layouts.app')

@section('content')
    <div class="card p-4 shadow-lg border-1">
        <!-- Page Title -->
        <div class="text-center mb-4">
            <h1 class="display-4 font-weight-bold text-primary">
                <i class="fas fa-user"></i> {{ $user->name }}
            </h1>
            <p class="text-muted">{{ $user->email }}</p>
            <hr class="my-4" style="border-top: 2px solid #007bff; width: 50%;">
        </div>

        <!-- User Details Card -->
        <div class="card shadow-sm rounded-lg">
            <div class="card-body">
                <h3 class="mb-3">User Information</h3>
                <ul class="list-group">
                    <li class="list-group-item">
                        <strong>Name:</strong> {{ $user->name }}
                    </li>
                    <li class="list-group-item">
                        <strong>Email:</strong> {{ $user->email }}
                    </li>
                    <li class="list-group-item">
                        <strong>Joined:</strong> {{ $user->created_at->format('d M, Y') }}
                    </li>
                </ul>

                <!-- User Roles -->
                <h3 class="mt-4 mb-3">Roles Assigned</h3>
                @if ($user->roles->isNotEmpty())
                    <ul class="list-group">
                        @foreach ($user->roles as $role)
                            <li class="list-group-item">
                                <strong>{{ $role->role_name }}</strong>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>No roles assigned to this user yet.</p>
                @endif

            </div>
        </div>

        <!-- Back and Show Profile Buttons -->
        <div class="mt-4 d-flex justify-content-between">
            <a href="{{ route('users.index') }}" class="btn btn-secondary btn-lg">
            <i class="fas fa-arrow-left"></i> Back to Users List
            </a>
        </div>
        </div>
    @endsection

    @section('styles')
    <link rel="stylesheet" href="{{ asset('css/user-styles.css') }}">
    @endsection
