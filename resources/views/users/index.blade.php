@extends('layouts.app')

@section('content')
    <div class="card p-4 shadow-lg border-1">
        <div class="container py-4">
            <!-- Page Title -->
            <div class="text-center mb-4">
                <h1 class="display-4 font-weight-bold text-primary">
                    <i class="fas fa-users"></i> User Management
                </h1>
                <p class="text-muted">Manage all registered users efficiently and effectively.</p>
                <hr class="my-4" style="border-top: 2px solid #007bff; width: 50%;">
            </div>

            <!-- Add User Button and Total Users -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="{{ route('users.create') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-user-plus"></i> Add User
                </a>
                <span class="badge badge-info p-3" style="font-size: 1rem;">
                    <i class="fas fa-users"></i> Total Users: {{ $users->count() }}
                </span>
            </div>

            <!-- User Table -->
            @if ($users->isEmpty())
                <div class="alert alert-warning text-center">
                    <i class="fas fa-exclamation-circle"></i> No users found. Start adding new users to populate this list.
                </div>
            @else
                <div class="table-responsive shadow-sm rounded">
                    <table class="table table-hover table-striped table-bordered">
                        <thead class="thead-dark text-center">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $index => $user)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><strong>{{ $user->name }}</strong></td>
                                    <td>{{ $user->email }}</td>
                                    <td class="text-center">
                                        <!-- Action Buttons -->
                                        <div class="btn-group" role="group" aria-label="User Actions">
                                            <a href="{{ route('users.show', $user->user_id) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i> Show
                                            </a>
                                            <a href="{{ route('users.edit', $user->user_id) }}"
                                                class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form action="{{ route('users.destroy', $user->user_id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure you want to delete this user?')">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- Custom Styles -->
    <style>
        .text-center h1 {
            font-size: 2.5rem;
            font-weight: 600;
            letter-spacing: 1px;
        }

        .text-center h1 {
            text-shadow: 2px 2px 4px rgba(0, 123, 255, 0.3);
        }

        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
            cursor: pointer;
        }

        /* Table Header Styling */
        .table-bordered th,
        .table-bordered td {
            border: 2px solid #007bff;
        }

        /* Table Hover Effect */
        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
            transition: background-color 0.2s ease-in-out;
        }

        /* Button Group Styling */
        .btn-group .btn {
            margin-right: 5px;
        }

        /* Table Radius */
        .table {
            border-radius: 8px;
            overflow: hidden;
        }
    </style>
@endsection
