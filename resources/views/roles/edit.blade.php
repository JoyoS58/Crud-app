@extends('layouts.app')

@section('content')
    <div class="card p-4 shadow-lg border-1">
        <!-- Page Header -->
        <div class="text-center mb-5">
            <h1 class="display-4 font-weight-bold text-primary">
                <i class="fas fa-edit"></i> Edit Role: {{ $role->role_name }}
            </h1>
            <p class="lead text-muted">Update the role details below.</p>
        </div>

        <!-- Edit Role Form -->
        <div class="card shadow-sm rounded-lg">
            <div class="card-body">
                <form action="{{ route('roles.update', $role->role_id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Role Name -->
                    <div class="mb-4">
                        <label for="role_name" class="form-label font-weight-bold">Role Name</label>
                        <input type="text" name="role_name" id="role_name"
                            class="form-control @error('role_name') is-invalid @enderror"
                            value="{{ old('role_name', $role->role_name) }}" required>
                        @error('role_name')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Role Description -->
                    <div class="mb-4">
                        <label for="role_description" class="form-label font-weight-bold">Role Description</label>
                        <textarea name="role_description" id="role_description"
                            class="form-control @error('role_description') is-invalid @enderror" rows="4">{{ old('role_description', $role->role_description) }}</textarea>
                        @error('role_description')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('roles.index') }}" class="btn btn-secondary px-4 py-2">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                        <button type="submit" class="btn btn-primary px-4 py-2">
                            <i class="fas fa-save"></i> Update Role
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
        .invalid-feedback {
            font-size: 0.9rem;
            color: #dc3545;
        }

        .text-danger {
            font-size: 0.9rem;
        }

        /* Spacing between fields */
        .mb-4 {
            margin-bottom: 1.5rem;
        }

        /* Adjust spacing for submit button */
        .btn-primary,
        .btn-secondary {
            font-size: 1rem;
            font-weight: 600;
            padding: 12px 30px;
        }

        /* Align form inputs and buttons for symmetry */
        .form-select,
        .form-control {
            width: 100%;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Align form container */
        .card-body {
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
@endsection
