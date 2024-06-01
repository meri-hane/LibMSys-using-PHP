<?php
include('includes/connect.php');
if (isset($_POST["create"])) {
    $title = mysqli_real_escape_string($conn, $_POST["title"]);
    $isbn = mysqli_real_escape_string($conn, $_POST["isbn"]);
    $author = mysqli_real_escape_string($conn, $_POST["author"]);
    $description = mysqli_real_escape_string($conn, $_POST["description"]);
    $sqlInsert = "INSERT INTO books(title , author , isbn , description) VALUES ('$title','$author','$isbn', '$description')";
    if(mysqli_query($conn,$sqlInsert)){
        session_start();
        $_SESSION["create"] = "Book Added Successfully!";
        header("Location:book1.php");
    }else{
        die("Something went wrong");
    }
}
else{
    $_SESSION['error'] = 'Fill up add form first';
}

if (isset($_POST["edit"])) {
    $title = mysqli_real_escape_string($conn, $_POST["title"]);
    $isbn = mysqli_real_escape_string($conn, $_POST["isbn"]);
    $author = mysqli_real_escape_string($conn, $_POST["author"]);
    $description = mysqli_real_escape_string($conn, $_POST["description"]);
    $book_id = mysqli_real_escape_string($conn, $_POST["book_id"]);
    $sqlUpdate = "UPDATE books SET title = '$title', isbn = '$isbn', author = '$author', description = '$description' WHERE book_id='$book_id'";
    if(mysqli_query($conn,$sqlUpdate)){
        session_start();
        $_SESSION["update"] = "Book Updated Successfully!";
        header("Location:book1.php");
    }else{
        die("Something went wrong");
    }
}
?>
