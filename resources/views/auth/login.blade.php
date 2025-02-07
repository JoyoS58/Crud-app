@extends('layouts.login')

@section('title', 'Login')

@section('content')
    <div class="container d-flex justify-content-center align-items-center vh-100 overflow-hidden" style="position:fixed">
        <div class="card shadow p-4" style="width: 100%; max-width: 400px; border-radius: 10px;">
            <h3 class="text-center mb-4 text-primary">Login to Your Account</h3>
            <form id="loginForm">
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
                        <span id="emailError" class="text-red-500 mt-2"></span>
                        {{-- <div class="invalid-feedback">
                            Please enter a valid email address.
                        </div> --}}
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
                        <span id="passwordError" class="text-red-500 mt-2"></span>
                        {{-- <div class="invalid-feedback">
                            Please enter your password.
                        </div> --}}
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
        document.getElementById('loginForm').addEventListener('submit', async function(e) {
            e.preventDefault(); // Mencegah form submit secara default

            const email = document.getElementById('email').value;
            const password = document.querySelector('input[name="password"]').value;

            // $('#loginBtn').prop('disabled', true);

            // Hapus pesan error sebelumnya
            document.getElementById('emailError').innerText = '';
            document.getElementById('passwordError').innerText = '';

            try {
                const response = await fetch('http://127.0.0.1:8000/api/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    body: JSON.stringify({
                        email,
                        password
                    })
                });

                const result = await response.json();

                if (response.ok && response.status === 200) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Login Berhasil!',
                        text: result.message,
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => {
                        window.location.href = '{{ route('dashboard') }}';
                    });
                } else {
                    // Jika login gagal, tampilkan pesan error
                    Swal.fire({
                        icon: 'error',
                        title: 'Login Gagal!',
                        text: result.message,
                        confirmButtonColor: '#d33'
                    });

                    if (result.errors) {
                        if (result.errors.email) {
                            document.getElementById('emailError').innerText = result.errors.email[0];
                        }
                        if (result.errors.password) {
                            document.getElementById('passwordError').innerText = result.errors.password[0];
                        }
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: 'Terjadi kesalahan saat menghubungi server. Coba lagi nanti.',
                    confirmButtonColor: '#d33'
                });
            }
        });
    </script>
@endsection
