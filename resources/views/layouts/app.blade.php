<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 16.666%;
            background-color: #343a40;
            color: #fff;
            padding: 50px 30px;
            overflow-y: auto;
            transition: all 0.3s ease;
            border-radius: 0 50px 50px 0;
        }
        /* .header {
            position: sticky;
            top: 0;
            left: 0;
            right: 0;
            height: 5%;
            width: 100%;
            background-color: #343a40;
            color: #fff;
            padding: 10px 6px;
            overflow-y: auto;
            transition: all 0.3s ease;
            border-radius: 70px 0px 70px 0;
        } */


        .sidebar h4 a {
            text-decoration: none;
            color: inherit;
            font-size: 1.5rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        /* Sidebar Links */
        .nav-link {
            display: flex;
            align-items: center;
            margin: 5px 0;
            font-size: 1.1rem;
        }

        .nav-link i {
            margin-right: 12px;
            font-size: 1.2rem;
        }

        /* Active and Hover State */
        .nav-link:hover {
            background-color: #575757;
            color: #fff;
        }

        .nav-link.active {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
        }

        /* Main Content */
        .main-content {
            margin-left: 16.666%;
            padding: 20px;
        }
    </style>
</head>

<body>
    <div class="container-fluid vh-100">
        <div class="header">Header</div>
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="d-flex align-items-center mb-4">
                <h4><i class="fas fa-house-user mr-2" style="color: #0065d1;"></i>
                    <a href="/">Dashboard</a>
                </h4>
            </div>
            <ul class="nav nav-pills flex-column mt-3">
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('users*') ? 'active' : '' }}"
                        href="{{ route('users.index') }}">
                        <i class="fas fa-users"></i>User Management
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('roles*') ? 'active' : '' }}"
                        href="{{ route('roles.index') }}">
                        <i class="fas fa-user-shield"></i>Role Management
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('groups*') ? 'active' : '' }}"
                        href="{{ route('groups.index') }}">
                        <i class="fas fa-layer-group"></i>Group Management
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('members*') ? 'active' : '' }}"
                        href="{{ route('members.index') }}">
                        <i class="fas fa-id-badge"></i>Member Management
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('activities*') ? 'active' : '' }}"
                        href="{{ route('activities.index') }}">
                        <i class="fas fa-tasks"></i>Activity Management
                    </a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Content -->
            @yield('content')
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
