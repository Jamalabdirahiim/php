<?php
session_start();

// Function to check if user is logged in
function check_login() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
}

// Function to check access control (Admins only)
function check_admin() {
    check_login();
    if ($_SESSION['user_type'] != 'Admin') {
        echo "<h2 style='color:red; text-align:center; margin-top:50px;'>Access Denied: Admins Only</h2>";
        exit();
    }
}

// Automatic Session Expiry (5 Minutes)
$timeout_duration = 300; // 5 minutes in seconds

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout_duration) {
    // Last request was more than 5 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
    header("Location: login.php?timeout=1");
    exit();
}
$_SESSION['last_activity'] = time(); // update last activity time stamp
?>
