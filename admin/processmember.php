<?php
include('includes/connect.php');

if (isset($_POST["create"])) {
    $fname = mysqli_real_escape_string($conn, $_POST["fname"]);
    $lname = mysqli_real_escape_string($conn, $_POST["lname"]);
    $membership_type = mysqli_real_escape_string($conn, $_POST["membership_type"]);

    // Convert input values to lowercase
    $fname_lower = strtolower($fname);
    $lname_lower = strtolower($lname);

    // Check if the same first name and last name combination exists in the database (case-insensitive)
    $sqlCheckDuplicate = "SELECT * FROM members WHERE LOWER(fname) = '$fname_lower' AND LOWER(lname) = '$lname_lower'";
    $resultCheckDuplicate = mysqli_query($conn, $sqlCheckDuplicate);

    if (mysqli_num_rows($resultCheckDuplicate) > 0) {
        // If a duplicate entry is found, display an error message
        session_start();
        $_SESSION["error"] = "A member with the same first name and last name already exists!";
        header("Location: member1.php");
        exit(); // Exit to prevent further execution
    } else {
        // Generate and hash password
        $password = 'mem' . date('Y');
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        // Insert the new member into the database
        $sqlInsert = "INSERT INTO members(fname , lname , membership_type, password) VALUES ('$fname','$lname','$membership_type', '$hashed_password')";
        if (mysqli_query($conn, $sqlInsert)) {
            session_start();
            $_SESSION["create"] = "Member Added Successfully! Initial password: $password";
            header("Location: member1.php");
            exit(); // Exit after successful insertion
        } else {
            die("Something went wrong");
        }
    }
}

if (isset($_POST["edit"])) {
    $fname = mysqli_real_escape_string($conn, $_POST["fname"]);
    $lname = mysqli_real_escape_string($conn, $_POST["lname"]);
    $membership_type = mysqli_real_escape_string($conn, $_POST["membership_type"]);
    $member_id = mysqli_real_escape_string($conn, $_POST["member_id"]);

    // Convert input values to lowercase
    $fname_lower = strtolower($fname);
    $lname_lower = strtolower($lname);

    // Check if the same first name and last name combination exists in the database for other members (case-insensitive)
    $sqlCheckDuplicate = "SELECT * FROM members WHERE LOWER(fname) = '$fname_lower' AND LOWER(lname) = '$lname_lower' AND member_id != '$member_id'";
    $resultCheckDuplicate = mysqli_query($conn, $sqlCheckDuplicate);

    if (mysqli_num_rows($resultCheckDuplicate) > 0) {
        // If a duplicate entry is found, display an error message
        session_start();
        $_SESSION["error"] = "A member with the same first name and last name already exists!";
        header("Location: member1.php");
        exit(); // Exit to prevent further execution
    } else {
        // Update the member in the database
        $sqlUpdate = "UPDATE members SET fname = '$fname', lname = '$lname', membership_type = '$membership_type' WHERE member_id='$member_id'";
        if (mysqli_query($conn, $sqlUpdate)) {
            session_start();
            $_SESSION["update"] = "Member Updated Successfully!";
            header("Location: member1.php");
            exit(); // Exit after successful update
        } else {
            die("Something went wrong");
        }
    }
}
?>
