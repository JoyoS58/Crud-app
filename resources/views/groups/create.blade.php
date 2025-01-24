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
                <form action="{{ route('groups.store') }}" method="POST" id="createGroupForm">
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
                        <label for="user_ids" class="form-label font-weight-bold">Assign Users</label>
                        <div class="row">
                            <div class="col-md-6 text-center">
                                <label class="form-label font-weight-bold">Available Users</label>
                                <div id="available_users" class="border p-2 @error('user_ids') is-invalid @enderror" style="max-height: 300px; overflow-y: auto;">
                                    @foreach ($users as $user)
                                        @if ($user->role_id != 1 && !in_array($user->user_id, old('user_ids', [])))
                                            <div class="btn-group-toggle w-100 mb-2" data-toggle="buttons">
                                                <label class="btn btn-outline-primary w-100">
                                                    <input type="checkbox" name="user_ids[]" id="user_{{ $user->user_id }}"
                                                        value="{{ $user->user_id }}" onchange="toggleUserSelection(this)">
                                                    {{ $user->name }} ({{ $user->email }})
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-6  text-center">
                                <label class="form-label font-weight-bold">Selected Users</label>
                                <div id="selected_users" class="border p-2 @error('user_ids') is-invalid @enderror" style="max-height: 300px; overflow-y: auto;">
                                    @foreach ($users as $user)
                                        @if ($user->role_id != 1 && in_array($user->user_id, old('user_ids', [])))
                                            <div class="btn-group-toggle w-100 mb-2" data-toggle="buttons">
                                                <label class="btn btn-outline-primary w-100">
                                                    <input type="checkbox" name="user_ids[]" id="user_{{ $user->user_id }}"
                                                        value="{{ $user->user_id }}" checked
                                                        onchange="toggleUserSelection(this)">
                                                    {{ $user->name }} ({{ $user->email }})
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <script>
                            function toggleUserSelection(checkbox) {
                                const availableUsers = document.getElementById('available_users');
                                const selectedUsers = document.getElementById('selected_users');
                                const parent = checkbox.closest('.btn-group-toggle');

                                if (checkbox.checked) {
                                    selectedUsers.appendChild(parent);
                                } else {
                                    availableUsers.appendChild(parent);
                                }
                            }
                        </script>
                        <small class="form-text text-muted">
                            Select the users to assign.
                        </small>
                        @error('user_ids')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <!-- Submit Button -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('groups.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Create Group
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- SweetAlert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: '{{ $errors->first() }}',
                confirmButtonText: 'Close'
            });
        @endif

        @if (session('group_exists'))
            Swal.fire({
                icon: 'warning',
                title: 'Group Name Already Exists',
                text: 'The group name you have entered is already taken. Please choose a different name.',
                confirmButtonText: 'Try Again'
            });
        @endif
    </script>
@endsection
