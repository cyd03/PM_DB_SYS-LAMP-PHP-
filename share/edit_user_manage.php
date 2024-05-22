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
    <title>用户管理</title>
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
                    <a class="nav-link" href="match_compete.php">比赛信息</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="user_message.php">用户信息</a>
                </li>
            </ul>
        </div>
        <div class="user-info">
            <!-- 显示当前登录的用户名 -->
            <p style="color: aliceblue; margin-top: 25px;">欢迎, <?php echo htmlspecialchars($_SESSION['u_name']); ?>!</p>
            <a href="../home.html" class="btn btn-primary">退出</a>
        </div>
    </div>
    <div class="container mt-5">
        <nav class="navbar" style="background-color: #343a40; color: white;">
            <a class="navbar-brand">用户管理</a>
            <form class="form-inline" onsubmit="return false;">
                <input class="form-control mr-sm-2" type="search" placeholder="搜索" aria-label="搜索" id="searchInput">
                <button class="btn btn-outline-success my-2 my-sm-0" type="button" id="searchButton">搜索</button>
            </form>
        </nav>
        <table id="infoTable" class="table table-striped">
            <thead>
                <tr>
                    <th scope="col"><button class="sort-btn" data-column="0">工号</button></th>
                    <th scope="col"><button class="sort-btn" data-column="1">姓名</button></th>
                    <th scope="col"><button class="sort-btn" data-column="2">用户名</button></th>
                    <th scope="col"><button class="sort-btn" data-column="3">身份</button></th>
                    <th scope="col"><button class="sort-btn" data-column="4">状态</button></th>
                    <th scope="col">操作</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <div class="text-center">
        <a id="retButton" class="btn btn-primary" href='user_message.php'>退出</a>
    </div>
    <script src="../static/popper/popper.min.js"></script>
    <script src="../static/bootstrap-4.6.2-dist/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('get_user_message.php')
                .then(response => response.json())
                .then(data => {
                    const tbody = document.querySelector('#infoTable tbody');
                    data.forEach(row => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${row.id}</td>
                            <td contenteditable="true">${row.name}</td>
                            <td>${row.username}</td>
                            <td>
                                <select class="form-control identity-select">
                                    <option value="管理员" ${row.identity==='管理员' ? 'selected' : '' }>管理员</option>
                                    <option value="教练" ${row.identity==='教练' ? 'selected' : '' }>教练</option>
                                    <option value="球员" ${row.identity==='球员' ? 'selected' : '' }>球员</option>
                                </select>
                            </td>
                            <td>
                                <select class="form-control status-select">
                                    <option value="通过" ${row.status==='通过' ? 'selected' : '' }>通过</option>
                                    <option value="未通过" ${row.status==='未通过' ? 'selected' : '' }>未通过</option>
                                    <option value="审核中" ${row.status==='审核中' ? 'selected' : '' }>审核中</option>
                                </select>
                            </td>
                            <td>
                                <button class="btn btn-primary btn-sm save-btn">保存</button>
                                <button class="btn btn-danger btn-sm delete-btn">删除</button>
                            </td>
                        `;
                        tbody.appendChild(tr);
                    });

                    // 添加保存和删除按钮的事件监听器
                    tbody.querySelectorAll('.save-btn').forEach(btn => {
                        btn.addEventListener('click', function() {
                            const row = this.closest('tr');
                            const data = {
                                id: row.cells[0].innerText,
                                name: row.cells[1].innerText,
                                username: row.cells[2].innerText,
                                identity: row.cells[3].querySelector('select').value,
                                status: row.cells[4].querySelector('select').value
                            };
                            fetch('update_user.php', {
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
                                        alert('修改失败' + result.message);
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
                                fetch('delete_user.php', {
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

        // 排序功能
        document.querySelectorAll('.sort-btn').forEach(button => {
            button.addEventListener('click', function() {
                const column = this.getAttribute('data-column');
                const tbody = document.querySelector('#infoTable tbody');
                const rows = Array.from(tbody.querySelectorAll('tr'));

                // 切换排序方向
                let sortOrder = 1;
                if (this.classList.contains('asc')) {
                    this.classList.remove('asc');
                    this.classList.add('desc');
                    sortOrder = -1;
                } else {
                    this.classList.remove('desc');
                    this.classList.add('asc');
                }

                // 排序行
                rows.sort((a, b) => {
                    const aValue = a.querySelector(`td:nth-child(${column})`).innerText.trim();
                    const bValue = b.querySelector(`td:nth-child(${column})`).innerText.trim();

                    if (aValue < bValue) return -1 * sortOrder;
                    if (aValue > bValue) return 1 * sortOrder;
                    return 0;
                });

                // 重新附加排序后的行到tbody
                tbody.innerHTML = '';
                rows.forEach(row => tbody.appendChild(row));
            });
        });
    </script>
</body>

</html>