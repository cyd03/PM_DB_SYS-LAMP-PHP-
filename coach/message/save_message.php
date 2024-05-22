<?php
session_start();
if (!isset($_SESSION['u_name']) or $_SESSION['identify']!='教练') {
    // 如果不存在，重定向到登录页面
    header('Location: ../../login/login.html');
    exit; // 确保脚本终止执行，以防止后续代码被执行
}
include_once('../../static/conn.php');
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);
$name = $data['name'];
$sex = $data['sex'];
$email = $data['email'];
$tel = $data['tel'];
$name = trim($name);
$sex = trim($sex);
$email = trim($email);
$tel = trim($tel);
$u_name = $_SESSION['u_name'];

function update_message($mysqli, $name, $sex, $email, $tel, $u_name)
{
    // 开启事务
    $mysqli->begin_transaction();

    try {
        // 更新 users 表
        $stmt1 = $mysqli->prepare('UPDATE users SET name = ? WHERE username = ?');
        if (!$stmt1) {
            throw new Exception($mysqli->error);
        }
        $stmt1->bind_param('ss', $name, $u_name);
        if (!$stmt1->execute()) {
            throw new Exception($stmt1->error);
        }

        // 更新 person_message 表
        $stmt2 = $mysqli->prepare('UPDATE person_message SET sex = ?, email = ?, tel = ? WHERE username = ?');
        if (!$stmt2) {
            throw new Exception($mysqli->error);
        }
        $stmt2->bind_param('ssss', $sex, $email, $tel, $u_name);
        if (!$stmt2->execute()) {
            throw new Exception($stmt2->error);
        }

        // 提交事务
        $mysqli->commit();
    } catch (Exception $e) {
        // 如果有错误发生，回滚事务
        $mysqli->rollback();
        throw $e;
    } finally {
        // 关闭语句
        if (isset($stmt1)) $stmt1->close();
        if (isset($stmt2)) $stmt2->close();
    }
}
try {
    update_message($mysqli, $name, $sex, $email, $tel, $u_name);
    // 更新成功，重定向回个人信息页面
    $mysqli->close();
    exit;
} catch (Exception $e) {
    // 处理错误
    header('Location: ./edit_message.php');
    echo "更新失败: " . $e->getMessage();
} finally {
    $mysqli->close();
}
?>