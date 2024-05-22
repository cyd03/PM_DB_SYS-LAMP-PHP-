<?php
session_start();
if (!isset($_SESSION['u_name']) or $_SESSION['identify']!='管理员') {
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
    <title>个人信息</title>
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
                    <a class="nav-link active" href="message.php">个人信息</a>
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
                    <a class="nav-link" href="user_message.php">用户信息</a>
                </li>
            </ul>
        </div>
        <div class="user-info">
            <!-- 显示当前登录的用户名 -->
            <p style="color:aliceblue; margin-top: 25px;">欢迎, <?php echo htmlspecialchars($_SESSION['u_name']); ?>!</p>
            <a href="../home.html" class="btn btn-primary",style="font-size: 10px; padding: 1px 2px;">退出</a>
        </div>
    </div>

    <!-- 表格内容 -->
    <div class="container mt-5">
        <table id="infoTable" class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">项目</th>
                    <th scope="col">详细信息</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>工号</td>
                    <td><span id="ID_CELL" contenteditable="id"></span></td>
                </tr>
                <tr>
                    <td>姓名</td>
                    <td><span id="nameCell" contenteditable="true"></span></td>
                </tr>
                <tr>
                    <td>用户名</td>
                    <td><?php echo htmlspecialchars($_SESSION['u_name']); ?></td>
                </tr>
                <tr>
                    <td>身份</td>
                    <td><span id="identityCell" contenteditable="false"></span></td>
                </tr>
                <tr>
                    <td>性别</td>
                    <td>
                        <select id="sexSelect" class="form-select">
                            <option value="男">男</option>
                            <option value="女">女</option>
                            <option value="未知">未知</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>电子邮件</td>
                    <td><span id="emailCell" contenteditable="true"></span></td>
                </tr>
                <tr>
                    <td>电话号码</td>
                    <td><span id="telCell" contenteditable="true"></span></td>
                </tr>
                <!-- 添加更多信息行 -->
            </tbody>
        </table>
        <div class="text-center">
            <button id="saveButton" class="btn btn-primary">保存修改</button>
        </div>
    </div>
    <script src="../static/proper/popper.min.js"></script>
    <script src="../static/bootstrap-4.6.2-dist/js/bootstrap.min.js"></script>
    <script>
        // 页面加载完成后，获取服务器端数据填充到表格中
        window.addEventListener('load', function() {
            fetch('get_message.php', {
                method: 'GET',
                mode: 'cors',
                credentials: 'include'
            }).then(response => {
                return response.json()
            }).then(data => {
                document.getElementById('nameCell').textContent = data.name;
                document.getElementById('identityCell').textContent = data.identity;
                document.getElementById('emailCell').textContent = data.email;
                document.getElementById('telCell').textContent = data.tel;
                document.getElementById('ID_CELL').textContent = data.id;
            }).catch(error => {
                console.error('Error:', error);
            });
        });

        // 点击保存按钮时，将修改后的数据发送到服务器端保存
        document.getElementById('saveButton').addEventListener('click', function() {
            var name = document.getElementById('nameCell').textContent;
            var sex = document.getElementById('sexSelect').value;
            var email = document.getElementById('emailCell').textContent;
            var tel = document.getElementById('telCell').textContent;

            var data = {
                name: name,
                sex: sex,
                email: email,
                tel: tel
            };

            fetch('save_message.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                mode: 'cors',
                credentials: 'include',
                body: JSON.stringify(data)
            }).then(response => {
                if (response.ok) {
                    window.location.href = 'message.php'; // 成功后跳转到message.php
                } else {
                    console.error('Failed to save data');
                }
            }).catch(error => {
                console.error('Error:', error);
            });
        });
    </script>
</body>

</html>