@extends('layouts.home')

@section('content')
<div class="container-fluid p-0 top-0 container justify-content-center align-items-center overflow-hidden" style="position:relative">
    <!-- Hero Section -->
    <div class="bg-primary text-white text-center py-5" style="overflow: hidden;">
        <h1 class="display-4 fw-bold">Welcome to User Management</h1>
        <p class="lead">Effortlessly manage users, roles, and activities in one place.</p>
        <a href="{{ route('users.index') }}" class="btn btn-lg btn-light text-primary mt-3">Get Started</a>
    </div>

    <!-- Features Section -->
    <div class="container mt-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Features</h2>
            <p class="text-muted">Discover the tools to streamline your user management workflow.</p>
        </div>
        <div class="row">
            <div class="col-md-4 text-center">
                <div class="card shadow p-3">
                    <div class="card-body">
                        <h5 class="card-title text-primary"><i class="bi bi-people-fill fs-1"></i></h5>
                        <h5>User Management</h5>
                        <p class="text-muted">Create, update, and manage user accounts with ease.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <div class="card shadow p-3">
                    <div class="card-body">
                        <h5 class="card-title text-success"><i class="bi bi-shield-lock-fill fs-1"></i></h5>
                        <h5>Role Management</h5>
                        <p class="text-muted">Define roles and permissions to control access.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <div class="card shadow p-3">
                    <div class="card-body">
                        <h5 class="card-title text-warning"><i class="bi bi-activity fs-1"></i></h5>
                        <h5>Activity Tracking</h5>
                        <p class="text-muted">Track user actions to maintain a secure environment.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities Section -->
    <div class="container mt-5">
        <div class="text-center mb-4">
            <h2 class="fw-bold">Recent Activities</h2>
            <p class="text-muted">Stay updated with the latest activities in your system.</p>
        </div>
        <div class="card">
            <div class="card-body">
                <ul class="list-group">
                    @foreach ($activities as $activity)
                        <li class="list-group-item">{{ $activity }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <!-- Testimonials Section -->
    <div class="bg-light py-5 mt-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">What Our Users Say</h2>
                <p class="text-muted">Here’s how User Management has helped others.</p>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="card shadow border-0 p-4">
                        <p class="fst-italic">"User Management has made it so much easier to manage our team. Highly recommended!"</p>
                        <h6 class="text-primary fw-bold">- John Doe</h6>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow border-0 p-4">
                        <p class="fst-italic">"I love how intuitive the interface is. It saves me so much time."</p>
                        <h6 class="text-primary fw-bold">- Sarah Smith</h6>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow border-0 p-4">
                        <p class="fst-italic">"The activity tracking feature is a game-changer for our security team."</p>
                        <h6 class="text-primary fw-bold">- Michael Lee</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
