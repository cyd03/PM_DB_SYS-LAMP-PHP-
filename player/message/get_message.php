<?php
include_once("../../static/conn.php");
session_start();
if (!isset($_SESSION['u_name']) or $_SESSION['identify']!='球员') {
    // 如果不存在，重定向到登录页面
    header('Location: ../../login/login.html');
    exit; // 确保脚本终止执行，以防止后续代码被执行
}
$u_name = $_SESSION['u_name'];

function get_message($mysqli, $u_name)
{
    $message = array(); // 初始化一个空数组，用于存储数据
    $name = '';
    $sex = '';
    $identity = '球员';
    $tel = '';
    $email = '';
    $id = '';
    $start ='';
    $end='';
    $height='';
    $weight='';
    $message = array(); // 初始化一个空数组，用于存储数据
    $sql = "SELECT id,name,sex,tel,email,start,end,height,weight FROM player_message WHERE username=?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $u_name);
    if ($stmt->execute()) {
        $stmt->bind_result($id,$name, $sex,$tel, $email,$start,$end,$height,$weight);
        // 将查询结果存储到关联数组中
        if ($stmt->fetch()) {
            $message['id'] = $id;
            $message['name'] = $name;
            $message['sex'] = $sex;
            $message['identity'] = $identity;
            $message['tel'] = $tel;
            $message['email'] = $email;
            $message['start'] = $start;
            $message['end'] = $end;
            $message['height'] = $height;
            $message['weight'] = $weight;
        }
    }
    $stmt->free_result();
    $stmt->close();
    return $message;
}

// 获取用户信息
$message = get_message($mysqli, $u_name);

// 将用户信息以 JSON 格式返回给前端
echo json_encode($message);
$mysqli->close();
?>