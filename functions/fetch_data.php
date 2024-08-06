<?php
session_start();
include 'db.php';

// user check
if (!isset($_SESSION['user_id'])) {
    echo json_encode(array('error' => 'User not logged in'));
    header('Location: login.php');
    exit();
}
$user_id = $_SESSION['user_id'];

// prepare SQL 
$stmt = $connect->prepare("SELECT * FROM frederick_data_table WHERE user_id = ?");
if (!$stmt) {
    echo json_encode(array('error' => 'SQL prepare error: ' . $connect->error));
    exit();
}

// bind user_id
$stmt->bind_param("i", $user_id);
if (!$stmt->execute()) {
    echo json_encode(array('error' => 'SQL execute error: ' . $stmt->error));
    exit();
}

// query results
$result = $stmt->get_result();
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// JSON data
echo json_encode(array('data' => $data));

$stmt->close();
$connect->close();
?>

