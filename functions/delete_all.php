<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo 'User not logged in.';
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $connect->prepare("DELETE FROM frederick_data_table WHERE user_id = ?");

if ($stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($connect->error));
}

$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    $_SESSION['all_deleted_message'] = 'All records deleted successfully!';
} else {
    $_SESSION['all_deleted_message'] = 'Error: ' . htmlspecialchars($stmt->error);
}

$stmt->close();
$connect->close();

header('Location: ../public/index.php');
exit();
?>
