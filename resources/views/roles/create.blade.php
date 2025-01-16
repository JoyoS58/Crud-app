@extends('layouts.app')

@section('content')
    <div class="card p-4 shadow-lg border-1">
        <!-- Page Title -->
        <div class="text-center mb-4">
            <h1 class="display-5 font-weight-bold text-primary">
                <i class="fas fa-user-tag"></i> Create Role
            </h1>
            <p class="lead text-muted">
                Add a new role to manage permissions and responsibilities.
            </p>
        </div>

        <!-- Role Creation Form -->
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('roles.store') }}" method="POST">
                    @csrf

                    <!-- Role Name -->
                    <div class="form-group">
                        <label for="role_name" class="font-weight-bold">Role Name</label>
                        <input type="text" name="role_name" id="role_name"
                            class="form-control @error('role_name') is-invalid @enderror" placeholder="Enter role name"
                            value="{{ old('role_name') }}" required>
                        @error('role_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Role Description -->
                    <div class="form-group">
                        <label for="role_description" class="font-weight-bold">Description</label>
                        <textarea name="role_description" id="role_description"
                            class="form-control @error('role_description') is-invalid @enderror"
                            placeholder="Enter a brief description for the role">{{ old('role_description') }}</textarea>
                        @error('role_description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Form Buttons -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('roles.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Role
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        /* Styling for the form */
        .form-control {
            border-radius: 8px;
        }

        .form-control:focus {
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.8);
            border-color: #007bff;
        }

        /* Card shadow and border */
        .card {
            border: 1px solid #007bff;
            border-radius: 12px;
        }

        .card-body {
            padding: 2rem;
        }
    </style>
@endsection
