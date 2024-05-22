<?php
session_start();
if (!isset($_SESSION['u_name']) or $_SESSION['identify'] != '管理员') {
    // 如果不存在，重定向到登录页面
    header('Location: ../login/login.html');
    exit; // 确保脚本终止执行，以防止后续代码被执行
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>比赛信息</title>
    <link rel="stylesheet" href="../static/bootstrap-4.6.2-dist/css/bootstrap.min.css">
    <script src="../static/jquery-3.7.1/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="message.css">
</head>

<body>
    <div class="top-bar">
        <div class="logo">
            <img src="../pic/login_pic/logo.png" alt="Logo">
        </div>
        <div class="title">
            <ul class="nav nav-pills nav-fill">
                <li class="nav-item">
                    <a class="nav-link" href="../manager/manager.php">首页</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="message.php">个人信息</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="coach_manage.php">教练管理</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="player_manage.php">球员管理</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="match_compete.php">比赛信息</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="user_message.php">用户信息</a>
                </li>
            </ul>
        </div>
        <div class="user-info">
            <p style="color:aliceblue; margin-top: 25px;">欢迎, <?php echo htmlspecialchars($_SESSION['u_name']); ?>!</p>
            <a href="../home.html" class="btn btn-primary">退出</a>
        </div>
    </div>
    <div class="container mt-5">
        <nav class="navbar" style="background-color: #343a40; color: white;">
            <a class="navbar-brand">比赛信息</a>
            <form class="form-inline" onsubmit="return false;">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" id="searchInput">
                <button class="btn btn-outline-success my-2 my-sm-0" type="button" id="searchButton">Search</button>
            </form>
        </nav>
        <table id="infoTable" class="table table-striped">
            <thead>
                <tr>
                    <th scope="col"><button class="sort-btn" data-column="id">比赛编号</button></th>
                    <th scope="col"><button class="sort-btn" data-column="team1">队伍1</button></th>
                    <th scope="col"><button class="sort-btn" data-column="state">主场/客场</button></th>
                    <th scope="col"><button class="sort-btn" data-column="location">地点</button></th>
                    <th scope="col"><button class="sort-btn" data-column="start">开始时间</button></th>
                    <th scope="col"><button class="sort-btn" data-column="end">结束时间</button></th>
                    <th scope="col"><button class="sort-btn" data-column="team2">队伍2</button></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <div class="text-center">
            <a href="edit_match_compete.php" class="btn btn-primary">修改</a>
        </div>
    </div>
    <script src="../static/popper/popper.min.js"></script>
    <script src="../static/bootstrap-4.6.2-dist/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('get_match_message.php')
                .then(response => response.json())
                .then(data => {
                    const tbody = document.querySelector('#infoTable tbody');
                    data.forEach(row => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${row.id}</td>
                            <td>${row.team1}</td>
                            <td>${row.state}</td>
                            <td>${row.location}</td>
                            <td>${row.start}</td>
                            <td>${row.end}</td>
                            <td>${row.team2}</td>
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

            fetch('get_match_message.php')
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
                <td>${row.team1}</td>
                <td>${row.state}</td>
                <td>${row.location}</td>
                <td>${row.start}</td>
                <td>${row.end}</td>
                <td>${row.team2}</td>
            `;
                    tbody.appendChild(tr);
                });
            }
        });
    </script>
</body>

</html>