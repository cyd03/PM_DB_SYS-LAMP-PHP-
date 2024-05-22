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
    <title>球员管理</title>
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
                    <a class="nav-link active" href="player_manage.php">球员管理</a>
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
            <a class="navbar-brand">球员管理</a>
            <form class="form-inline" onsubmit="return false;">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" id="searchInput">
                <button class="btn btn-outline-success my-2 my-sm-0" type="button" id="searchButton">Search</button>
            </form>
        </nav>
        <table id="infoTable" class="table table-striped">
            <thead>
                <tr>
                    <th scope="col"><button class="sort-btn" data-column="1">工号</button></th>
                    <th scope="col"><button class="sort-btn" data-column="2">姓名</button></th>
                    <th scope="col"><button class="sort-btn" data-column="3">用户名</button></th>
                    <th scope="col"><button class="sort-btn" data-column="4">身高(m)</button></th>
                    <th scope="col"><button class="sort-btn" data-column="5">体重(Kg)</button></th>
                    <th scope="col"><button class="sort-btn" data-column="6">电话号码</button></th>
                    <th scope="col"><button class="sort-btn" data-column="7">电子邮件</button></th>
                    <th scope="col"><button class="sort-btn" data-column="8">签约日期</button></th>
                    <th scope="col"><button class="sort-btn" data-column="9">合同到期日期</button></th>
                    <th scope="col">操作</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <div class="text-center">
        <a id="addButton" class="btn btn-success my-2 my-sm-0 ml-2" href='add_player_manage.php'>添加球员</a>
        <a id="retButton" class="btn btn-primary" href='player_manage.php'style="font-size: 16px;">退出</button>
    </div>
    <script src="../static/proper/popper.min.js"></script>
    <script src="../static/bootstrap-4.6.2-dist/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('get_player_message.php')
                .then(response => response.json())
                .then(data => {
                    const tbody = document.querySelector('#infoTable tbody');
                    data.forEach(row => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${row.id}</td>
                            <td contenteditable="true">${row.name}</td>
                            <td>${row.username}</td>
                            <td contenteditable="true">${row.height}</td>
                            <td contenteditable="true">${row.weight}</td>
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

                    // Add event listeners for save and delete buttons
                    tbody.querySelectorAll('.save-btn').forEach(btn => {
                        btn.addEventListener('click', function() {
                            const row = this.closest('tr');
                            const data = {
                                id: row.cells[0].innerText,
                                name: row.cells[1].innerText,
                                username: row.cells[2].innerText,
                                height: row.cells[3].innerText,
                                weight: row.cells[4].innerText,
                                tel: row.cells[5].innerText,
                                email: row.cells[6].innerText,
                                start: row.cells[7].querySelector('input').value,
                                end: row.cells[8].querySelector('input').value
                            };
                            fetch('update_player.php', {
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
                                fetch('delete_player.php', {
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

        // Sorting functionality
        document.querySelectorAll('.sort-btn').forEach(button => {
            button.addEventListener('click', function() {
                const column = this.getAttribute('data-column');
                const tbody = document.querySelector('#infoTable tbody');
                const rows = Array.from(tbody.querySelectorAll('tr'));

                // Toggle sorting direction
                let sortOrder = 1;
                if (this.classList.contains('asc')) {
                    this.classList.remove('asc');
                    this.classList.add('desc');
                    sortOrder = -1;
                } else {
                    this.classList.remove('desc');
                    this.classList.add('asc');
                }

                // Sort the rows
                rows.sort((a, b) => {
                    const aValue = a.querySelector(`td:nth-child(${column})`).innerText.trim();
                    const bValue = b.querySelector(`td:nth-child(${column})`).innerText.trim();

                    if (aValue < bValue) return -1 * sortOrder;
                    if (aValue > bValue) return 1 * sortOrder;
                    return 0;
                });

                // Re-append sorted rows to tbody
                tbody.innerHTML = '';
                rows.forEach(row => tbody.appendChild(row));
            });
        });
    </script>
</body>

</html>