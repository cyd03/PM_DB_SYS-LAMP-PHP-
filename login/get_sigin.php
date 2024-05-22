<?php
session_start();

include_once "../static/conn.php";
header('content-type:text/html;charset=utf-8');
$u_name = $_POST['u_name'];
$passwd = $_POST['passwd'];
$identity = $_POST['identity'];
function user_find($u_name, $mysqli, $passwd, $identity)
{
    $status = null;
    $password = '';
    $sql = "SELECT status, passwd FROM users WHERE username=? AND identify=?";
    $mysqli_stmt = $mysqli->prepare($sql);
    
    if (!$mysqli_stmt) {
        echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
        return FALSE;
    }

    $mysqli_stmt->bind_param('ss', $u_name, $identity);

    if ($mysqli_stmt->execute()) {
        $mysqli_stmt->store_result();
        if ($mysqli_stmt->num_rows > 0) {
            $mysqli_stmt->bind_result($status, $password);
            $mysqli_stmt->fetch();

            // Debugging output
            echo "Fetched password: " . $password . "<br>";
            echo "Fetched status: " . $status . "<br>";

            if (!password_verify($passwd, $password)) {
                echo 'Password did not match';
                $mysqli_stmt->free_result();
                $mysqli_stmt->close();
                return FALSE;
            }

            if ($status === '通过') {
                $mysqli_stmt->free_result();
                $mysqli_stmt->close();
                return TRUE;
            }
        } else {
            echo "No matching user found";
        }
    } else {
        echo "Execute failed: (" . $mysqli_stmt->errno . ") " . $mysqli_stmt->error;
    }

    $mysqli_stmt->free_result();
    $mysqli_stmt->close();
    return FALSE;
}
$tag = user_find($u_name, $mysqli, $passwd, $identity);

if ($tag) {
    $_SESSION['u_name']=$u_name;
    $_SESSION['identify']=$identity;
    switch ($identity) {
        case '管理员':
            header('Location: ../manager/manager.php');
            break;
        case '教练':
            header('Location: ../coach/coach.php');
            break;
        case '球员':
            header('Location: ../player/player.php');
            break;
        default:
            header('Location: ../home.html');
    }
} else {
    header('location:loginwrong.html');
}
$mysqli->close();
