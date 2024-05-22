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
$name = $data['name'];
$tel = $data['tel'];
$email = $data['email'];
$start = $data['start'];
$end = $data['end'];
$height = $data['height'];
$weight = $data['weight'];
$username = $data['username'];

function save_data($mysqli, $id, $name, $tel, $email, $start, $end, $height, $weight, $username) {
    $mysqli->begin_transaction();

    try {
        // Update users table
        $stmt1 = $mysqli->prepare("UPDATE users SET name=? WHERE id=?");
        if (!$stmt1) {
            throw new Exception($mysqli->error);
        }
        $stmt1->bind_param("si", $name, $id);
        if (!$stmt1->execute()) {
            throw new Exception($stmt1->error);
        }

        // Update person_message table
        $stmt2 = $mysqli->prepare("UPDATE person_message SET tel=?, email=? WHERE username=?");
        if (!$stmt2) {
            throw new Exception($mysqli->error);
        }
        $stmt2->bind_param("sss", $tel, $email, $username);
        if (!$stmt2->execute()) {
            throw new Exception($stmt2->error);
        }

        // Update player_basic_message table
        $stmt3 = $mysqli->prepare("UPDATE player_basic_message SET height=?, weight=? WHERE id=?");
        if (!$stmt3) {
            throw new Exception($mysqli->error);
        }
        $stmt3->bind_param("dii", $height, $weight, $id);
        if (!$stmt3->execute()) {
            throw new Exception($stmt3->error);
        }

        // Update contract table (assuming the start and end dates are stored here)
        $stmt4 = $mysqli->prepare("UPDATE contract SET start=?, end=? WHERE id=?");
        if (!$stmt4) {
            throw new Exception($mysqli->error);
        }
        $stmt4->bind_param("ssi", $start, $end, $id);
        if (!$stmt4->execute()) {
            throw new Exception($stmt4->error);
        }

        // Commit the transaction
        $mysqli->commit();
        return ['success' => true];
    } catch (Exception $e) {
        // Rollback the transaction on error
        $mysqli->rollback();
        error_log("Error updating data: " . $e->getMessage());
        return ['success' => false, 'message' => $e->getMessage()];
    } finally {
        // Close statements
        if (isset($stmt1)) $stmt1->close();
        if (isset($stmt2)) $stmt2->close();
        if (isset($stmt3)) $stmt3->close();
        if (isset($stmt4)) $stmt4->close();
    }
}

$response = save_data($mysqli, $id, $name, $tel, $email, $start, $end, $height, $weight, $username);
$mysqli->close();

echo json_encode($response);
?>