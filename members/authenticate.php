<?php
// Start session
session_start();

// Include database connection
//include 'db_connection.php';
include('includes/connection.php');

// Retrieve member ID from form
$member_id = $_POST['member_id'];

// Check if member ID exists in the database
$query = "SELECT * FROM members WHERE member_id = '$member_id'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 1) {
    // Member exists, set session variable and redirect to home page
    $_SESSION['member_id'] = $member_id;
    header('Location: home.php');
} else {
    // Member does not exist, redirect back to login page
    header('Location: login.php');
}

// Close database connection
mysqli_close($conn);
?>


