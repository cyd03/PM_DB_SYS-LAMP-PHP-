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
            <!-- 显示当前登录的用户名 -->
            <p style="color:aliceblue; margin-top: 25px;">欢迎, <?php echo htmlspecialchars($_SESSION['u_name']); ?>!</p>
            <a href="../home.html" class="btn btn-primary">退出</a>
        </div>
    </div>
    <div class="loginCard">
        <div style="text-align: right;">
            <a href="edit_player_manage.php" style="font-size: 36px; text-decoration: none;color:#17150e">&times;</a>
        </div>
        <form id="add-player-form" action="add_player.php" method="post">
            <label for="u_name">用户名:</label>
            <input type="text" name="u_name" id="u_name" placeholder="请输入用户名" required>
            <br>
            <label for="name">姓名:</label>
            <input type="text" name="name" id="name" placeholder="请输入姓名" required>
            <br>
            <label for="height">身高(cm):</label>
            <input type="number" name="height" id="height" placeholder="请输入身高" required>
            <br>
            <label for="weight">体重(kg):</label>
            <input type="number" name="weight" id="weight" placeholder="请输入体重" required>
            <br>
            <label for="tel">电话号码:</label>
            <input type="text" name="tel" id="tel" placeholder="请输入电话号码" required>
            <br>
            <label for="email">电子邮件:</label>
            <input type="email" name="email" id="email" placeholder="请输入电子邮件" required>
            <br>
            <label for="start">签约日期:</label>
            <input type="date" name="start" id="start" placeholder="请输入签约日期" required>
            <br>
            <label for="end">合同到期日期:</label>
            <input type="date" name="end" id="end" placeholder="请输入合同到期日期" required>
            <br>
            <br>
            <button type="submit">添加</button>
        </form>
        <div id="response-message"></div>
    </div>
    <script src="../static/proper/popper.min.js"></script>
    <script src="../static/bootstrap-4.6.2-dist/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#add-player-form').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: 'add_player.php', // 修正 URL
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            $('#response-message').html('<div class="alert alert-success">球员添加成功！</div>');
                            setTimeout(function() {
                                window.location.href = 'edit_player_manage.php';
                            }, 2000); // 2秒后重定向
                        } else {
                            $('#response-message').html('<div class="alert alert-danger">添加失败：' + response.message + '</div>');
                        }
                    },
                    error: function() {
                        $('#response-message').html('<div class="alert alert-danger">请求失败，请重试。</div>');
                    }
                });
            });
        });
    </script>
</body>

</html>
