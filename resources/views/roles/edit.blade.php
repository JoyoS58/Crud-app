@extends('layouts.app')

@section('content')
    <div class="card p-4 shadow-lg border-1">
        <!-- Page Header -->
        <div class="text-center mb-5">
            <h1 class="display-5 font-weight-bold text-primary">
                <i class="fas fa-edit"></i> Edit Role
            </h1>
            <p class="lead text-muted">
                Update the role details below.
            </p>
        </div>

        <!-- Edit Role Form -->
        <div class="card shadow-sm rounded-lg">
            <div class="card-body">
                <!-- Form tanpa action karena submission dilakukan via JavaScript -->
                <form id="editRoleForm" enctype="multipart/form-data">
                    @csrf
                    <!-- Laravel method spoofing: field _method=PUT -->
                    <input type="hidden" name="_method" value="PUT">

                    <!-- Role Name Field -->
                    <div class="mb-4">
                        <label for="role_name" class="form-label font-weight-bold">Role Name</label>
                        <input type="text" name="role_name" id="role_name" class="form-control" required>
                    </div>

                    <!-- Role Description Field -->
                    <div class="mb-4">
                        <label for="role_description" class="form-label font-weight-bold">Role Description</label>
                        <textarea name="role_description" id="role_description" class="form-control" rows="4"
                            placeholder="Enter role description"></textarea>
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('roles.index') }}" class="btn btn-secondary px-4 py-2">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                        <button type="submit" class="btn btn-primary px-4 py-2">
                            <i class="fas fa-save"></i> Update Role
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript Section -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Ekstrak roleId dari URL.
            // Asumsikan URL: /roles/{roleId}/edit, misalnya "/roles/5/edit"
            const segments = window.location.pathname.split('/').filter(seg => seg !== "");
            // Role ID adalah segmen sebelum "edit"
            let roleId = segments[segments.length - 2];
            console.log("Extracted Role ID:", roleId);

            // Fetch data role dari API untuk mengisi form
            fetch(`/api/roles/${roleId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.role) {
                        const role = data.role;
                        document.getElementById("role_name").value = role.role_name;
                        document.getElementById("role_description").value = role.role_description || '';
                    } else {
                        console.error("Role not found in API response.");
                    }
                })
                .catch(error => console.error("Error fetching role data:", error));

            // Handle form submission via fetch
            document.getElementById("editRoleForm").addEventListener("submit", async function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                try {
                    let response = await fetch(`/api/roles/${roleId}`, {
                        method: "POST", // Menggunakan POST dengan _method=PUT untuk method spoofing
                        body: formData,
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                            "Accept": "application/json"
                        }
                    });
                    let data = await response.json();
                    if (!response.ok) {
                        throw new Error(data.message || "Failed to update role.");
                    }
                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: data.message,
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => {
                        window.location.href = "/roles";
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
