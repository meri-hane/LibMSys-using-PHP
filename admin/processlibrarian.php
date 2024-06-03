<?php
include('includes/connect.php');

if (isset($_POST["create"])) {
    $name = mysqli_real_escape_string($conn, $_POST["name"]);

    // Check if the same name exists in the database (case-insensitive)
    $sqlCheckDuplicate = "SELECT * FROM librarians WHERE LOWER(name) = LOWER('$name')";
    $resultCheckDuplicate = mysqli_query($conn, $sqlCheckDuplicate);

    session_start(); // Add session start here as well

    if (mysqli_num_rows($resultCheckDuplicate) > 0) {
        // If a duplicate entry is found, display an error message
        $_SESSION["error"] = "A librarian with the same name already exists!";
        header("Location: librarian.php");
        exit(); // Exit to prevent further execution
    } else {
        // Insert the new librarian into the database
        $sqlInsert = "INSERT INTO librarians(name) VALUES ('$name')";
        if (mysqli_query($conn, $sqlInsert)) {
            $_SESSION["create"] = "Librarian Added Successfully!";
            header("Location: librarian.php");
            exit(); // Exit after successful insertion
        } else {
            die("Something went wrong");
        }
    }
}

if (isset($_POST["edit"])) {
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $librarian_id = mysqli_real_escape_string($conn, $_POST["librarian_id"]);

    // Check if the same name exists in the database for other librarians (case-insensitive)
    $sqlCheckDuplicate = "SELECT * FROM librarians WHERE LOWER(name) = LOWER('$name') AND librarian_id != '$librarian_id'";
    $resultCheckDuplicate = mysqli_query($conn, $sqlCheckDuplicate);

    session_start(); // Add session start here as well

    if (mysqli_num_rows($resultCheckDuplicate) > 0) {
        // If a duplicate entry is found, display an error message
        $_SESSION["error"] = "A librarian with the same name already exists!";
        header("Location: librarian.php");
        exit(); // Exit to prevent further execution
    } else {
        // Update the librarian in the database
        $sqlUpdate = "UPDATE librarians SET name = '$name' WHERE librarian_id='$librarian_id'";
        if (mysqli_query($conn, $sqlUpdate)) {
            $_SESSION["update"] = "Librarian Updated Successfully!";
            header("Location: librarian.php");
            exit(); // Exit after successful update
        } else {
            die("Something went wrong");
        }
    }
}
?>
