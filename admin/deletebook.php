<?php
    include('includes/connect.php');

if (isset($_GET['id'])) {
    $book_id = $_GET['id'];
    $sql = "DELETE FROM books WHERE book_id='$book_id'";
    if(mysqli_query($conn, $sql)){
        session_start();
        $_SESSION["delete"] = "Book Deleted Successfully!";
        header("Location: book1.php");
    } else {
        die("Something went wrong");
    }
} else {
    echo "Book does not exist";
}
?>
