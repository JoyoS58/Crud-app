@extends('layouts.home')

@section('title', 'Login')

@section('content')
    <div class="container d-flex justify-content-center align-items-center vh-100 overflow-hidden" style="position: fixed">
        <div class="card shadow p-4" style="width: 100%; max-width: 400px; border-radius: 10px;">
            <h3 class="text-center mb-4 text-primary">Login to Your Account</h3>
            <form id="loginForm" class="needs-validation" novalidate>
                @csrf
                <!-- Email Field -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text bg-primary text-white">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input type="email" id="email" name="email" class="form-control"
                            placeholder="Enter your email" required>
                        <div class="invalid-feedback">
                            Please enter a valid email address.
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
                        <input type="password" id="password" name="password" class="form-control"
                            placeholder="Enter your password" required>
                        <div class="invalid-feedback">
                            Please enter your password.
                        </div>
                    </div>
                </div>
                <!-- Remember Me -->
                <div class="form-check mb-3">
                    <input type="checkbox" id="remember" name="remember" class="form-check-input">
                    <label for="remember" class="form-check-label">Remember Me</label>
                </div>
                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary w-100" id="loginBtn">Login</button>
            </form>
            <!-- Additional Links -->
            <div class="text-center mt-3">
                <small>
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-primary">Register here</a>
                </small>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#loginForm').submit(function(e) {
                e.preventDefault(); // Mencegah form submit default

                var formData = {
                    email: $('#email').val(),
                    password: $('#password').val()
                };

                $('#loginBtn').prop('disabled', true); // Disable tombol saat request berjalan

                $.ajax({
                    url: '{{ route('api.login') }}',
                    type: 'POST',
                    xhrFields: {
                        withCredentials: true
                    }, // Pastikan cookie dikirim
                    contentType: 'application/json',
                    data: JSON.stringify(formData),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Accept': 'application/json'
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.status === 'success') {
                            window.location.href =
                            '{{ route('dashboard') }}'; // Redirect ke dashboard
                        } else {
                            alert(response.message);
                            $('#loginBtn').prop('disabled', false);
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        alert("Terjadi kesalahan saat login.");
                        $('#loginBtn').prop('disabled', false);
                    }
                });

            });
        });
    </script>
@endsection
