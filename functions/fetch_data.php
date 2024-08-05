<?php
session_start(); // Ensure session is started

include 'db.php'; // Include your database connection file

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(array('error' => 'User not logged in'));
    header('Location: login.php');
    exit();
}
$user_id = $_SESSION['user_id'];

// Prepare SQL statement with a placeholder
$stmt = $connect->prepare("SELECT * FROM frederick_data_table WHERE user_id = ?");
if (!$stmt) {
    echo json_encode(array('error' => 'SQL prepare error: ' . $connect->error));
    exit();
}

// Bind parameters and execute the statement
$stmt->bind_param("i", $user_id);
if (!$stmt->execute()) {
    echo json_encode(array('error' => 'SQL execute error: ' . $stmt->error));
    exit();
}

// Fetch results
$result = $stmt->get_result();
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Output the data as JSON
echo json_encode(array('data' => $data));

// Close the statement and connection
$stmt->close();
$connect->close();
?>

