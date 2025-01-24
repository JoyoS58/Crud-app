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
                        <div id="user_ids" class="@error('user_ids') is-invalid @enderror">
                            @foreach ($users as $user)
                                <div class="form-check">
                                    <input type="checkbox" name="user_ids[]" id="user_{{ $user->user_id }}"
                                        value="{{ $user->user_id }}" class="form-check-input"
                                        {{ in_array($user->user_id, old('user_ids', [])) ? 'checked' : '' }}>
                                    <label for="user_{{ $user->user_id }}" class="form-check-label">
                                        {{ $user->name }} ({{ $user->email }})
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <small class="form-text text-muted">
                            Select the users to assign.
                        </small>
                        @error('user_ids')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    {{-- <!-- Pagination Links -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <form method="GET" action="{{ route('groups.create') }}">
                            <label for="pageSize">Show</label>
                            <select id="pageSize" name="pageSize" onchange="this.form.submit()">
                                <option value="5" {{ request('pageSize') == 5 ? 'selected' : '' }}>5</option>
                                <option value="10" {{ request('pageSize') == 10 ? 'selected' : '' }}>10</option>
                                <option value="20" {{ request('pageSize') == 20 ? 'selected' : '' }}>20</option>
                                <option value="50" {{ request('pageSize') == 50 ? 'selected' : '' }}>50</option>
                            </select>
                            <label for="pageSize">entries</label>
                        </form>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item {{ $users->currentPage() == 1 ? ' disabled' : '' }}">
                                    <a class="page-link"
                                        href="{{ $users->appends(['pageSize' => request('pageSize')])->previousPageUrl() }}">Previous</a>
                                </li>
                                @for ($i = 1; $i <= $users->lastPage(); $i++)
                                    <li class="page-item {{ $users->currentPage() == $i ? ' active' : '' }}">
                                        <a class="page-link"
                                            href="{{ $users->appends(['pageSize' => request('pageSize')])->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                <li
                                    class="page-item {{ $users->currentPage() == $users->lastPage() ? ' disabled' : '' }}">
                                    <a class="page-link"
                                        href="{{ $users->appends(['pageSize' => request('pageSize')])->nextPageUrl() }}">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div> --}}
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
