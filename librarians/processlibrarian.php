<?php
include('includes/connect.php');
session_start(); // Move session start to the top

if (isset($_POST["create"])) {
    $name = mysqli_real_escape_string($conn, $_POST["name"]);

    // Check if the same name exists in the database (case-insensitive)
    $sqlCheckDuplicate = "SELECT * FROM librarians WHERE LOWER(name) = LOWER('$name')";
    $resultCheckDuplicate = mysqli_query($conn, $sqlCheckDuplicate);

    if (mysqli_num_rows($resultCheckDuplicate) > 0) {
        // If a duplicate entry is found, display an error message
        $_SESSION["error"] = "A librarian with the same name already exists!";
    } else {
        // Insert the new librarian into the database
        $sqlInsert = "INSERT INTO librarians(name) VALUES ('$name')";
        if (mysqli_query($conn, $sqlInsert)) {
            $_SESSION["create"] = "Librarian Added Successfully!";
        } else {
            $_SESSION["error"] = "Error adding librarian!";
        }
    }
    header("Location: librarian.php"); // Redirect to librarian page
    exit(); // Exit after redirection
}

if (isset($_POST["edit"])) {
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $librarian_id = mysqli_real_escape_string($conn, $_POST["librarian_id"]);

    // Check if the same name exists in the database for other librarians (case-insensitive)
    $sqlCheckDuplicate = "SELECT * FROM librarians WHERE LOWER(name) = LOWER('$name') AND librarian_id != '$librarian_id'";
    $resultCheckDuplicate = mysqli_query($conn, $sqlCheckDuplicate);

      // Update the librarian in the database
      $sqlUpdate = "UPDATE librarians SET name = '$name' WHERE librarian_id='$librarian_id'";

    if (mysqli_num_rows($resultCheckDuplicate) > 0) {
        // If a duplicate entry is found, display an error message
        $_SESSION["error"] = "A librarian with the same name already exists!";
        header("Location: librarian.php");
        exit();
    } else {
      
        if (mysqli_query($conn, $sqlUpdate)) {
            $_SESSION["update"] = "Librarian Updated Successfully!";
            header("Location: librarian.php");
            exit();
        } else {
            $_SESSION["error"] = "Error updating librarian!";
            header("Location: librarian.php");
            exit();
        }
    }
}

?>
