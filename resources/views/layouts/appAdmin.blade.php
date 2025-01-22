<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/font-awesome.min.css">

    <style>
        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 17%;
            background-color: #fff;
            color: #007bff;
            padding: 30px 30px;
            overflow-y: auto;
            /* transition: transform 0.1s ease-in-out; */
            border-right: 1px solid #007bff;
            z-index: 900;
        }

        .sidebar.hidden {
            transform: translateX(-100%);
            height: 100%;
            padding: 0 0;
        }

        .sidebar h4 a {
            text-decoration: none;
            align-items: center;
            color: inherit;
            font-size: 1.5rem;
            font-weight: bold;
            text-transform: uppercase;
        }

        .nav-link {
            display: flex;
            align-items: center;
            margin: 5px 0;
            font-size: 1.1rem;
        }

        .nav-link i {
            margin-right: 12px;
            font-size: 1.3rem;
        }

        .nav-link i.hidden {
            display: flex;
            align-items: right;
            margin-left: 90%;
            margin-right: 30%;
        }

        .nav-link:hover {
            background-color: #007bff;
            color: #fff;
        }

        .nav-link.active {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            position: fixed;
            top: 0;
            left: 17%;
            width: 83%;
            z-index: 1000;
            height: 70px;
        }

        .header.full-width {
            /* left: 3.4%; */
            /* width: 96.6%; */
            left: 0;
            width: 100%;
        }

        .header .hamburger {
            font-size: 1.5rem;
            cursor: pointer;
        }

        .header .profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        /* Main Content */
        .main-content {
            margin-left: 17%;
            padding: 20px;
            margin-top: 70px;
            /* transition: margin-left 0.3s ease; */
        }

        .main-content.full-width {
            margin-left: 0;
        }

        /* Footer */
        .footer {
            position: relative;
            bottom: 0;
            left: 17%;
            width: 83%;
            background-color: #fff;
            border-top: 1px solid #ddd;
            text-align: center;
            padding: 10px 10px;
            z-index: 830;
        }

        .footer.full-width {
            left: 0;
            width: 100%;
        }

        /* Logout Button */
        .logout-btn {
            position: absolute;
            bottom: 20px;
            left: 15px;
            width: calc(100% - 30px);
        }
        
        .logout-btn .nav-link:hover {
            background-color: red;
            color: #fff;
        }

        .logout-btn.hidden {
            bottom: 15%;
            padding: 0 0;
            left: 30px;
            right: 0;
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
        {{-- <div class="profile">
            <i class="fas fa-user" style="color: #fff; font-size: 1.2rem;"></i> Profile
        </div> --}}
        <div class="text-center mb-4 pt-4">
            {{ Auth::user()->name }}
            <img src="{{ asset('storage/user/profile/' . Auth::user()->profile) }}" alt="Profile Picture" class="rounded-circle" width="50" height="50" style="margin-top: 3px">
        </div>
    </div>

    <div class="container-fluid">
        <!-- Sidebar -->
        <div class="sidebar shadow">
            <div>
                <div class=" d-flex align-items-center mb-4 mt-3">
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
                    <li class="nav-item">
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
                    </li>
                    <li class="nav-item logout-btn">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-block nav-link">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Content -->
            @yield('content')
        </div>

        {{-- <!-- Footer -->
        <div class="footer">
            <p>&copy; 2025 My Dashboard. All rights reserved.</p>
        </div> --}}
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            const header = document.querySelector('.header');
            const mainContent = document.querySelector('.main-content');
            const footer = document.querySelector('.footer');
            const navLinks = document.querySelectorAll('.nav-link i');
            const logoutBtn = document.querySelector('.logout-btn');
            sidebar.classList.toggle('hidden');
            header.classList.toggle('full-width');
            mainContent.classList.toggle('full-width');
            footer.classList.toggle('full-width');
            navLinks.forEach(navLink => navLink.classList.toggle('hidden'));
            logoutBtn.classList.toggle('hidden');
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
            const navLinks = document.querySelectorAll('.nav-link i');
            const logoutBtn = document.querySelector('.logout-btn');
            if (sidebarHidden) {
                sidebar.classList.add('hidden');
                header.classList.add('full-width');
                mainContent.classList.add('full-width');
                footer.classList.add('full-width');
                navLinks.forEach(navLink => navLink.classList.add('hidden'));
                logoutBtn.classList.add('hidden');
            }
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
