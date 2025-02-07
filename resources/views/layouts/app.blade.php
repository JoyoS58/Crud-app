<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <style>
        .sidebar {
            transition: transform 0.3s ease;
        }

        .sidebar.hidden {
            transform: translateX(-100%);
        }

        @media (min-width: 768px) {
            .sidebar {
                transform: translateX(0);
            }

            .sidebar.hidden {
                transform: translateX(-100);
            }

            .main-content.full-width {
                margin-left: 0;
            }

            .header.full-width {
                left: 0;
            }
        }

        @media (max-width: 767px) {
            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                height: 100%;
                width: 250px;
                background-color: #f8f9fa;
                z-index: 1000;
                transform: translateX(-100%);
            }

            .sidebar.hidden {
                transform: translateX(-100%);
            }

            .main-content {
                margin-left: 0;
            }

            .header {
                padding-left: 0;
                left: 0;
                width: 100%;
            }

            .footer {
                padding-left: 0;
            }
        }

        .main-content {
            transition: margin-left 0.3s ease;
        }

        .main-content.full-width {
            margin-left: 0;
        }

        .header.full-width {
            margin-left: 0;
        }

        .footer.full-width {
            margin-left: 0;
        }
    </style>
</head>

<body onload="loadSidebarState()">
    <!-- Header -->
    <div class="header shadow">
        <div class="hamburger" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </div>
        <h5 class="m-0"></h5>
        <div class="text-center mb-4 pt-4">
            {{ Auth::user()->name }}
            @if (Auth::user()->profile)
                <img src="{{ asset('storage/user/profile/' . Auth::user()->profile) }}" alt="Profile Picture" class="rounded-circle" width="50" height="50" style="margin-top: 3px; margin-left:5px;">
            @else
                <i class="fas fa-user" style="margin-left: 5px; border-width: 1px"></i>
            @endif
        </div>
    </div>

    <div class="container-fluid">
        <!-- Sidebar -->
        <div class="sidebar shadow">
            <div>
                <h4>Welcome, {{ Auth::user()->name }}!</h4>
                <div class=" d-flex align-items-center mb-3 mt-3">
                    <h4><i class="fas fa-house-user mr-2" style="color: #0065d1"></i>
                        <strong>
                            <a href="{{ route('dashboard') }}">Dashboard</a>
                        </strong>
                    </h4>
                </div>
                <ul class="nav nav-pills flex-column mt-3">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::routeIs('users*') ? 'active' : '' }}"
                            href="{{ route('users.index') }}">
                            <i class="fas fa-users"></i>User
                        </a>
                    </li>
                    <li class="nav-item"> 
                        <a class="nav-link {{ Request::routeIs('roles*') ? 'active' : '' }}"
                            href="{{ route('roles.index') }}">
                            <i class="fas fa-user-shield"></i>Role
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link {{ Request::routeIs('groups*') ? 'active' : '' }}"
                            href="{{ route('groups.index') }}">
                            <i class="fas fa-layer-group"></i>Group
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::routeIs('members*') ? 'active' : '' }}"
                            href="{{ route('members.index') }}">
                            <i class="fas fa-id-badge"></i>Member
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::routeIs('activities*') ? 'active' : '' }}"
                            href="{{ route('activities.index') }}">
                            <i class="fas fa-tasks"></i>Activity
                        </a>
                    </li> --}}
                <li class="nav-item logout-btn">
                    <!-- Logout Button with AJAX -->
                    <button id="logoutBtn" class="btn btn-danger btn-block nav-link">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Content -->
            @yield('content')
        </div>
    </div>

    <script>
        $(document).ready(function() {
            if (localStorage.getItem('auth_token')) {
                $.ajaxSetup({
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('auth_token')
                    }
                });
            }
            $('#logoutBtn').click(function(e) {
                e.preventDefault(); // Prevent default form submission

                // AJAX logout request
                $.ajax({
                    url: '{{ route('logout') }}', // Pastikan route logout benar
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}', // Kirim CSRF token
                    },
                    success: function(response) {
                        // Berhasil logout, arahkan ke halaman login
                        Swal.fire({
                            title: 'Logout Success',
                            text: 'You have successfully logged out.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(function() {
                            // Redirect ke halaman login setelah logout
                            window.location.replace("{{ route('login') }}");
                        });
                    },
                    error: function(xhr, status, error) {
                        // Handle errors (Optional)
                        Swal.fire({
                            title: 'Logout Failed',
                            text: 'There was an error logging you out. Please try again.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });

        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            const header = document.querySelector('.header');
            const mainContent = document.querySelector('.main-content');
            const footer = document.querySelector('.footer');
            sidebar.classList.toggle('hidden');
            header.classList.toggle('full-width');
            mainContent.classList.toggle('full-width');
            footer.classList.toggle('full-width');
            saveSidebarState();
        }

        function saveSidebarState() {
            const sidebar = document.querySelector('.sidebar');
            localStorage.setItem('sidebarHidden', sidebar.classList.contains('hidden'));
        }

        function loadSidebarState() {
            const sidebarHidden = localStorage.getItem('sidebarHidden') === 'true';
            const sidebar = document.querySelector('.sidebar');
            const header = document.querySelector('.header');
            const mainContent = document.querySelector('.main-content');
            const footer = document.querySelector('.footer');
            if (sidebarHidden) {
                sidebar.classList.add('hidden');
                header.classList.add('full-width');
                mainContent.classList.add('full-width');
                footer.classList.add('full-width');
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
