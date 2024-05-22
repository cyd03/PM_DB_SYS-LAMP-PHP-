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
    <title>教练管理</title>
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
                    <a class="nav-link active" href="coach_manage.php">教练管理</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="player_manage.php">球员管理</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="match_compete.php">比赛信息</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="user_message.php">用户信息</a>
                </li>
            </ul>
        </div>
        <div class="user-info">
            <!-- Display the currently logged in username -->
            <p style="color:aliceblue; margin-top: 25px;">欢迎, <?php echo htmlspecialchars($_SESSION['u_name']); ?>!</p>
            <a href="../home.html" class="btn btn-primary">退出</a>
        </div>
    </div>
    <div class="container mt-5">
        <nav class="navbar" style=" background-color: #343a40; color: white;">
            <a class="navbar-brand">教练管理</a>
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
                    <th scope="col">操作</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <div class="text-center">
        <a id="addButton" class="btn btn-success my-2 my-sm-0 ml-2" href='add_coach_manage.php'>添加教练</a>
        <a id="retButton" class="btn btn-primary" href='coach_manage.php'>退出</a>
    </div>
    <script src="../static/proper/popper.min.js"></script>
    <script src="../static/bootstrap-4.6.2-dist/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let data = [];
            const tbody = document.querySelector('#infoTable tbody');
            const sortButtons = document.querySelectorAll('.sort-btn');

            function renderTable(data) {
                tbody.innerHTML = '';
                data.forEach(row => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${row.id}</td>
                        <td contenteditable="true">${row.name}</td>
                        <td>${row.username}</td>
                        <td contenteditable="true">${row.tel}</td>
                        <td contenteditable="true">${row.email}</td>
                        <td><input type="date" value="${row.start}"></td>
                        <td><input type="date" value="${row.end}"></td>
                        <td>
                            <button class="btn btn-primary btn-sm save-btn">保存</button>
                            <button class="btn btn-danger btn-sm delete-btn">删除</button>
                        </td>
                    `;
                    tbody.appendChild(tr);
                });

                tbody.querySelectorAll('.save-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const row = this.closest('tr');
                        const data = {
                            id: row.cells[0].innerText,
                            name: row.cells[1].innerText,
                            username: row.cells[2].innerText,
                            tel: row.cells[3].innerText,
                            email: row.cells[4].innerText,
                            start: row.cells[5].querySelector('input').value,
                            end: row.cells[6].querySelector('input').value
                        };
                        fetch('update_coach.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify(data)
                            })
                            .then(response => response.json())
                            .then(result => {
                                if (result.success) {
                                    alert('修改成功');
                                    window.location.reload(); // 刷新页面
                                } else {
                                    alert('修改失败: ' + result.message);
                                }
                            })
                            .catch(error => console.error('Error updating data:', error));
                    });
                });

                tbody.querySelectorAll('.delete-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const row = this.closest('tr');
                        const id = row.cells[0].innerText;
                        if (confirm('确定要删除吗?')) {
                            fetch('delete_coach.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        id
                                    })
                                })
                                .then(response => response.json())
                                .then(result => {
                                    if (result.success) {
                                        row.remove();
                                        alert('删除成功');
                                        window.location.reload(); // 刷新页面
                                    } else {
                                        alert('删除失败');
                                    }
                                })
                                .catch(error => console.error('Error deleting data:', error));
                        }
                    });
                });
            }

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
        });
    </script>
</body>

</html>