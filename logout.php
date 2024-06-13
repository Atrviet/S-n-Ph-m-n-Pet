<?php
session_start();
if (isset($_GET['logout'])) {
    // Destroy the session and unset all session variables
    session_unset();
    session_destroy();

    // Redirect to the login page or home page
    header("Location: facebook.php"); // Change to your home or login page
    exit;
}
?>
