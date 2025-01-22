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