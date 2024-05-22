<?php
session_start();
if (!isset($_SESSION['u_name']) or $_SESSION['identify'] != '教练') {
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
    <title>个人信息</title>
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
                    <a class="nav-link active" href="../message/message.php">个人信息</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../coach_message/coach_message.php">教练信息</a>
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
            <!-- 显示当前登录的用户名 -->
            <p style="color:aliceblue; margin-top: 25px;">欢迎, <?php echo htmlspecialchars($_SESSION['u_name']); ?>!</p>
            <a href="../../home.html" class="btn btn-primary" style="font-size: 16px;">退出</a>
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
                    <td id="ID_CELL"></td>
                </tr>
                <tr>
                    <td>姓名</td>
                    <td id="nameCell"></td>
                </tr>
                <tr>
                    <td>用户名</td>
                    <td id="usernameCell"><?php echo htmlspecialchars($_SESSION['u_name']); ?></td>
                </tr>
                <tr>
                    <td>身份</td>
                    <td id="identityCell"></td>
                </tr>
                <tr>
                    <td>性别</td>
                    <td id="sexCell"></td>
                </tr>
                <tr>
                    <td>电子邮件</td>
                    <td id="emailCell"></td>
                </tr>
                <tr>
                    <td>电话号码</td>
                    <td id="telCell"></td>
                </tr>
                <tr>
                    <td>签约日期</td>
                    <td id="startCell"></td>
                </tr>
                <tr>
                    <td>合同到期日期</td>
                    <td id="endCell"></td>
                </tr>
                <!-- 添加更多信息行 -->
            </tbody>
        </table>
        <div class="text-center">
            <a href="edit_message.php" class="btn btn-primary">修改</a>
        </div>
    </div>
    <script src="../../static/proper/popper.min.js"></script>
    <script src="../../static/bootstrap-4.6.2-dist/js/bootstrap.min.js"></script>
    <script>
        fetch('get_message.php', {
            method: 'GET',
            mode: 'cors',
            credentials: 'include'
        }).then(response => {
            return response.json()
        }).then(data => {
            // 将获取的用户信息填充到表格中
            document.getElementById('nameCell').textContent = data.name;
            document.getElementById('identityCell').textContent = data.identity;
            document.getElementById('sexCell').textContent = data.sex;
            document.getElementById('emailCell').textContent = data.email;
            document.getElementById('telCell').textContent = data.tel;
            document.getElementById('ID_CELL').textContent = data.id;
            document.getElementById('startCell').textContent = data.start;
            document.getElementById('endCell').textContent = data.end;
        }).catch(error => {
            console.error('Error:', error);
        });
    </script>
</body>

</html>
