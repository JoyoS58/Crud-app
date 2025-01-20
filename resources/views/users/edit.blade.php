@extends('layouts.app')

@section('content')
    <div class="card p-4 shadow-lg border-1">
        <!-- Page Header -->
        <div class="text-center mb-5">
            <h1 class="display-5 font-weight-bold text-primary">
                <i class="fas fa-edit"></i> Edit User: {{ $user->name }}
            </h1>
            <p class="lead text-muted">Update the user details below. Leave password fields empty to keep the current password.</p>
        </div>

        <!-- Edit User Form -->
        <div class="card shadow-sm rounded-lg">
            <div class="card-body">
                <form action="{{ route('users.update', $user->user_id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Name Field -->
                    <div class="mb-4">
                        <label for="name" class="form-label font-weight-bold">Name</label>
                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror" 
                            value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div class="mb-4">
                        <label for="email" class="form-label font-weight-bold">Email</label>
                        <input type="email" name="email" id="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Current Password Field -->
                    <div class="mb-4">
                        <label for="current_password" class="form-label font-weight-bold">Current Password</label>
                        <input type="password" name="current_password" id="current_password"
                            class="form-control @error('current_password') is-invalid @enderror">
                        @error('current_password')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Required if changing the password.</small>
                    </div>

                    <!-- New Password Field -->
                    <div class="mb-4">
                        <label for="password" class="form-label font-weight-bold">New Password</label>
                        <input type="password" name="password" id="password"
                            class="form-control @error('password') is-invalid @enderror">
                        @error('password')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Leave blank to keep the current password.</small>
                    </div>

                    <!-- Confirm New Password Field -->
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label font-weight-bold">Confirm New Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" 
                            class="form-control">
                        @error('password_confirmation')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('users.index') }}" class="btn btn-secondary px-4 py-2">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                        <button type="submit" class="btn btn-primary px-4 py-2">
                            <i class="fas fa-save"></i> Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        /* Form and Card Styling */
        .form-control,
        .form-select {
            border-radius: 8px;
            font-size: 1rem;
            padding: 12px 16px;
        }

        .form-control:focus,
        .form-select:focus {
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.8);
            border-color: #007bff;
        }

        .card {
            border-radius: 12px;
            border: 1px solid #007bff;
        }

        .card-body {
            padding: 2rem;
        }

        /* Title and form heading */
        .display-4 {
            font-size: 2.5rem;
        }

        .form-label {
            font-size: 1.1rem;
            font-weight: bold;
        }

        /* Buttons */
        .btn {
            font-size: 1rem;
            font-weight: 600;
            padding: 12px 24px;
        }

        /* Error messages */
        .text-danger {
            font-size: 0.9rem;
        }

        /* Spacing between fields */
        .mb-4 {
            margin-bottom: 1.5rem;
        }
    </style>
@endsection
