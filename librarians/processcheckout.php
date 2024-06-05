<?php
include('includes/connect.php');
session_start();


if (isset($_POST['create'])) {
    $book_isbn = $_POST['book_isbn'];
    $member_id = $_POST['member_id'];
    $borrow_date = $_POST['borrow_date'];
    $borrow_librarian_id = mysqli_real_escape_string($conn, $_POST['borrow_librarian_id']);
    $statuss = $_POST['statuss']; // Assign statuss here

    // Convert book ISBN to book ID
    $book_result = mysqli_query($conn, "SELECT book_id FROM books WHERE isbn='$book_isbn'");
    if ($book_result && mysqli_num_rows($book_result) > 0) {
        $book_row = mysqli_fetch_assoc($book_result);
        $book_id = $book_row['book_id'];

        // Check if the book is already borrowed and not yet returned
        $checkout_result = mysqli_query($conn, "SELECT * FROM checkouts WHERE book_id='$book_id' AND statuss='Borrowed'");
        if ($checkout_result && mysqli_num_rows($checkout_result) > 0) {
            $_SESSION["error"] = "This book is already borrowed by another member.";
        } else {
            // Insert new checkout
            $sql = "INSERT INTO checkouts (book_id, member_id, borrow_date, borrow_librarian_id, statuss) VALUES ('$book_id', '$member_id', '$borrow_date', '$borrow_librarian_id', '$statuss')";
            if (mysqli_query($conn, $sql)) {
                $_SESSION["create"] = "New checkout has been added successfully.";
            } else {
                $_SESSION["error"] = "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }
    } else {
        $_SESSION["error"] = "Invalid Book ISBN.";
    }
    header("Location: transaction.php");
    exit();
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
