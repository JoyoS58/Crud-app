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

            <!-- Add User Button, Search -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="{{ route('users.create') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-user-plus"></i> Add User
                </a>
                <div class="d-flex align-items-center">
                    <form method="GET" action="#" class="d-flex" id="searchForm">
                        <div class="input-group">
                            <input type="text" id="searchInput" name="search" class="form-control"
                                placeholder="Search users..." onkeyup="searchUsers()">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- User Table -->
            <div class="table-responsive shadow-sm rounded">
                <table class="table table-hover table-striped table-bordered" id="usersTable">
                    <thead class="thead-dark text-center">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="userTableBody">
                        <!-- Users data will be populated here by AJAX -->
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
        // Fungsi untuk mengambil data user dengan opsi pencarian
        function fetchUsers(search = '') {
            // Siapkan URL dasar dari route API
            let url = "{{ route('api.users.index') }}";
            // Jika ada nilai pencarian, tambahkan sebagai query string
            if (search.trim() !== '') {
                url += "?search=" + encodeURIComponent(search);
            }
            
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const users = data.users;
                    let rows = '';

                    users.forEach((user, index) => {
                        rows += `
                            <tr>
                                <td>${index + 1}</td>
                                <td><strong>${user.name}</strong></td>
                                <td>${user.email}</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group" aria-label="User Actions">
                                        <a href="/users/${user.user_id}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> Show
                                        </a>
                                        <a href="/users/${user.user_id}/edit" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(${user.user_id})">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        `;
                    });

                    // Update isi tbody dengan data yang sudah dibangun
                    document.getElementById('userTableBody').innerHTML = rows;
                })
                .catch(error => console.error('Error fetching users:', error));
        }

        // Fungsi untuk memanggil fetchUsers dengan nilai pencarian dari input
        function searchUsers() {
            const searchTerm = document.getElementById("searchInput").value;
            fetchUsers(searchTerm);
        }

        // Panggil fetchUsers saat halaman selesai dimuat untuk menampilkan semua user
        document.addEventListener('DOMContentLoaded', function() {
            fetchUsers();
        });

        // Fungsi untuk mengonfirmasi dan menghapus user
        function confirmDelete(userId) {
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
                    deleteUser(userId);
                }
            });
        }

        function deleteUser(userId) {
            fetch(`/api/users/${userId}`, {
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
                        fetchUsers();
                    } else {
                        Swal.fire({
                            icon: "error",
                            text: data.message,
                            showConfirmButton: true
                        });
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    Swal.fire({
                        icon: "error",
                        text: "An error occurred while deleting the user.",
                        showConfirmButton: true
                    });
                });
        }
    </script>
@endsection
