<?php
session_start();
if (!isset($_SESSION['u_name']) or $_SESSION['identify'] != '管理员') {
    header('Location: ../login/login.html');
    exit;
}

include '../static/conn.php'; // 替换为实际的数据库连接文件

$response = array('success' => false, 'message' => '');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $team1 = $data['team1'];
    $state = $data['state'];
    $location = $data['location'];
    $start = $data['start'];
    $end = $data['end'];
    $team2 = $data['team2'];
    $id =   $data['id'];
    $sql = "UPDATE compete_message SET state = ?, location = ?, start = ?, end = ? ,team1 = ?,team2 = ? WHERE com_id=?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('ssssssi', $state, $location, $start, $end, $team1, $team2,$id);

    if ($stmt->execute()) {
        $response['success'] = true;
    } else {
        $response['message'] = '更新失败: ' . $stmt->error;
    }

    $stmt->close();
    $mysqli->close();
}

echo json_encode($response);
?>
