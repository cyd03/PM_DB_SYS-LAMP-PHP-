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
    <title>添加比赛</title>
    <link rel="stylesheet" href="../static/bootstrap-4.6.2-dist/css/bootstrap.min.css">
    <script src="../static/jquery-3.7.1/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="message.css">
</head>

<body>
    <div class="container mt-5">
        <div class="loginCard">
            <div style="text-align: right;">
                <a href="match_compete.php" style="font-size: 36px; text-decoration: none;color:#17150e">&times;</a>
            </div>
            <form id="add-match-form" action="add_match.php" method="post">
                <label for="team1">队伍1:</label>
                <input type="text" name="team1" id="team1" placeholder="请输入队伍1" required>
                <br>
                <label for="state">主场/客场:</label>
                <input type="text" name="state" id="state" placeholder="请输入主场或客场" required>
                <br>
                <label for="location">地点:</label>
                <input type="text" name="location" id="location" placeholder="请输入地点" required>
                <br>
                <label for="start">开始时间:</label>
                <input type="datetime-local" name="start" id="start" required>
                <br>
                <label for="end">结束时间:</label>
                <input type="datetime-local" name="end" id="end" required>
                <br>
                <label for="team2">队伍2:</label>
                <input type="text" name="team2" id="team2" placeholder="请输入队伍2" required>
                <br>
                <br>
                <button type="submit" class="btn btn-primary">添加比赛</button>
            </form>
            <div id="response-message"></div>
        </div>
    </div>
    <script src="../static/proper/popper.min.js"></script>
    <script src="../static/bootstrap-4.6.2-dist/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#add-match-form').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: 'add_match.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            $('#response-message').html('<div class="alert alert-success">比赛添加成功！</div>');
                            setTimeout(function() {
                                window.location.href = 'match_compete.php';
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