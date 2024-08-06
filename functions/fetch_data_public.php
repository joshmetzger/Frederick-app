<?php
session_start();
include 'db.php';

// errors in case of faiure
$stmt = $connect->prepare("SELECT * FROM frederick_data_table");
if (!$stmt) {
    echo json_encode(array('error' => 'SQL prepare error: ' . $connect->error));
    exit();
}

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

// output JSON data
echo json_encode(array('data' => $data));

$stmt->close();
$connect->close();
?>

