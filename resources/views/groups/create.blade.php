@extends('layouts.app')

@section('content')
    <div class="card p-4 shadow-lg border-1">
        <!-- Page Header -->
        <div class="text-center mb-4">
            <h1 class="display-5 font-weight-bold text-primary">
                <i class="fas fa-users"></i> Create Group
            </h1>
            <p class="lead text-muted">Fill in the details below to create a new group.</p>
        </div>

        <!-- Group Creation Form -->
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('groups.store') }}" method="POST">
                    @csrf

                    <!-- Group Name -->
                    <div class="mb-3">
                        <label for="group_name" class="form-label font-weight-bold">Group Name</label>
                        <input type="text" name="group_name" id="group_name"
                            class="form-control @error('group_name') is-invalid @enderror" value="{{ old('group_name') }}"
                            placeholder="Enter group name" required>
                        @error('group_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Group Description -->
                    <div class="mb-3">
                        <label for="group_description" class="form-label font-weight-bold">Group Description</label>
                        <textarea name="group_description" id="group_description"
                            class="form-control @error('group_description') is-invalid @enderror"
                            placeholder="Enter a brief description of the group">{{ old('group_description') }}</textarea>
                        @error('group_description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Active Status -->
                    <div class="mb-3">
                        <label for="is_active" class="form-label font-weight-bold">Active Status</label>
                        <select name="is_active" id="is_active"
                            class="form-select @error('is_active') is-invalid @enderror">
                            <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('is_active')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Assign Users -->
                    <div class="mb-3">
                        <label for="user_id" class="form-label font-weight-bold">Assign Users</label>
                        <select name="user_ids[]" id="user_ids" class="form-control @error('user_ids') is-invalid @enderror" multiple>
                            @foreach ($users as $user)
                                <option value="{{ $user->user_id }}" {{ in_array($user->user_id, old('user_ids', [])) ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        
                        

                        <small class="form-text text-muted">
                            Hold Ctrl (Windows) or Command (Mac) to select multiple users.
                        </small>
                        @error('user_ids')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="d-flex justify-content-between mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Create Group
                        </button>
                        <a href="{{ route('groups.index') }}" class="btn btn-secondary">
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
    </style>
@endsection
