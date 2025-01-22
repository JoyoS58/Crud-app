@extends('layouts.app')

@section('content')
    <div class="card p-4 shadow-lg border-1">
        <div class="container py-4">
            <!-- Page Title -->
            <div class="text-center mb-4">
                <h1 class="display-4 font-weight-bold text-primary">
                    <i class="fas fa-users"></i> User Management
                </h1>
                <p class="text-muted">Manage all registered users efficiently and effectively.</p>
                <hr class="my-4" style="border-top: 2px solid #007bff; width: 50%;">
            </div>

            <!-- Add User Button, Total Users, and Search -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="{{ route('users.create') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-user-plus"></i> Add User
                </a>
                <div class="d-flex align-items-center">
                    <form method="GET" action="{{ route('users.index') }}" class="d-flex" id="searchForm">
                        <div class="input-group">
                            <input type="text" id="searchInput" name="search" class="form-control"
                                placeholder="Search users..." value="{{ request('search') }}" onkeyup="searchUsers()">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                        </div>
                    </form>
                    <span class="badge badge-info p-3 ml-3" style="font-size: 1rem;">
                        <i class="fas fa-users"></i> Total Users: {{ $users->total() }}
                    </span>
                </div>

            </div>

            <!-- User Table -->
            @if ($users->isEmpty())
                <div class="alert alert-warning text-center">
                    <i class="fas fa-exclamation-circle"></i> No users found. Start adding new users to populate this list.
                </div>
            @else
                <div class="table-responsive shadow-sm rounded">
                    <table class="table table-hover table-striped table-bordered" id="usersTable">
                        <thead class="thead-dark text-center">
                            <tr>
                                <th>#</th>
                                <th onclick="sortTable(1)">Name</th>
                                <th onclick="sortTable(2)">Email</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $index => $user)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><strong>{{ $user->name }}</strong></td>
                                    <td>{{ $user->email }}</td>
                                    <td class="text-center">
                                        <!-- Action Buttons -->
                                        <div class="btn-group" role="group" aria-label="User Actions">
                                            <a href="{{ route('users.show', $user->user_id) }}" class="btn btn-info btn-sm"
                                                style="border-radius: 25px;">
                                                <i class="fas fa-eye"></i> Show
                                            </a>
                                            <a href="{{ route('users.edit', $user->user_id) }}"
                                                class="btn btn-warning btn-sm" style="border-radius: 25px;">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm"
                                                style="border-radius: 25px;" onclick="confirmDelete({{ $user->user_id }})">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                            <form id="delete-form-{{ $user->user_id }}"
                                                action="{{ route('users.destroy', $user->user_id) }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Pagination Links -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <form method="GET" action="{{ route('users.index') }}" id="paginationForm">
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        <label for="pageSize">Show</label>
                        <select id="pageSize" name="pageSize" onchange="this.form.submit()">
                            <option value="5" {{ request('pageSize') == 5 ? 'selected' : '' }}>5</option>
                            <option value="10" {{ request('pageSize') == 10 ? 'selected' : '' }}>10</option>
                            <option value="20" {{ request('pageSize') == 20 ? 'selected' : '' }}>20</option>
                            <option value="50" {{ request('pageSize') == 50 ? 'selected' : '' }}>50</option>
                        </select>
                        <label for="pageSize">entries</label>
                    </form>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item {{ $users->currentPage() == 1 ? ' disabled' : '' }}">
                                <a class="page-link"
                                    href="{{ $users->appends(['pageSize' => request('pageSize')])->previousPageUrl() }}">Previous</a>
                            </li>
                            @for ($i = 1; $i <= $users->lastPage(); $i++)
                                <li class="page-item {{ $users->currentPage() == $i ? ' active' : '' }}">
                                    <a class="page-link"
                                        href="{{ $users->appends(['pageSize' => request('pageSize')])->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor
                            <li class="page-item {{ $users->currentPage() == $users->lastPage() ? ' disabled' : '' }}">
                                <a class="page-link"
                                    href="{{ $users->appends(['pageSize' => request('pageSize')])->nextPageUrl() }}">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            @endif
        </div>
    </div>

    <link rel="stylesheet" href="{{ asset('css/user-styles.css') }}">

    <!-- Include SweetAlert Library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Custom Scripts -->
    <script>
        function searchUsers() {
            var input = document.getElementById("searchInput").value;
            var form = document.getElementById("searchForm");
            var url = form.action + '?search=' + input;

            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(data => {
                var parser = new DOMParser();
                var doc = parser.parseFromString(data, 'text/html');
                var table = doc.getElementById('usersTable').innerHTML;
                document.getElementById('usersTable').innerHTML = table;
            })
            .catch(error => console.error('Error:', error));
        }

        function confirmDelete(userId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + userId).submit();
                }
            })
        }

        function sortTable(n) {
            var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.getElementById("usersTable");
            switching = true;
            dir = "asc";
            while (switching) {
                switching = false;
                rows = table.rows;
                for (i = 1; i < (rows.length - 1); i++) {
                    shouldSwitch = false;
                    x = rows[i].getElementsByTagName("TD")[n];
                    y = rows[i + 1].getElementsByTagName("TD")[n];
                    if (dir == "asc") {
                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    } else if (dir == "desc") {
                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    }
                }
                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    switchcount++;
                } else {
                    if (switchcount == 0 && dir == "asc") {
                        dir = "desc";
                        switching = true;
                    }
                }
            }
            updateRowNumbers();
            updateSortIcons(n, dir);
        }

        function updateRowNumbers() {
            var table, rows, i;
            table = document.getElementById("usersTable");
            rows = table.rows;
            for (i = 1; i < rows.length; i++) {
                rows[i].getElementsByTagName("TD")[0].innerHTML = i;
            }
        }

        function updateSortIcons(columnIndex, direction) {
            var headers = document.querySelectorAll("#usersTable th");
            headers.forEach(function(header, index) {
                header.innerHTML = header.innerHTML.replace(/ <i class="fas fa-sort-(up|down)"><\/i>/, '');
                if (index === columnIndex) {
                    if (direction === "asc") {
                        header.innerHTML += ' <i class="fas fa-sort-up"></i>';
                    } else {
                        header.innerHTML += ' <i class="fas fa-sort-down"></i>';
                    }
                } else {
                    header.innerHTML == ' <i class="fas fa-sort" style="opacity: 0.3;"></i>';
                }
            });
            const sort = document.querySelectorAll('.fas fa-sort');
        }
    </script>
@endsection
