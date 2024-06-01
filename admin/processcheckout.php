<?php
include('includes/connect.php');
session_start();

if (isset($_POST["create"])) {
    $book_id = mysqli_real_escape_string($conn, $_POST["book_id"]);
    $member_id = mysqli_real_escape_string($conn, $_POST["member_id"]);
    $borrow_date = mysqli_real_escape_string($conn, $_POST["borrow_date"]);
    $return_date = mysqli_real_escape_string($conn, $_POST["return_date"]);
    $statuss = mysqli_real_escape_string($conn, $_POST["statuss"]);
    $sqlInsert = "INSERT INTO checkouts (book_id, member_id, borrow_date, return_date, statuss) VALUES ('$book_id', '$member_id', '$borrow_date', '$return_date', '$statuss')";
    if (mysqli_query($conn, $sqlInsert)) {
        $_SESSION["create"] = "Transaction Added Successfully!";
        header("Location: checkout.php");
        exit();
    } else {
        die("Something went wrong: " . mysqli_error($conn));
    }
}


if (isset($_POST["edit"])) {
    $checkout_id = mysqli_real_escape_string($conn, $_POST["checkout_id"]);
    $book_id = mysqli_real_escape_string($conn, $_POST["book_id"]);
    $member_id = mysqli_real_escape_string($conn, $_POST["member_id"]);
    $borrow_date = mysqli_real_escape_string($conn, $_POST["borrow_date"]);
    $return_date = mysqli_real_escape_string($conn, $_POST["return_date"]);
    $statuss = mysqli_real_escape_string($conn, $_POST["statuss"]);
    $sqlUpdate = "UPDATE checkouts SET book_id = '$book_id', member_id = '$member_id', borrow_date = '$borrow_date', return_date = '$return_date', statuss = '$statuss' WHERE checkout_id = '$checkout_id'";
    if (mysqli_query($conn, $sqlUpdate)) {
        $_SESSION["update"] = "Transaction Updated Successfully!";
        header("Location: checkout.php");
        exit();
    } else {
        die("Something went wrong: " . mysqli_error($conn));
    }
}
?>
