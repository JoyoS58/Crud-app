@extends('layouts.app')

@section('content')
    <div class="card p-4 shadow-lg border-1" id="roleDetailCard">
        <!-- Page Title -->
        <div class="text-center mb-4">
            <h1 class="display-4 font-weight-bold text-primary">
                <i class="fas fa-user-tag"></i> <span id="roleName"></span>
            </h1>
            <p class="text-muted" id="roleDescription"></p>
            <hr class="my-4" style="border-top: 2px solid #007bff; width: 50%;">
        </div>

        <!-- Users Assigned to this Role -->
        <h3 class="mb-3">Users in this Role</h3>
        <div id="roleUsersContainer">
            <!-- Jika tidak ada user, pesan akan muncul di sini -->
        </div>

        <!-- Back Button -->
        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('roles.index') }}" class="btn btn-secondary btn-lg">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ekstrak roleId dari URL. Misal URL: /roles/1
            const segments = window.location.pathname.split('/').filter(seg => seg !== '');
            const roleId = segments[segments.length - 1];
            console.log('Extracted Role ID:', roleId);

            // Ambil data role dan users dari API
            fetch(`/api/roles/${roleId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.role) {
                        const role = data.role;
                        document.getElementById('roleName').textContent = role.role_name;
                        document.getElementById('roleDescription').textContent =
                            role.role_description || 'No description provided.';

                        // Filter data.users berdasarkan role_id
                        const assignedUsers = data.users.filter(user => user.role_id == role.role_id);

                        // Container untuk menampilkan data pengguna
                        const container = document.getElementById('roleUsersContainer');

                        if (assignedUsers.length === 0) {
                            // Jika tidak ada pengguna yang terkait, tampilkan pesan
                            container.innerHTML = `<div class="alert alert-warning">
                            <i class="fas fa-exclamation-circle"></i> No users assigned to this role.
                        </div>`;
                        } else {
                            // Jika ada, buat tabel untuk menampilkan data
                            let tableHTML = `
                        <div class="table-responsive shadow-sm rounded">
                            <table class="table table-hover table-striped table-bordered">
                                <thead class="thead-dark text-center">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody>`;

                            assignedUsers.forEach((user, index) => {
                                tableHTML += `
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td><strong>${user.name}</strong></td>
                                        <td>${user.email}</td>
                                    </tr>`;
                            });

                            tableHTML += `
                                </tbody>
                            </table>
                        </div>`;
                            container.innerHTML = tableHTML;
                        }
                    } else {
                        console.error('Role not found in the response.');
                    }
                })
                .catch(error => console.error('Error fetching role data:', error));
        });
    </script>
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

        /* Table Styling */
        .table-bordered th,
        .table-bordered td {
            border: 2px solid #007bff;
        }

        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
            transition: background-color 0.2s ease-in-out;
        }

        /* Alert Styling */
        .alert-warning {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
            border-radius: 8px;
            padding: 1rem;
        }

        /* Button Styling */
        .btn-secondary {
            background-color: #6c757d;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }
    </style>
@endsection
