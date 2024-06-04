<?php
// Start session
session_start();

// Check if member is logged in
if (!isset($_SESSION['member_id'])) {
    header('Location: login.php');
    exit();
}

// Include database connection
include 'db_connection.php';

// Retrieve member's borrowed books
$member_id = $_SESSION['member_id'];
$query = "SELECT books.title, checkouts.borrow_date, checkouts.return_date FROM checkouts
          INNER JOIN books ON checkouts.book_id = books.book_id
          WHERE checkouts.member_id = '$member_id'";
$result = mysqli_query($connection, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Transactions</title>
</head>
<body>
    <h2>Transactions</h2>
    <h3>Your Borrowed Books</h3>
    <ul>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <li><?php echo $row['title']; ?> - Borrowed: <?php echo $row['borrow_date']; ?>, Returned: <?php echo $row['return_date']; ?></li>
        <?php } ?>
    </ul>
</body>
</html>
