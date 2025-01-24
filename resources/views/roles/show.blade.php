@extends('layouts.app')

@section('content')
    <div class="card p-4 shadow-lg border-1">
        <!-- Page Title -->
        <div class="text-center mb-4">
            <h1 class="display-4 font-weight-bold text-primary">
                <i class="fas fa-user-tag"></i> {{ $role->role_name }}
            </h1>
            <p class="text-muted">{{ $role->role_description ?? 'No description provided.' }}</p>
            <hr class="my-4" style="border-top: 2px solid #007bff; width: 50%;">
        </div>

        

        <!-- Users Assigned to this Role -->
        <h3 class="mb-3">Users in this Role</h3>
        @php
            $assignedUsers = $users->filter(function($user) use ($role) {
            return $user->role_id == $role->role_id;
            });
        @endphp
        @if ($assignedUsers->isEmpty())
            <div class="alert alert-warning">
            <i class="fas fa-exclamation-circle"></i> No users assigned to this role yet.
            </div>
        @else
            <div class="table-responsive shadow-sm rounded">
            <table class="table table-hover table-striped table-bordered">
            <thead class="thead-dark text-center">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($assignedUsers as $index => $user)
                <tr>
                <td>{{ $loop->iteration }}</td>
                <td><strong>{{ $user->name }}</strong></td>
                <td>{{ $user->email }}</td>
                </tr>
            @endforeach
            </tbody>
            </table>
            </div>
        @endif

        
            <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('roles.index') }}" class="btn btn-secondary btn-lg">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
            {{-- <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-user-plus"></i> Add User
            </button> --}}
            </div>
        {{-- </form>
        <div id="successMessage" class="alert alert-success mt-4" style="display: none;">
            <i class="fas fa-check-circle"></i> User added successfully!
        </div> --}}
    </div>
@endsection

@section('styles')
    <style>
        /* Page Title Styling */
        .text-center h1 {
            font-size: 2.5rem;
            font-weight: 600;
            letter-spacing: 1px;
            text-shadow: 2px 2px 4px rgba(0, 123, 255, 0.3);
        }

        /* Card Design for Table */
        .table-bordered th,
        .table-bordered td {
            border: 2px solid #007bff;
        }

        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
            transition: background-color 0.2s ease-in-out;
        }

        /* Button Group Styling */
        .btn-group .btn {
            margin-right: 5px;
        }

        .table {
            border-radius: 8px;
            overflow: hidden;
        }

        .btn-warning {
            background-color: #ffcc00;
            border: none;
        }

        .btn-warning:hover {
            background-color: #e0a800;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0069d9;
        }

        .btn-secondary {
            background-color: #6c757d;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        /* Select Field Styling */
        .form-select {
            border-radius: 8px;
            border: 1px solid #007bff;
        }

        .form-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.8);
        }

        /* Margin and Spacing */
        .mb-3 {
            margin-bottom: 1.5rem;
        }

        .mt-4 {
            margin-top: 1.5rem;
        }

        hr {
            margin-top: 30px;
            margin-bottom: 30px;
        }
    </style>
@endsection

@section('scripts')
    <script>
        document.getElementById('addUserForm').addEventListener('submit', function(event) {
            event.preventDefault();
            // Simulate form submission
            setTimeout(function() {
                document.getElementById('successMessage').style.display = 'block';
            }, 500);
        });

        // Initialize select2 for better user selection experience
        $(document).ready(function() {
            $('#userId').select2({
                placeholder: 'Search and select a user',
                allowClear: true
            });
        });
    </script>
@endsection
