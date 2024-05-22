<?php
include_once "../static/conn.php";
header('content-type:text/html;charset=utf-8');

$u_name = $_GET['u_name'];
$passwd = $_GET['passwd'];
$name = $_GET['name'];
$repasswd = $_GET['repasswd'];
$identity = $_GET['identity'];
echo $u_name,$passwd,$name,$passwd,$repasswd,$identity;

function user_find($u_name, $mysqli)
{
    $status = null;
    $sql = "SELECT status FROM users WHERE username=?";
    $mysqli_stmt = $mysqli->prepare($sql);
    $mysqli_stmt->bind_param('s', $u_name);
    if ($mysqli_stmt->execute()) {
        $mysqli_stmt->store_result(); // Store result to check the number of rows
        if ($mysqli_stmt->num_rows > 0) {
            $mysqli_stmt->free_result();
            $mysqli_stmt->close();
            return false;
        }
    }
    $mysqli_stmt->free_result();
    $mysqli_stmt->close();
    return TRUE;
}
function user_insert($mysqli, $u_name, $passwd, $identity, $name)
{
    // 准备 SQL 插入语句
    $sql = "INSERT INTO users (username, name, passwd, identify, status) VALUES (?, ?, ?, ?, '审核中')";
    
    // 准备预处理语句
    $mysqli_stmt = $mysqli->prepare($sql);
    
    // 绑定参数
    $mysqli_stmt->bind_param('ssss', $u_name, $name, $passwd, $identity);
    
    // 执行预处理语句
    if ($mysqli_stmt->execute()) {
        // 执行成功
        echo "插入成功";
        $mysqli_stmt->close(); // 关闭预处理语句
        return TRUE;
    } else {
        // 执行失败
        echo "插入失败: " . $mysqli->error;
        $mysqli_stmt->close(); // 关闭预处理语句
        return FALSE;
    }
}

if(empty($u_name) or empty($passwd) or empty($name) or empty($repasswd) or empty($identity))
{
    echo '</br>1';
    $tag = FALSE;
}
else if($passwd!=$repasswd)
{
    $tag=false;
}
else
{
    $tag = user_find($u_name, $mysqli);
}
if ($tag) {
    $hashedPassword=password_hash($passwd, PASSWORD_BCRYPT);
    $tag = user_insert($mysqli,$u_name,$hashedPassword,$identity,$name);
    echo $hashedPassword;
    header('location:../home.html');
}
if(!$tag){
    header('location:registerwrong.html');
}
$mysqli->close();
