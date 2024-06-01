<?php
include('includes/connect.php');

if (isset($_GET['id'])) {
    $member_id = $_GET['id'];
    $sql = "DELETE FROM members WHERE member_id='$member_id'";
    if(mysqli_query($conn, $sql)){
        session_start();
        $_SESSION["delete"] = "Member Deleted Successfully!";
        header("Location: members.php");
    } else {
        die("Something went wrong");
    }
} else {
    echo "Member does not exist";
}
?>
