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
    $username = $data['username'];
    $name = $data['name'];
    $id = $data['id'];
    $identity = $data['identity'];
    $status = $data['status'];
    $sql = "UPDATE users SET username=?, name=?, identify=?, status=? WHERE id=?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('ssssi', $username, $name, $identity, $status, $id);

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
