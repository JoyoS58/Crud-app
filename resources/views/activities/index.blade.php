@extends('layouts.app')

@section('content')
    <div class="card p-4 shadow-lg border-1">
        <div class="container py-4">
            <!-- Activities Management Title -->
            <div class="text-center mb-4">
                <h1 class="display-4 font-weight-bold text-primary">
                    <i class="fas fa-tasks"></i> Activities Management
                </h1>
                <p class="lead text-muted">
                    Manage and track all activities related to users and groups.
                </p>
                <hr class="my-4" style="border-top: 2px solid #007bff; width: 50%;">
            </div>

            <!-- Add Activity Button -->
            <a href="{{ route('activities.create') }}" class="btn btn-primary mb-3 btn-lg">
                <i class="fas fa-plus-circle"></i> Add New Activity
            </a>

            <!-- Activity List Table -->
            @if ($activities->isEmpty())
                <div class="alert alert-warning text-center">
                    <i class="fas fa-exclamation-circle fa-2x mb-2 text-warning"></i>
                    <h4>No Activities Found</h4>
                    <p class="mb-0">There are no activities to display. Click the <strong>Add New Activity</strong> button above to create one.</p>
                </div>
            @else
                <div class="table-responsive shadow-sm rounded">
                    <table class="table table-hover table-striped table-bordered">
                        <thead class="thead-dark text-center">
                            <tr>
                                <th>#</th>
                                <th>Activity Name</th>
                                <th>Group</th>
                                <th>User</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($activities as $index => $activity)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $activity->activity_name }}</td>
                                    <td>{{ $activity->group->group_name ?? 'N/A' }}</td> <!-- Null-safe -->
                                    <td>{{ $activity->user->name ?? 'N/A' }}</td> <!-- Null-safe -->
                                    <td class="text-center">
                                        <!-- View Button -->
                                        <a href="{{ route('activities.show', $activity->activity_id) }}"
                                            class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top"
                                            title="View Activity">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        <!-- Edit Button -->
                                        <a href="{{ route('activities.edit', $activity->activity_id) }}"
                                            class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top"
                                            title="Edit Activity">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <!-- Delete Button with Confirmation -->
                                        <form action="{{ route('activities.destroy', $activity->activity_id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this activity?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip"
                                                data-placement="top" title="Delete Activity">
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

    /* Button Styling */
    .btn-group .btn {
        margin-right: 5px;
        border-radius: 25px;
        font-weight: 500;
    }

    .btn-lg:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
