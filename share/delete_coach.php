<?php
session_start();
if (!isset($_SESSION['u_name']) || $_SESSION['identify'] != '管理员') {
    header('Location: ../login/login.html');
    exit;
}
include_once('../static/conn.php');
header('Content-Type: application/json;charset=utf-8');
$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'];
$sql = "DELETE FROM users WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('i', $id);
if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => '删除失败']);
}
$stmt->close();
$mysqli->close();
?>