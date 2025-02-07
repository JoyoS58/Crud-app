@extends('layouts.app')

@section('content')
    <div class="card p-4 shadow-lg border-1">
        <!-- Page Title -->
        <div class="text-center mb-4">
            <h1 class="display-5 font-weight-bold text-primary">
                <i class="fas fa-user-plus"></i> Create User
            </h1>
            <p class="lead text-muted">
                Add a new user with relevant details and permissions.
            </p>
        </div>

        <!-- User Creation Form -->
        <div class="card shadow-sm">
            <div class="card-body">
                <!-- User Creation Form -->
                <form id="createUserForm">
                    @csrf

                    <!-- Name -->
                    <div class="form-group">
                        <label for="name" class="font-weight-bold">Name</label>
                        <input type="text" name="name" id="name" class="form-control"
                            placeholder="Enter full name" required>
                        <span class="text-danger" id="error-name"></span>
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email" class="font-weight-bold">Email</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Enter email"
                            required>
                        <span class="text-danger" id="error-email"></span>
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password" class="font-weight-bold">Password</label>
                        <input type="password" name="password" id="password" class="form-control"
                            placeholder="Enter password" required>
                        <span class="text-danger" id="error-password"></span>
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group">
                        <label for="password_confirmation" class="font-weight-bold">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                            placeholder="Enter confirm password" required>
                    </div>

                    <!-- Role ID -->
                    <div class="form-group">
                        <label for="role_id" class="font-weight-bold">Role</label>
                        <select name="role_id" id="role_id" class="form-control h-100" required>
                            <option value="" hidden>Select Role</option>
                        </select>
                        <span class="text-danger" id="error-role_id"></span>
                    </div>

                    <!-- Form Buttons -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save User
                        </button>
                    </div>

                    <!-- Success Message -->
                    <div id="success-message" class="alert alert-success mt-3 d-none"></div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Muat daftar roles via AJAX
            fetch('{{ route('api.users.create') }}')
                .then(response => response.json())
                .then(data => {
                    let roleSelect = document.getElementById('role_id');
                    data.roles.forEach(role => {
                        let option = document.createElement('option');
                        // Pastikan nama properti sesuai dengan response API (misal role_id & role_name)
                        option.value = role.role_id;
                        option.textContent = role.role_name;
                        roleSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error loading roles:', error));

            document.getElementById('createUserForm').addEventListener('submit', async function(event) {
                event.preventDefault();

                const form = event.target;
                const formData = new FormData(form);

                // Bersihkan pesan error sebelumnya
                document.querySelectorAll('.text-danger').forEach(el => el.textContent = '');

                try {
                    const response = await fetch('{{ route('api.users.store') }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                        }
                    });

                    // Cek apakah response berbentuk JSON
                    const text = await response.text();
                    let data;
                    try {
                        data = JSON.parse(text);
                    } catch (error) {
                        throw new Error('Server mengembalikan HTML, bukan JSON.');
                    }

                    if (!response.ok) {
                        if (response.status === 422) {
                            for (let key in data.errors) {
                                let errorElement = document.getElementById('error-' + key);
                                if (errorElement) {
                                    errorElement.textContent = data.errors[key][0];
                                }
                            }
                            Swal.fire({
                                icon: 'error',
                                text: 'Periksa kembali data yang diisi.',
                                showConfirmButton: true
                            });
                        } else {
                            throw new Error(data.message || 'Terjadi kesalahan.');
                        }
                    } else {
                        Swal.fire({
                            icon: 'success',
                            text: data.message,
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            window.location.href = '{{ route('users.index') }}';
                        });
                    }
                } catch (error) {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        text: error.message || 'Terjadi kesalahan pada server.',
                        showConfirmButton: true
                    });
                }
            });
        });
    </script>
    <link rel="stylesheet" href="{{ asset('css/user-styles.css') }}">
    <script src="{{ asset('js/user-script.js') }}"></script>
@endsection
