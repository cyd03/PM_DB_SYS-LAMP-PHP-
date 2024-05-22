<?php
session_start();
if (!isset($_SESSION['u_name']) or $_SESSION['identify'] != '管理员') {
    header('Location: ../login/login.html');
    exit;
}

include '../static/conn.php'; // 替换为实际的数据库连接文件

$response = array('success' => false, 'message' => '');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $team1 = $_POST['team1'];
    $state = $_POST['state'];
    $location = $_POST['location'];
    $start = $_POST['start'];
    $end = $_POST['end'];
    $team2 = $_POST['team2'];

    // 数据库插入逻辑
    $sql = "INSERT INTO compete_message(team1, state, location, start, end, team2) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('ssssss', $team1, $state, $location, $start, $end, $team2);

    if ($stmt->execute()) {
        $response['success'] = true;
    } else {
        $response['message'] = '数据库插入失败';
    }

    $stmt->close();
    $mysqli->close();
}

echo json_encode($response);
?>