<?php
session_start();
if (!isset($_SESSION['u_name']) or $_SESSION['identify'] != '管理员') {
    header('Location: ../login/login.html');
    exit;
}

include_once '../static/conn.php'; // 替换为实际的数据库连接文件
header('Content-Type: application/json;charset=utf-8');
$response = array('success' => false, 'message' => '');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'];
    $sql = "DELETE FROM compete_message WHERE com_id=?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i',$id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $response['success'] = true;
        } else {
            $response['message'] = '删除操作成功，但没有记录被删除。';
        }
    } else {
        $response['message'] = '删除失败: ' . $stmt->error;
    }

    $stmt->close();
    $mysqli->close();
}

echo json_encode($response);