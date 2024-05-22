<?php
session_start();
if (!isset($_SESSION['u_name']) || $_SESSION['identify'] !='教练') {
    // 如果不存在，重定向到登录页面
    header('Location: ../../login/login.html');
    exit; // 确保脚本终止执行，以防止后续代码被执行
}

include_once('../../static/conn.php');
$u_name = $_SESSION['u_name'];

function get_message($mysqli) {
    $message = array(); // Initialize an empty array to store data
    $id ='';
    $team1 = '';
    $team2 = '';
    $location = '';
    $start = '';
    $end = '';
    $state = '';

    $sql = "SELECT com_id,team1, team2, location, start, end, state FROM compete_message order by com_id";
    $stmt = $mysqli->prepare($sql);

    if ($stmt->execute()) {
        $stmt->bind_result($id,$team1, $team2, $location, $start, $end, $state);
        while ($stmt->fetch()) {
            // Append each row of data to the message array
            $message[] = array(
                'id' => $id,
                'team1' => $team1,
                'team2' => $team2,
                'location' => $location,
                'start' => $start,
                'end' => $end,
                'state' => $state
            );
        }
    }

    $stmt->free_result();
    $stmt->close();
    return $message;
}

// Get competition information
$message = get_message($mysqli);

// Return competition information as JSON
echo json_encode($message);

$mysqli->close();
?>
