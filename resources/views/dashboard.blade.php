{{-- @extends('layouts.app')

@section('content')
    <div class="card p-4 shadow-lg border-1">
        <div class="hero-section">
            <h1>Welcome to the Dashboard</h1>
            <p>Manage Users, Roles, Groups, Members, and Activities with ease.</p>
            <a href="{{ route('users.index') }}">Get Started</a>
        </div>
        <div class="row mt-4">
            <!-- User Management -->
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-1 card-hover">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-users fa-3x text-primary"></i>
                        </div>
                        <h5 class="card-title font-weight-bold">User Management</h5>
                        <p class="card-text">Manage all users in the system, including adding, editing, or removing users.</p>
                        <a href="{{ route('users.index') }}" class="btn btn-primary btn-sm">Manage Users</a>
                    </div>
                </div>
            </div>

            <!-- Role Management -->
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-1 card-hover">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-user-shield fa-3x text-success"></i>
                        </div>
                        <h5 class="card-title font-weight-bold">Role Management</h5>
                        <p class="card-text">Define roles and permissions for better access control.</p>
                        <a href="{{ route('roles.index') }}" class="btn btn-success btn-sm">Manage Roles</a>
                    </div>
                </div>
            </div>

            <!-- Group Management -->
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-1 card-hover">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-layer-group fa-3x text-info"></i>
                        </div>
                        <h5 class="card-title font-weight-bold">Group Management</h5>
                        <p class="card-text">Organize users into groups for streamlined collaboration.</p>
                        <a href="{{ route('groups.index') }}" class="btn btn-info btn-sm">Manage Groups</a>
                    </div>
                </div>
            </div>

            <!-- Member Management -->
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-1 card-hover">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-id-badge fa-3x text-warning"></i>
                        </div>
                        <h5 class="card-title font-weight-bold">Member Management</h5>
                        <p class="card-text">Handle membership information and group associations.</p>
                        <a href="{{ route('members.index') }}" class="btn btn-warning btn-sm text-white">Manage Members</a>
                    </div>
                </div>
            </div>

            <!-- Activity Management -->
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-1 card-hover">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-tasks fa-3x text-danger"></i>
                        </div>
                        <h5 class="card-title font-weight-bold">Activity Management</h5>
                        <p class="card-text">Track and manage activities within the system.</p>
                        <a href="{{ route('activities.index') }}" class="btn btn-danger btn-sm">Manage Activities</a>
                    </div>
                </div>
            </div>

            {{-- <a href="{{ route('') }}" class="btn btn-info btn-sm">Manage Groups</a> --}}
</div>
</div>

<script>
    // $.ajax({
    //     url: '{{ route('dashboard') }}',
    //     type: 'GET',
    //     headers: {
    //         'Authorization': 'Bearer ' + localStorage.getItem('auth_token')
    //     },
    //     success: function(response) {
    //         console.log(response);
    //     }
    // });
    $(document).ready(function() {
            if (localStorage.getItem('auth_token')) {
                $.ajaxSetup({
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('auth_token')
                    }
                });
            }
        });
</script>
<style>
    .card-hover {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card-hover:hover {
        transform: scale(1.05);
        /* Slightly enlarge the card */
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        /* Add a deeper shadow */
    }

    .card-body {
        padding: 20px;
    }

    .card-title {
        font-size: 1.25rem;
    }

    .btn-sm {
        padding: 8px 15px;
        font-size: 1rem;
    }

    .text-primary {
        color: #007bff !important;
    }

    .text-success {
        color: #28a745 !important;
    }

    .text-info {
        color: #17a2b8 !important;
    }

    .text-warning {
        color: #ffc107 !important;
    }

    .text-danger {
        color: #dc3545 !important;
    }

    /* Hero Section */
    .hero-section {
        background: linear-gradient(135deg, #007bff, #00bcd4);
        color: white;
        text-align: center;
        padding: 100px 20px;
        border-radius: 30px;
    }

    .hero-section h1 {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .hero-section p {
        font-size: 1.2rem;
    }

    .hero-section a {
        font-size: 1.2rem;
        color: #fff;
        text-decoration: none;
        padding: 10px 20px;
        background-color: #28a745;
        border-radius: 20px;
        transition: background-color 0.3s ease;
    }

    .hero-section a:hover {
        background-color: #218838;
    }
</style>
@endsection --}}
