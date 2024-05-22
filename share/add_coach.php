<?php
session_start();
if (!isset($_SESSION['u_name']) or $_SESSION['identify'] != '管理员') {
    // 如果不存在，重定向到登录页面
    header('Location: ../login/login.html');
    exit; // 确保脚本终止执行，以防止后续代码被执行
}

include_once('../static/conn.php');
header('Content-Type: application/json;charset=utf-8');

// 接收并处理 POST 数据
$u_name = $_POST['u_name'];
$passwd = password_hash('password', PASSWORD_BCRYPT);
$name = $_POST['name'];
$email = $_POST['email'];
$tel = $_POST['tel'];
$start = $_POST['start'];
$end = $_POST['end'];
$identity = '教练';
$status = '通过';

// 开始事务
$mysqli->begin_transaction();

try {
    // 插入用户信息
    $stmt = $mysqli->prepare('INSERT INTO users (username, name, passwd, identify, status) VALUES (?, ?, ?, ?, ?)');
    $stmt->bind_param('sssss', $u_name, $name, $passwd, $identity, $status);
    $stmt->execute();
    $stmt->close();

    // 获取刚插入用户的 ID
    $stmt = $mysqli->prepare('SELECT id FROM users WHERE username = ?');
    $stmt->bind_param('s', $u_name);
    $stmt->execute();
    $stmt->bind_result($id);
    $stmt->fetch();
    $user_id = $id;
    $stmt->close();

    // 更新个人信息表
    $stmt = $mysqli->prepare('UPDATE person_message SET tel = ?, email = ? WHERE username = ?');
    $stmt->bind_param('sss', $tel, $email, $u_name);
    $stmt->execute();
    $stmt->close();

    // 更新合同表
    $stmt = $mysqli->prepare('UPDATE contract SET start = ?, end = ? WHERE id = ?');
    $stmt->bind_param('ssi', $start, $end, $user_id);
    $stmt->execute();
    $stmt->close();

    // 提交事务
    $mysqli->commit();

    // 返回成功消息
    echo json_encode(array("success" => true));
} catch (Exception $e) {
    // 如果发生异常，回滚事务
    $mysqli->rollback();
    // 返回错误消息
    echo json_encode(array("success" => false, "message" => "数据库操作失败：" . $e->getMessage()));
}

// 关闭数据库连接
$mysqli->close();
?>