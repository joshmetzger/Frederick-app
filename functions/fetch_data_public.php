<?php
session_start(); // Ensure session is started

include 'db.php'; // Include your database connection file


// Prepare SQL statement with a placeholder
$stmt = $connect->prepare("SELECT * FROM frederick_data_table");
if (!$stmt) {
    echo json_encode(array('error' => 'SQL prepare error: ' . $connect->error));
    exit();
}

// execute the statement
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

