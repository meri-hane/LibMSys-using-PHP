<?php
    include('includes/connect.php');
    
if (isset($_GET['id'])) {
    $checkout_id = $_GET['id'];
    $sql = "DELETE FROM checkouts WHERE checkout_id='$checkout_id'";
    if(mysqli_query($conn, $sql)){
        session_start();
        $_SESSION["delete"] = "Member Deleted Successfully!";
        header("Location: transaction.php");
    } else {
        die("Something went wrong");
    }
} else {
    echo "Transaction does not exist";
}
?>
