@extends('layouts.app')

@section('content')
    <div class="card p-4 shadow-lg border-1">
        <!-- Page Header -->
        <div class="text-center mb-5">
            <h1 class="display-5 font-weight-bold text-primary">
                <i class="fas fa-user-plus"></i> Add New Member
            </h1>
            <p class="lead text-muted">Fill in the details below to add a new member to a group.</p>
        </div>

        <!-- Member Creation Form -->
        <div class="card shadow-sm rounded-lg">
            <div class="card-body">
                <form action="{{ route('members.store') }}" method="POST">
                    @csrf

                    <!-- User Selection -->
                    <div class="mb-4">
                        <label for="userId" class="form-label font-weight-bold">User</label>
                        <select class="form-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required
                            >
                            <option value="" disabled selected>Select a user</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->user_id }}">
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('userId')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Group Selection -->
                    <div class="mb-4">
                        <label for="groupId" class="form-label font-weight-bold">Group</label>
                        <select class="form-select @error('group_id') is-invalid @enderror" id="group_id" name="group_id" required>
                            <option value="" disabled selected>Select a group</option>
                            @foreach ($groups as $group)
                                <option value="{{ $group->group_id }}">{{ $group->group_name }}</option>
                            @endforeach
                        </select>
                        @error('groupId')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Join Date -->
                    <div class="mb-4">
                        <label for="join_date" class="form-label font-weight-bold">Join Date</label>
                        <input type="date" class="form-control @error('join_date') is-invalid @enderror" id="join_date"
                            name="join_date" value="{{ old('join_date') }}">
                        @error('join_date')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status Selection -->
                    <div class="mb-4">
                        <label for="status" class="form-label font-weight-bold">Status</label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Role in Group -->
                    <div class="mb-4">
                        <label for="role_in_group" class="form-label font-weight-bold">Role in Group</label>
                        <input type="text" class="form-control @error('role_in_group') is-invalid @enderror"
                            id="role_in_group" name="role_in_group" placeholder="Enter role (optional)"
                            value="{{ old('role_in_group') }}">
                        @error('role_in_group')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="d-flex justify-content-between mt-4">
                        <button type="submit" class="btn btn-primary px-4 py-2">
                            <i class="fas fa-save"></i> Save Member
                        </button>
                        <a href="{{ route('members.index') }}" class="btn btn-secondary px-4 py-2">
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
