@extends('layouts.app')

@section('content')
    <div class="card p-4 shadow-lg border-1">
        <!-- Page Header -->
        <div class="text-center mb-5">
            <h1 class="display-4 font-weight-bold text-primary">
                <i class="fas fa-edit"></i> Edit Member: {{ $member->user->name }}
            </h1>
            <p class="lead text-muted">Update the member details below.</p>
        </div>

        <!-- Edit Member Form -->
        <div class="card shadow-sm rounded-lg">
            <div class="card-body">
                <form action="{{ route('members.update', $member->member_id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- User Select -->
                    <div class="mb-4">
                        <label for="userId" class="form-label font-weight-bold">User</label>
                        <select class="form-select @error('userId') is-invalid @enderror" id="userId" name="userId"
                            required>
                            @foreach ($users as $user)
                                <option value="{{ $user->user_id }}"
                                    {{ $user->user_id == $member->user_id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                        @error('userId')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Group Select -->
                    <div class="mb-4">
                        <label for="groupId" class="form-label font-weight-bold">Group</label>
                        <select class="form-select @error('groupId') is-invalid @enderror" id="groupId" name="groupId"
                            required>
                            @foreach ($groups as $group)
                                <option value="{{ $group->group_id }}"
                                    {{ $group->group_id == $member->group_id ? 'selected' : '' }}>{{ $group->group_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('groupId')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Join Date -->
                    <div class="mb-4">
                        <label for="join_date" class="form-label font-weight-bold">Join Date</label>
                        <input type="date" class="form-control @error('join_date') is-invalid @enderror" id="join_date"
                            name="join_date" value="{{ old('join_date', $member->join_date) }}">
                        @error('join_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status Select -->
                    <div class="mb-4">
                        <label for="status" class="form-label font-weight-bold">Status</label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                            <option value="active" {{ $member->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $member->status == 'inactive' ? 'selected' : '' }}>Inactive
                            </option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Role in Group -->
                    <div class="mb-4">
                        <label for="role_in_group" class="form-label font-weight-bold">Role in Group</label>
                        <input type="text" class="form-control @error('role_in_group') is-invalid @enderror"
                            id="role_in_group" name="role_in_group"
                            value="{{ old('role_in_group', $member->role_in_group) }}">
                        @error('role_in_group')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('members.index') }}" class="btn btn-secondary px-4 py-2">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                        <button type="submit" class="btn btn-warning px-4 py-2">
                            <i class="fas fa-save"></i> Update Member
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
