<?php
session_start();
if (!isset($_SESSION['u_name']) or $_SESSION['identify']!='球员') {
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
    <title>球员页面</title>
    <link rel="stylesheet" href="../static/bootstrap-4.6.2-dist/css/bootstrap.min.css">
    <script src="../static/jquery-3.7.1/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="player.css">
</head>

<body>
    <div class="top-bar">
        <div class="logo">
            <img src="../pic/login_pic/logo.png" alt="Logo">
        </div>
        <div class="title">
            <ul class="nav nav-pills nav-fill">
                <li class="nav-item">
                    <a class="nav-link active" href="player.php">首页</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="message/message.php">个人信息</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="coach_message/coach_message.php">教练信息</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="player_message/player_message.php">球员信息</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="compete_message/compete_message.php">比赛信息</a>
                </li>
            </ul>
        </div>
        <div class="user-info">
            <!-- 显示当前登录的用户名 -->
            <p style="color:aliceblue;    margin-top: 25px;">欢迎, <?php echo htmlspecialchars($_SESSION['u_name']); ?>!</p>
            <a href="../home.html" class="btn btn-primary" ,style="font-size: 10px; padding: 1px 2px;">退出</a>
        </div>
    </div>
    <div class="container">
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="carousel-img" src="../pic/HOME/bg.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img class="carousel-img" src="../pic/HOME/1.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img class="carousel-img" src="../pic/HOME/2.jpg" class="d-block w-100" alt="...">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-target="#carouselExampleControls" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-target="#carouselExampleControls" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </button>
        </div>
        <div class="container">
            <div class="row">
                <div class="row no-gutters">
                    <div class="col">
                        <div class="card" style="width: 34.6rem;height: 500px;">
                            <img src="../pic/HOME/(1).jpg" class="card-img-top" alt="..." style="height: 320px;">
                            <div class="card-body">
                                <p class="card-text">欧文（Irving），全名凯里·安德鲁·欧文（Kyrie Andrew
                                    Irving），是一位出生于1992年3月23日的美国职业篮球运动员，司职控球后卫。欧文以其卓越的控球技术、得分能力和关键时刻的表现而闻名，目前效力于NBA的达拉斯独行侠队。他的职业生涯充满了亮点和争议。
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card" style="width: 34.6rem;height: 500px;">
                            <img src="../pic/HOME/(2).jpg" class="card-img-top" alt="..." style="height: 320px;">
                            <div class="card-body">
                                <p class="card-text">科比·布莱恩特（Kobe Bryant），全名科比·比恩·布莱恩特（Kobe Bean
                                    Bryant），1978年8月23日出生于美国宾夕法尼亚州费城，是一位已故的美国职业篮球运动员，被广泛认为是NBA历史上最伟大的球员之一。他的整个职业生涯都效力于洛杉矶湖人队（1996-2016）。
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-100"></div>
                <div class="row no-gutters">
                    <div class="col">
                        <div class="card" style="width: 34.6rem;height: 500px;">
                            <img src="../pic/HOME/(3).jpg" class="card-img-top" alt="..." style="height: 360px;">
                            <div class="card-body">
                                <p class="card-text">詹姆斯·哈登（James
                                    Harden），是一位美国职业篮球运动员，生于1989年8月26日。他司职得分后卫/组织后卫。哈登以其出色的得分能力、创造力和控球技巧而闻名于世，并被认为是NBA最顶尖的球员之一。
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card" style="width: 34.6rem;height: 500px;">
                            <img src="../pic/HOME/(4).jpg" class="card-img-top" alt="..." style="height: 360px;">
                            <div class="card-body">
                                <p class="card-text">史蒂芬·库里（Stephen
                                    Curry），生于1988年3月14日，是一位美国职业篮球运动员，司职控球后卫。他被公认为NBA历史上最伟大的射手之一，并对现代篮球产生了深远影响。</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../static/proper/popper.min.js"></script>
    <script src="../static/bootstrap-4.6.2-dist/js/bootstrap.min.js"></script>
</body>

</html>