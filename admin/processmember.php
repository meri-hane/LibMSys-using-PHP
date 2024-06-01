<?php
include('includes/connect.php');
if (isset($_POST["create"])) {
    $fname = mysqli_real_escape_string($conn, $_POST["fname"]);
    $lname = mysqli_real_escape_string($conn, $_POST["lname"]);
    $membership_type = mysqli_real_escape_string($conn, $_POST["membership_type"]);
    $sqlInsert = "INSERT INTO members(fname , lname , membership_type) VALUES ('$fname','$lname','$membership_type')";
    if(mysqli_query($conn,$sqlInsert)){
        session_start();
        $_SESSION["create"] = "Member Added Successfully!";
        header("Location:members.php");
    }else{
        die("Something went wrong");
    }
}
if (isset($_POST["edit"])) {
    $fname = mysqli_real_escape_string($conn, $_POST["fname"]);
    $lname = mysqli_real_escape_string($conn, $_POST["lname"]);
    $membership_type = mysqli_real_escape_string($conn, $_POST["membership_type"]);
    $member_id = mysqli_real_escape_string($conn, $_POST["member_id"]);
    $sqlUpdate = "UPDATE members SET fname = '$fname', lname = '$lname', membership_type = '$membership_type' WHERE member_id='$member_id'";
    if(mysqli_query($conn,$sqlUpdate)){
        session_start();
        $_SESSION["update"] = "Member Updated Successfully!";
        header("Location:members.php");
    }else{
        die("Something went wrong");
    }
}
?>
