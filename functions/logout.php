<?php
session_start();

// Destroy all session data
$_SESSION = array();

// If using cookies for sessions, invalidate the session cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 42000, '/');
}

session_destroy();

header("Location: login.php");
exit;
?>
