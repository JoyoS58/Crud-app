@extends('layouts.app')

@section('content')
    <div class="card p-4 shadow-lg border-1">
        <!-- Page Title -->
        <div class="text-center mb-4">
            <h1 class="display-5 font-weight-bold text-primary">
                <i class="fas fa-user-tag"></i> Create Role
            </h1>
            <p class="lead text-muted">
                Add a new role to manage permissions and responsibilities.
            </p>
        </div>

        <!-- Role Creation Form -->
        <div class="card shadow-sm">
            <div class="card-body">
                <form id="createRoleForm">
                    @csrf

                    <!-- Role Name -->
                    <div class="form-group">
                        <label for="role_name" class="font-weight-bold">Role Name</label>
                        <input type="text" name="role_name" id="role_name" class="form-control"
                            placeholder="Enter role name" required>
                        <span class="text-danger" id="error-role_name"></span>
                    </div>

                    <!-- Role Description -->
                    <div class="form-group">
                        <label for="role_description" class="font-weight-bold">Description</label>
                        <textarea name="role_description" id="role_description" class="form-control"
                            placeholder="Enter a brief description for the role" ></textarea>
                        <span class="text-danger" id="error-role_description"></span>
                    </div>

                    <!-- Form Buttons -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('roles.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Role
                        </button>
                    </div>

                    <!-- Success Message (Optional) -->
                    <div id="success-message" class="alert alert-success mt-3 d-none"></div>
                </form>
            </div>
        </div>
    </div>

    <!-- Include SweetAlert Library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Custom Script for Role Create -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('createRoleForm').addEventListener('submit', async function(event) {
                event.preventDefault();

                const form = event.target;
                const formData = new FormData(form);

                // Bersihkan pesan error sebelumnya
                document.querySelectorAll('.text-danger').forEach(el => el.textContent = '');

                try {
                    // Kirim data menggunakan fetch ke endpoint API roles store
                    const response = await fetch("{{ route('api.roles.store') }}", {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    });

                    // Ambil response sebagai text terlebih dahulu
                    const text = await response.text();
                    let data;
                    try {
                        data = JSON.parse(text);
                    } catch (error) {
                        throw new Error('Server returned HTML instead of JSON.');
                    }

                    if (!response.ok) {
                        if (response.status === 422 && data.errors) {
                            // Tampilkan pesan error validasi untuk masing-masing field
                            for (let key in data.errors) {
                                let errorElement = document.getElementById('error-' + key);
                                if (errorElement) {
                                    errorElement.textContent = data.errors[key][0];
                                }
                            }
                            Swal.fire({
                                icon: 'error',
                                text: 'Please check your input.',
                                showConfirmButton: true
                            });
                        } else {
                            throw new Error(data.message || 'An error occurred.');
                        }
                    } else {
                        Swal.fire({
                            icon: 'success',
                            text: data.message,
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            window.location.href = "{{ route('roles.index') }}";
                        });
                    }
                } catch (error) {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        text: error.message || 'Server error occurred.',
                        showConfirmButton: true
                    });
                }
            });
        });
    </script>
@endsection

@section('styles')
    <style>
        /* Styling for the form controls */
        .form-control {
            border-radius: 8px;
        }

        .form-control:focus {
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.8);
            border-color: #007bff;
        }

        /* Card styling */
        .card {
            border: 1px solid #007bff;
            border-radius: 12px;
        }

        .card-body {
            padding: 2rem;
        }
    </style>
@endsection
