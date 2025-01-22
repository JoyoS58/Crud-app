@extends('layouts.home')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card shadow-lg p-4" style="width: 100%; max-width: 400px; border-radius: 10px;">
        <h2 class="text-center mb-4 text-primary">Create an Account</h2>
        <form method="POST" action="{{ route('register') }}" class="needs-validation" novalidate>
            @csrf
            <!-- Name Field -->
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <div class="input-group">
                    <span class="input-group-text bg-primary text-white">
                        <i class="fas fa-user"></i>
                    </span>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        class="form-control" 
                        placeholder="Enter your name" 
                        required>
                    <div class="invalid-feedback">
                        Please provide your name.
                    </div>
                </div>
            </div>
            <!-- Email Field -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <div class="input-group">
                    <span class="input-group-text bg-primary text-white">
                        <i class="fas fa-envelope"></i>
                    </span>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        class="form-control" 
                        placeholder="Enter your email" 
                        required>
                    <div class="invalid-feedback">
                        Please provide a valid email address.
                    </div>
                </div>
            </div>
            <!-- Password Field -->
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-primary text-white">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        class="form-control" 
                        placeholder="Enter your password" 
                        required>
                    <div class="invalid-feedback">
                        Please provide a password.
                    </div>
                </div>
            </div>
            <!-- Confirm Password Field -->
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-primary text-white">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input 
                        type="password" 
                        name="password_confirmation" 
                        id="password_confirmation" 
                        class="form-control" 
                        placeholder="Confirm your password" 
                        required>
                    <div class="invalid-feedback">
                        Please confirm your password.
                    </div>
                </div>
            </div>
            <!-- Role ID -->
            <div class="form-group" style="display: none;">
                <label for="role_id" class="font-weight-bold">Role</label>
                <select name="role_id" id="role_id" class="form-control @error('role_id') is-invalid @enderror" required>
                    <option input="hidden" value="3" selected>Default Role</option>
                    <!-- Add other roles as needed -->
                </select>
                @error('role_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary btn-lg w-100">Register</button>
        </form>
        <!-- Login Link -->
        <div class="text-center mt-3">
            <small>
                Already have an account? 
                <a href="{{ route('login') }}" class="text-primary">Login</a>
            </small>
        </div>
    </div>
</div>
@endsection
