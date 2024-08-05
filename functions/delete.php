<?php
include 'db.php';

$id = $_POST['id'];

$stmt = $connect->prepare("DELETE FROM frederick_data_table WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo 'Record deleted successfully';
} else {
    echo 'Error: ' . $stmt->error;
}

$stmt->close();
?>
