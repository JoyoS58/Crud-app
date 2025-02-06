@extends('layouts.app')

@section('content')
    <div class="card p-4 shadow-lg border-1" id="userDetailCard">
        <!-- Page Title -->
        <div class="text-center mb-4">
            <h1 class="display-4 font-weight-bold text-primary">
                <i class="fas fa-user"></i> <span id="userName"></span>
            </h1>
            <p class="text-muted" id="userEmail"></p>
            <hr class="my-4" style="border-top: 2px solid #007bff; width: 50%;">
        </div>

        <!-- User Details Card -->
        <div class="card shadow-sm rounded-lg">
            <div class="card-body">
                <h3 class="mb-3">User Information</h3>
                <ul class="list-group">
                    <li class="list-group-item">
                        <strong>Name:</strong> <span id="userNameDetail"></span>
                    </li>
                    <li class="list-group-item">
                        <strong>Email:</strong> <span id="userEmailDetail"></span>
                    </li>
                    <li class="list-group-item">
                        <strong>Joined:</strong> <span id="userJoined"></span>
                    </li>
                    <li class="list-group-item">
                        <strong>Role:</strong> <span id="userRole"></span>
                    </li>
                    <li class="list-group-item">
                        <strong>Profile:</strong>
                        <img id="userProfile" src="" alt="Profile Image" class="img-fluid rounded">
                    </li>
                </ul>
            </div>
        </div>

        <!-- Back Button -->
        <div class="mt-4 d-flex justify-content-between">
            <a href="{{ route('users.index') }}" class="btn btn-secondary btn-lg">
                <i class="fas fa-arrow-left"></i> Back to Users List
            </a>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Full URL:', window.location.href);
            console.log('Path:', window.location.pathname);

            const userId = window.location.pathname.split('/').pop();
            console.log('Extracted User ID:', userId);

            // Cek apakah userId adalah angka
            if (!isNaN(userId) && Number(userId) > 0) {
                console.log('Valid User ID detected, fetching user data...');

                fetch(`/api/users/${userId}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log('Fetched Data:', data);

                        if (data.user) {
                            const user = data.user;
                            const role = user.role ? user.role.role_name : 'No roles assigned';

                            document.getElementById('userName').textContent = user.name;
                            document.getElementById('userEmail').textContent = user.email;
                            document.getElementById('userNameDetail').textContent = user.name;
                            document.getElementById('userEmailDetail').textContent = user.email;
                            document.getElementById('userJoined').textContent = new Date(user.created_at)
                                .toLocaleDateString();
                            document.getElementById('userRole').textContent = role;

                            if (user.profile) {
                                document.getElementById('userProfile').src =
                                    `/storage/user/profile/${user.profile}`;
                            } else {
                                document.getElementById('userProfile').src = '/path/to/default/image.jpg';
                            }
                        } else {
                            console.error('User not found in the response');
                        }
                    })
                    .catch(error => console.error('Error fetching user data:', error));
            } else {
                console.log('No valid User ID detected, skipping fetch.');
            }
        });
    </script>
@endsection
