@extends('layouts.app')

@section('content')
    <div class="card p-4 shadow-lg border-1">
        <!-- Page Header -->
        <div class="text-center mb-5">
            <h1 class="display-5 font-weight-bold text-primary">
                <i class="fas fa-edit"></i> Edit User
            </h1>
            <p class="lead text-muted">
                Update the user details below. Leave password fields empty to keep the current password.
            </p>
        </div>

        <!-- Edit User Form -->
        <div class="card shadow-sm rounded-lg">
            <div class="card-body">
                <!-- Remove action attribute so we handle submission via JavaScript -->
                <form id="editUserForm" enctype="multipart/form-data">
                    @csrf
                    <!-- Laravel method spoofing: field _method=PUT -->
                    <input type="hidden" name="_method" value="PUT">

                    <!-- Name Field -->
                    <div class="mb-4">
                        <label for="name" class="form-label font-weight-bold">Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>

                    <!-- Email Field -->
                    <div class="mb-4">
                        <label for="email" class="form-label font-weight-bold">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>

                    <!-- Profile Picture Field -->
                    <div class="mb-4">
                        <label for="profile" class="form-label font-weight-bold">Profile Picture</label>
                        <input type="file" name="profile" id="profile" class="form-control">
                        <!-- Preview current profile image -->
                        <div id="currentProfileImage" class="mt-2"></div>
                    </div>

                    <!-- Current Password Field -->
                    <div class="mb-4">
                        <label for="current_password" class="form-label font-weight-bold">Current Password</label>
                        <input type="password" name="current_password" id="current_password" class="form-control">
                        <small class="form-text text-muted">Required if changing data.</small>
                    </div>

                    <!-- New Password Field -->
                    <div class="mb-4">
                        <label for="password" class="form-label font-weight-bold">New Password</label>
                        <input type="password" name="password" id="password" class="form-control">
                        <small class="form-text text-muted">Leave blank to keep the current password.</small>
                    </div>

                    <!-- Confirm New Password Field -->
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label font-weight-bold">Confirm New Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('users.index') }}" class="btn btn-secondary px-4 py-2">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                        <button type="submit" class="btn btn-primary px-4 py-2">
                            <i class="fas fa-save"></i> Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript Section -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Assuming route format is /users/{userId}/edit, e.g. "/users/5/edit"
            const segments = window.location.pathname.split('/').filter(seg => seg !== "");
            // The userId is the segment immediately before 'edit'
            let userId = segments[segments.length - 2];
            console.log("Extracted User ID:", userId);

            // Fetch user data from API to pre-fill form
            fetch(`/api/users/${userId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.user) {
                        const user = data.user;
                        document.getElementById("name").value = user.name;
                        document.getElementById("email").value = user.email;

                        if (user.profile) {
                            document.getElementById("currentProfileImage").innerHTML =
                                `<img src="/storage/user/profile/${user.profile}" alt="Current Profile" class="img-thumbnail" width="150">`;
                        }
                    } else {
                        console.error("User not found in API response.");
                    }
                })
                .catch(error => console.error("Error fetching user data:", error));

            // Handle form submission via fetch
            document.getElementById("editUserForm").addEventListener("submit", async function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                try {
                    let response = await fetch(`/api/users/${userId}`, {
                        method: "POST", // using POST with _method=PUT (Laravel method spoofing)
                        body: formData,
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                            "Accept": "application/json"
                        }
                    });
                    let data = await response.json();
                    if (!response.ok) {
                        throw new Error(data.message || "Failed to update user.");
                    }
                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: data.message,
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => {
                        window.location.href = "/users";
                    });
                } catch (error) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: error.message,
                        showConfirmButton: true
                    });
                }
            });
        });
    </script>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/user-styles.css') }}">
@endsection
