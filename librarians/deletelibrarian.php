<?php
include('includes/connect.php');

if (isset($_GET['id'])) {
    $librarian_id = $_GET['id'];
    $sql = "DELETE FROM librarians WHERE librarian_id='$librarian_id'";
    if(mysqli_query($conn, $sql)){
        session_start();
        $_SESSION["delete"] = "Librarian Deleted Successfully!";
        header("Location: librarian.php");
    } else {
        die("Something went wrong");
    }
} else {
    echo "Librarian does not exist";
}
?>
