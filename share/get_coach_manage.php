<?php
include_once("../static/conn.php");
session_start();

if (!isset($_SESSION['u_name']) or $_SESSION['identify']!='管理员') {
    // 如果不存在，重定向到登录页面
    header('Location: ../login/login.html');
    exit; // 确保脚本终止执行，以防止后续代码被执行
}

$u_name = $_SESSION['u_name'];

function get_message($mysqli)
{
    $message = array(); // Initialize an empty array to store data

    // Initialize variables
    $id = '';
    $username = '';
    $name = '';
    $tel = '';
    $email = '';
    $start = '';
    $end = '';

    $sql = "SELECT id, username, name, tel, email, start, end FROM coach_message order by id";
    $stmt = $mysqli->prepare($sql);

    if ($stmt->execute()) {
        $stmt->bind_result($id, $username, $name, $tel, $email, $start, $end);
        while ($stmt->fetch()) {
            // Append each row of data to the message array
            $message[] = array(
                'id' => $id,
                'username' => $username,
                'name' => $name,
                'tel' => $tel,
                'email' => $email,
                'start' => $start,
                'end' => $end
            );
        }
    }

    $stmt->free_result();
    $stmt->close();
    return $message;
}

// Get user information
$message = get_message($mysqli);

// Return user information as JSON
echo json_encode($message);

$mysqli->close();
?>