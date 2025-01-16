@extends('layouts.app')

@section('content')
    <div class="card p-4 shadow-lg border-1">
        <!-- Page Header -->
        <div class="text-center mb-5">
            <h1 class="display-5 font-weight-bold text-primary">
                <i class="fas fa-calendar-plus"></i> Create New Activity
            </h1>
            <p class="lead text-muted">Fill in the details below to create a new activity.</p>
        </div>

        <!-- Activity Creation Form -->
        <div class="card shadow-sm rounded-lg">
            <div class="card-body">
                <form action="{{ route('activities.store') }}" method="POST">
                    @csrf

                    <!-- Activity Name -->
                    <div class="mb-4">
                        <label for="activity_name" class="form-label font-weight-bold">Activity Name</label>
                        <input type="text" class="form-control @error('activity_name') is-invalid @enderror"
                            id="activity_name" name="activity_name" required value="{{ old('activity_name') }}">
                        @error('activity_name')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Group Selection -->
                    <div class="mb-4">
                        <label for="group_id" class="form-label font-weight-bold">Group</label>
                        <select class="form-select @error('group_id') is-invalid @enderror" id="group_id" name="group_id">
                            <option value="" disabled selected>Select Group</option>
                            @foreach ($groups as $group)
                                <option value="{{ $group->group_id }}"
                                    {{ old('group_id') == $group->group_id ? 'selected' : '' }}>
                                    {{ $group->group_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('group_id')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- User Selection -->
                    <div class="mb-4">
                        <label for="user_id" class="form-label font-weight-bold">User</label>
                        <select class="form-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id"
                            required>
                            <option value="" disabled selected>Select User</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->user_id }}"
                                    {{ old('user_id') == $user->user_id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Activity Description -->
                    <div class="mb-4">
                        <label for="activity_description" class="form-label font-weight-bold">Activity Description</label>
                        <textarea class="form-control @error('activity_description') is-invalid @enderror" id="activity_description"
                            name="activity_description">{{ old('activity_description') }}</textarea>
                        @error('activity_description')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="d-flex justify-content-between mt-4">
                        <button type="submit" class="btn btn-success px-4 py-2">
                            <i class="fas fa-save"></i> Create Activity
                        </button>
                        <a href="{{ route('activities.index') }}" class="btn btn-secondary px-4 py-2">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
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
            /* Uniform padding for inputs and selects */
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
        .btn-success,
        .btn-secondary {
            font-size: 1rem;
            font-weight: 600;
            padding: 12px 30px;
        }

        /* Align form inputs and buttons for symmetry */
        .form-select,
        .form-control {
            width: 100%;
            /* Ensure inputs take up full width */
            max-width: 500px;
            /* Limit maximum width for better alignment */
            margin-left: auto;
            margin-right: auto;
        }

        /* Align form container */
        .card-body {
            max-width: 600px;
            /* Make the form more centered */
            margin-left: auto;
            margin-right: auto;
        }
    </style>
@endsection
