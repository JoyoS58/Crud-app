@extends('layouts.app')

@section('content')
    <div class="card p-4 shadow-lg border-1">
        <div class="container py-4">
            <!-- Role Management Title -->
            <div class="text-center mb-4">
                <h1 class="display-5 font-weight-bold text-primary">
                    <i class="fas fa-cogs"></i> Role Management
                </h1>
                <p class="lead text-muted">
                    Create, edit, or delete roles. Manage your user access levels efficiently.
                </p>
                <hr class="my-4" style="border-top: 2px solid #007bff; width: 50%;">
            </div>

            <!-- Add Role Button -->
            <a href="{{ route('roles.create') }}" class="btn btn-primary btn-lg mb-3">
                <i class="fas fa-plus-circle"></i> Add Role
            </a>

            <!-- Role List Table -->
            @if ($roles->isEmpty())
                <div class="alert alert-warning text-center">
                    <i class="fas fa-exclamation-circle fa-2x mb-2 text-warning"></i>
                    <h4>No Roles Found</h4>
                    <p class="mb-0">There are no roles to display. Click the <strong>Add Role</strong> button above to
                        create a new role.</p>
                </div>
            @else
                <div class="table-responsive shadow-sm rounded">
                    <table class="table table-hover table-striped table-bordered">
                        <thead class="thead-dark text-center">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $index => $role)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $role->role_name }}</td>
                                    <td>{{ $role->role_description }}</td>
                                    <td class="text-center">
                                        <!-- View Button -->
                                        <a href="{{ route('roles.show', $role->role_id) }}" class="btn btn-info btn-sm"
                                            data-toggle="tooltip" data-placement="top" title="View Role">
                                            <i class="fas fa-eye"></i> Show
                                        </a>
                                        <!-- Edit Button -->
                                        <a href="{{ route('roles.edit', $role->role_id) }}" class="btn btn-warning btn-sm"
                                            data-toggle="tooltip" data-placement="top" title="Edit Role">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <!-- Delete Button -->
                                        <form action="{{ route('roles.destroy', $role->role_id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this role?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip"
                                                data-placement="top" title="Delete Role">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Initialize tooltips
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endsection

<style>
    /* Enhance Role Management Title */
    .text-center h1 {
        font-size: 2.5rem;
        font-weight: 600;
        letter-spacing: 1px;
    }

    .text-center h1 {
        text-shadow: 2px 2px 4px rgba(0, 123, 255, 0.3);
    }

    /* Table Row Hover Effect */
    .table-hover tbody tr:hover {
        background-color: #f1f1f1;
        cursor: pointer;
    }

    /* Table Header Styling */
    .table-bordered th,
    .table-bordered td {
        border: 2px solid #007bff;
    }

    .table-bordered thead th {
        border-bottom-width: 3px;
        color: #ffffff;
        background-color: #007bff;
    }

    /* Button Styling */
    .btn-group .btn {
        margin-right: 5px;
        border-radius: 25px;
        font-weight: 500;
    }

    /* Styling the Tooltip */
    .btn-sm[data-toggle="tooltip"] {
        padding: 5px 10px;
        border-radius: 25px;
    }

    /* Adding subtle hover effect to action buttons */
    .btn-lg:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Card Border and Shadow */
    .table-responsive {
        border: 1px solid #007bff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
</style>
