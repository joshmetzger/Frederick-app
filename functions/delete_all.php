<?php
session_start();
include 'db.php';

// Check if user is logged in and user_id is set
if (!isset($_SESSION['user_id'])) {
    echo 'User not logged in.';
    exit();
}

$user_id = $_SESSION['user_id'];

// Prepare the SQL statement with a placeholder
$stmt = $connect->prepare("DELETE FROM frederick_data_table WHERE user_id = ?");

if ($stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($connect->error));
}

// Bind the user_id parameter
$stmt->bind_param("i", $user_id);

// Execute the statement
if ($stmt->execute()) {
    $_SESSION['all_deleted_message'] = 'All records deleted successfully!';
} else {
    $_SESSION['all_deleted_message'] = 'Error: ' . htmlspecialchars($stmt->error);
}

// Close the statement
$stmt->close();

// Close the database connection
$connect->close();

// Redirect to index.php
header('Location: ../public/index.php');
exit(); // Always call exit after header redirection
?>
