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
                <form id="createUserForm">
                    @csrf

                    <!-- Name -->
                    <div class="form-group">
                        <label for="name" class="font-weight-bold">Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter full name" required>
                        <span class="text-danger" id="error-name"></span>
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email" class="font-weight-bold">Email</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Enter email" required>
                        <span class="text-danger" id="error-email"></span>
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password" class="font-weight-bold">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                        <span class="text-danger" id="error-password"></span>
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group">
                        <label for="password_confirmation" class="font-weight-bold">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                    </div>

                    <!-- Role ID -->
                    <div class="form-group">
                        <label for="role_id" class="font-weight-bold">Role</label>
                        <select name="role_id" id="role_id" class="form-control h-100" required>
                            <option value="" hidden >Select Role</option>
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
        document.addEventListener('DOMContentLoaded', function () {
            // Load Roles via AJAX
            fetch('/api/users/create')
                .then(response => response.json())
                .then(data => {
                    let roleSelect = document.getElementById('role_id');
                    data.roles.forEach(roles => {
                        let option = document.createElement('option');
                        option.value = roles.role_id;
                        option.textContent = roles.role_name;
                        roleSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error loading roles:', error));

            // Handle Form Submission via AJAX
            document.getElementById('createUserForm').addEventListener('submit', function (event) {
                event.preventDefault(); // Prevent normal form submission

                let form = event.target;
                let formData = new FormData(form);
                let successMessage = document.getElementById('success-message');

                // Clear previous error messages
                document.querySelectorAll('.text-danger').forEach(el => el.textContent = '');

                fetch('/api/users', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        successMessage.textContent = data.message;
                        successMessage.classList.remove('d-none');

                        // Reset form fields
                        form.reset();

                        // Hide success message after 3 seconds
                        setTimeout(() => successMessage.classList.add('d-none'), 3000);
                    } else {
                        // Handle validation errors
                        if (data.errors) {
                            for (let key in data.errors) {
                                document.getElementById('error-' + key).textContent = data.errors[key][0];
                            }
                        }
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        });
    </script>
<link rel="stylesheet" href="{{ asset('css/user-styles.css') }}">
<script src="{{ asset('js/user-script.js') }}"></script>
@endsection