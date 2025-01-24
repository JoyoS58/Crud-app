@extends('layouts.app')

@section('content')
    <div class="card p-4 shadow-lg border-1">
        <div class="container py-4">
            <!-- Members Management Title -->
            <div class="text-center mb-4">
                <h1 class="display-4 font-weight-bold text-primary">
                    <i class="fas fa-users"></i> Members Management
                </h1>
                <p class="lead text-muted">
                    Manage member details, their roles, and group associations easily.
                </p>
                <hr class="my-4" style="border-top: 2px solid #007bff; width: 50%;">
            </div>

            <!-- Add Member Button -->
            <a href="{{ route('members.create') }}" class="btn btn-primary mb-3 btn-lg">
                <i class="fas fa-plus-circle"></i> Add New Member
            </a>

            <!-- Member List Table -->
            @if ($members->isEmpty())
                <div class="alert alert-warning text-center">
                    <i class="fas fa-exclamation-circle fa-2x mb-2 text-warning"></i>
                    <h4>No Members Found</h4>
                    <p class="mb-0">There are no members to display. Click the <strong>Add New Member</strong> button
                        above to add members.</p>
                </div>
            @else
                <div class="table-responsive shadow-sm rounded">
                    <table class="table table-hover table-striped table-bordered">
                        <thead class="thead-dark text-center">
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Group</th>
                                <th>Join Date</th>
                                <th>Status</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($members as $index => $member)
                                <tr>
                                    <td>{{ $index + 1 }}</td> <!-- Member ID -->
                                    <td>{{ $member->user->name }} ({{ $member->user->email }})</td>
                                    <!-- User Name and Email -->
                                    <td>{{ $member->group ? $member->group->group_name : 'None' }}</td> <!-- Group Name -->
                                    <td>{{ $member->join_date ? $member->join_date: 'No Date' }}
                                    </td> <!-- Join Date -->
                                    <td>
                                        <span class="badge badge-{{ $member->status == 'active' ? 'success' : 'danger' }}">
                                            {{ ucfirst($member->status ?? 'None') }}
                                        </span>
                                    </td> <!-- Status with Badge -->
                                    <td>{{ $member->role_in_group ?? 'None' }}</td> <!-- Role in Group -->
                                    <td class="text-center">
                                        <!-- View Button -->
                                        <a href="{{ route('members.show', $member->member_id) }}"
                                            class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top"
                                            title="View Member">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        <!-- Edit Button -->
                                        <a href="{{ route('members.edit', $member->member_id) }}"
                                            class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top"
                                            title="Edit Member">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <!-- Delete Button with Confirmation -->
                                        <form action="{{ route('members.destroy', $member->member_id) }}" method="POST"
                                            style="display:inline;"
                                            onsubmit="return confirm('Are you sure you want to delete this member?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip"
                                                data-placement="top" title="Delete Member">
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

    /* Status Badge Styling */
    .badge-success {
        background-color: #28a745;
    }

    .badge-danger {
        background-color: #dc3545;
    }

    /* Button Styling */
    .btn-group .btn {
        margin-right: 5px;
        border-radius: 25px;
        font-weight: 500;
    }

    /* Tooltip styling */
    .btn-sm[data-toggle="tooltip"] {
        padding: 5px 10px;
        border-radius: 25px;
    }

    /* Table Border and Shadow */
    .table-responsive {
        border: 1px solid #007bff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
</style>
