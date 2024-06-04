<?php
include('includes/connect.php');
session_start();


if (isset($_POST['create'])) {
    $book_title = mysqli_real_escape_string($conn, $_POST['book_title']);
    $member_lname = mysqli_real_escape_string($conn, $_POST['member_lname']);
    $borrow_date = mysqli_real_escape_string($conn, $_POST['borrow_date']);
    $borrow_librarian_id = mysqli_real_escape_string($conn, $_POST['borrow_librarian_id']);
    $statuss = 'Borrowed';

    // Retrieve book ID based on book title
    $book_query = "SELECT book_id FROM books WHERE title = '$book_title' LIMIT 1";
    $book_result = mysqli_query($conn, $book_query);
    if ($book_result && mysqli_num_rows($book_result) > 0) {
        $book_data = mysqli_fetch_assoc($book_result);
        $book_id = $book_data['book_id'];
    } else {
        $_SESSION['error'] = 'Book not found.';
        header('Location: transaction.php');
        exit();
    }

    // Retrieve member ID based on member last name
    $member_query = "SELECT member_id FROM members WHERE lname = '$member_lname' LIMIT 1";
    $member_result = mysqli_query($conn, $member_query);
    if ($member_result && mysqli_num_rows($member_result) > 0) {
        $member_data = mysqli_fetch_assoc($member_result);
        $member_id = $member_data['member_id'];
    } else {
        $_SESSION['error'] = 'Member not found.';
        header('Location: transaction.php');
        exit();
    }

    $sql = "INSERT INTO checkouts (book_id, member_id, borrow_date, statuss, borrow_librarian_id) 
            VALUES ('$book_id', '$member_id', '$borrow_date', '$statuss', '$borrow_librarian_id')";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['create'] = 'New transaction has been added successfully.';
    } else {
        $_SESSION['error'] = 'Error adding new transaction: ' . mysqli_error($conn);
    }

    header('Location: transaction.php');
}

if (isset($_POST['edit'])) {
    $checkout_id = mysqli_real_escape_string($conn, $_POST["checkout_id"]);
    $return_date = mysqli_real_escape_string($conn, $_POST["return_date"]);
    $return_librarian_id = mysqli_real_escape_string($conn, $_POST["return_librarian_id"]);
    $statuss = mysqli_real_escape_string($conn, $_POST["statuss"]);

    // Fetch the borrow date and book ID from the database
    $sqlFetchData = "SELECT borrow_date, book_id FROM checkouts WHERE checkout_id = '$checkout_id'";
    $resultFetch = mysqli_query($conn, $sqlFetchData);
    
    if ($resultFetch && mysqli_num_rows($resultFetch) > 0) {
        $row = mysqli_fetch_assoc($resultFetch);
        $borrow_date = $row['borrow_date'];
        $book_id = $row['book_id'];

        // Check if return date is earlier than borrow date
        if ($return_date < $borrow_date) {
            $_SESSION["error"] = "Return date cannot be earlier than the borrow date!";
            header("Location: transaction.php");
            exit();
        }

        // Proceed with the update transaction
        $sqlUpdate = "UPDATE checkouts SET return_date = '$return_date', return_librarian_id = '$return_librarian_id', statuss = '$statuss' WHERE checkout_id = '$checkout_id'";
        
        if (mysqli_query($conn, $sqlUpdate)) {
            $_SESSION["update"] = "Transaction Updated Successfully!";
            header("Location: transaction.php");
            exit();
        } else {
            $_SESSION["error"] = "Error updating transaction: " . mysqli_error($conn);
            header("Location: transaction.php");
            exit();
        }
    } else {
        $_SESSION["error"] = "Failed to fetch data.";
        header("Location: transaction.php");
        exit();
    }
}

?>
