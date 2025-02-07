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

            <!-- Add Role Button & Search Input -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="{{ route('roles.create') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus-circle"></i> Add Role
                </a>
                <div class="d-flex align-items-center">
                    <input type="text" id="searchInput" class="form-control" placeholder="Search roles..."
                        onkeyup="searchRoles()">
                </div>
            </div>

            <!-- Role List Table -->
            <div class="table-responsive shadow-sm rounded">
                <table class="table table-hover table-striped table-bordered" id="rolesTable">
                    <thead class="thead-dark text-center">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Users</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="roleTableBody">
                        <!-- Roles data will be populated here by AJAX -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="{{ asset('css/user-styles.css') }}">

    <!-- Include SweetAlert Library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Custom Scripts -->
    <script>
        function fetchRoles(search = '') {
            let url = "{{ route('api.roles.index') }}";
            if (search.trim() !== '') {
                url += "?search=" + encodeURIComponent(search);
            }

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const roles = data.roles;
                    let rows = '';

                    roles.forEach((role, index) => {
                        rows += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${role.role_name}</td>
                                <td>${role.role_description || ''}</td>
                                <td>${role.user_count || 0}</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group" aria-label="Role Actions">
                                        <a href="/roles/${role.role_id}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> Show
                                        </a>
                                        <a href="/roles/${role.role_id}/edit" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmRoleDelete(${role.role_id})">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        `;
                    });

                    document.getElementById('roleTableBody').innerHTML = rows;
                })
                .catch(error => console.error('Error fetching roles:', error));
        }

        let roleSearchTimeout;
        function searchRoles() {
            clearTimeout(roleSearchTimeout);
            roleSearchTimeout = setTimeout(() => {
                const searchTerm = document.getElementById("searchInput").value;
                fetchRoles(searchTerm);
            }, 300);
        }

        function confirmRoleDelete(roleId) {
            Swal.fire({
                title: "Are you sure?",
                text: "This action cannot be undone!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteRole(roleId);
                }
            });
        }

        function deleteRole(roleId) {
            fetch(`/api/roles/${roleId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: "success",
                            text: data.message,
                            showConfirmButton: false,
                            timer: 2000
                        });
                        fetchRoles();
                    } else {
                        Swal.fire({
                            icon: "error",
                            text: data.message || "Failed to delete role.",
                            showConfirmButton: true
                        });
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    Swal.fire({
                        icon: "error",
                        text: "An error occurred while deleting the role.",
                        showConfirmButton: true
                    });
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            fetchRoles();
        });
    </script>
@endsection

@section('scripts')
    <script>
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

    /* Tooltip Styling */
    .btn-sm[data-toggle="tooltip"] {
        padding: 5px 10px;
        border-radius: 25px;
    }

    /* Hover effect for large buttons */
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
