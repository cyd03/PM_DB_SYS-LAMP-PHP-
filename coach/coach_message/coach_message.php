<?php
session_start();
if (!isset($_SESSION['u_name']) or $_SESSION['identify'] !='教练') {
    // 如果不存在，重定向到登录页面
    header('Location: ../../login/login.html');
    exit; // 确保脚本终止执行，以防止后续代码被执行
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>教练信息</title>
    <link rel="stylesheet" href="../../static/bootstrap-4.6.2-dist/css/bootstrap.min.css">
    <script src="../../static/jquery-3.7.1/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="../message.css">
</head>

<body>
    <div class="top-bar">
        <div class="logo">
            <img src="../../pic/login_pic/logo.png" alt="Logo">
        </div>
        <div class="title">
            <ul class="nav nav-pills nav-fill">
                <li class="nav-item">
                    <a class="nav-link" href="../coach.php">首页</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../message/message.php">个人信息</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="../coach_message/coach_message.php">教练信息</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../player_message/player_message.php">球员信息</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../compete_message/compete_message.php">比赛信息</a>
                </li>
            </ul>
        </div>
        <div class="user-info">
            <!-- Display the currently logged in username -->
            <p style="color:aliceblue; margin-top: 25px;">欢迎, <?php echo htmlspecialchars($_SESSION['u_name']); ?>!</p>
            <a href="../../home.html" class="btn btn-primary">退出</a>
        </div>
    </div>
    <div class="container mt-5">
        <nav class="navbar" style=" background-color: #343a40; color: white;">
            <a class="navbar-brand">教练信息</a>
            <form class="form-inline" onsubmit="return false;">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" id="searchInput">
                <button class="btn btn-outline-success my-2 my-sm-0" type="button" id="searchButton">Search</button>
            </form>
        </nav>
        <table id="infoTable" class="table table-striped">
            <thead>
                <tr>
                    <th scope="col"><button class="sort-btn" data-column="id">工号</button></th>
                    <th scope="col"><button class="sort-btn" data-column="name">姓名</button></th>
                    <th scope="col"><button class="sort-btn" data-column="username">用户名</button></th>
                    <th scope="col"><button class="sort-btn" data-column="tel">电话号码</button></th>
                    <th scope="col"><button class="sort-btn" data-column="email">电子邮件</button></th>
                    <th scope="col"><button class="sort-btn" data-column="start">签约日期</button></th>
                    <th scope="col"><button class="sort-btn" data-column="end">合同到期日期</button></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <script src="../../static/proper/popper.min.js"></script>
    <script src="../../static/bootstrap-4.6.2-dist/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('get_coach_manage.php')
                .then(response => response.json())
                .then(data => {
                    const tbody = document.querySelector('#infoTable tbody');
                    data.forEach(row => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${row.id}</td>
                            <td>${row.name}</td>
                            <td>${row.username}</td>
                            <td>${row.tel}</td>
                            <td>${row.email}</td>
                            <td>${row.start}</td>
                            <td>${row.end}</td>
                        `;
                        tbody.appendChild(tr);
                    });
                })
                .catch(error => console.error('Error fetching data:', error));
        });

        document.getElementById('searchButton').addEventListener('click', function() {
            const searchValue = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('#infoTable tbody tr');

            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const rowText = Array.from(cells).map(cell => cell.textContent.toLowerCase()).join(' ');

                if (rowText.includes(searchValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            const tbody = document.querySelector('#infoTable tbody');
            const sortButtons = document.querySelectorAll('.sort-btn');

            let data = []; // Store the table data globally

            fetch('get_coach_manage.php')
                .then(response => response.json())
                .then(initialData => {
                    data = initialData;
                    renderTable(data);
                })
                .catch(error => console.error('Error fetching data:', error));

            sortButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const column = this.dataset.column;
                    const order = this.dataset.order === 'asc' ? 'desc' : 'asc';

                    // Reset order data for other buttons
                    sortButtons.forEach(btn => {
                        if (btn !== button) {
                            btn.dataset.order = '';
                        }
                    });

                    this.dataset.order = order;

                    data.sort((a, b) => {
                        const aValue = a[column];
                        const bValue = b[column];

                        if (order === 'asc') {
                            if (aValue < bValue) return -1;
                            if (aValue > bValue) return 1;
                            return 0;
                        } else {
                            if (aValue > bValue) return -1;
                            if (aValue < bValue) return 1;
                            return 0;
                        }
                    });

                    renderTable(data);
                });
            });

            function renderTable(data) {
                // Clear existing table rows
                tbody.innerHTML = '';

                // Render table rows with sorted data
                data.forEach(row => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                <td>${row.id}</td>
                <td>${row.name}</td>
                <td>${row.username}</td>
                <td>${row.tel}</td>
                <td>${row.email}</td>
                <td>${row.start}</td>
                <td>${row.end}</td>
            `;
                    tbody.appendChild(tr);
                });
            }
        });
    </script>
</body>

</html>