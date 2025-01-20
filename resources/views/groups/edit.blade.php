@extends('layouts.app')

@section('content')
    <div class="card p-4 shadow-lg border-1">
        <!-- Page Header -->
        <div class="text-center mb-5">
            <h1 class="display-4 font-weight-bold text-primary">
                <i class="fas fa-edit"></i> Edit Group: {{ $group->group_name }}
            </h1>
            <p class="lead text-muted">Update the group details below.</p>
        </div>

        <!-- Edit Group Form -->
        <div class="card shadow-sm rounded-lg">
            <div class="card-body">
                <form action="{{ route('groups.update', $group->group_id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Group Name -->
                    <div class="mb-4">
                        <label for="group_name" class="form-label font-weight-bold">Group Name</label>
                        <input type="text" name="group_name" id="group_name"
                            class="form-control @error('group_name') is-invalid @enderror"
                            value="{{ old('group_name', $group->group_name) }}" required>
                        @error('group_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Group Description -->
                    <div class="mb-4">
                        <label for="group_description" class="form-label font-weight-bold">Group Description</label>
                        <textarea name="group_description" id="group_description"
                            class="form-control @error('group_description') is-invalid @enderror">{{ old('group_description', $group->group_description) }}</textarea>
                        @error('group_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Is Active Select -->
                    <div class="mb-4">
                        <label for="is_active" class="form-label font-weight-bold">Active</label>
                        <select name="is_active" id="is_active"
                            class="form-select @error('is_active') is-invalid @enderror">
                            <option value="1" {{ $group->is_active ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ !$group->is_active ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('is_active')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Users Checkboxes -->
                    <div class="mb4">
                        <label class="form-label font-weight-bold">Select Users</label><br>
                        <div class="row">

                            @foreach ($users as $user)
                            <div class="form-check ml-4">
                                <input type="checkbox" name="user_ids[]" value="{{ $user->user_id }}"
                                class="form-check-input @error('user_ids') is-invalid @enderror"
                                id="user_{{ $user->user_id }}"
                                {{ in_array($user->user_id, $group->members->pluck('user_id')->toArray()) ? 'checked' : '' }}>
                                <label class="form-check-label" for="user_{{ $user->user_id }}">
                                    {{ $user->name }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                        @error('user_ids')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('groups.index') }}" class="btn btn-secondary px-4 py-2">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                        <button type="submit" class="btn btn-primary px-4 py-2">
                            <i class="fas fa-save"></i> Update Group
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
        .form-select,
        .form-check-input {
            border-radius: 8px;
            font-size: 1rem;
            padding: 12px 16px;
        }

        .form-control:focus,
        .form-select:focus,
        .form-check-input:focus {
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

        .form-check {
            margin-bottom: 1rem;
            column-fill: auto;
        }

        /* Align form container */
        .card-body {
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
@endsection

