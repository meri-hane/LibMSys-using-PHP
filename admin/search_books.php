<?php
include('includes/connect.php');

if (isset($_GET['query'])) {
    $search_query = mysqli_real_escape_string($conn, $_GET['query']);
    $sql = "SELECT title FROM books WHERE title LIKE '%$search_query%' LIMIT 10";
    $result = mysqli_query($conn, $sql);
    $titles = [];

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $titles[] = $row['title'];
        }
    } else {
        error_log("Database query error: " . mysqli_error($conn));
    }

    echo json_encode($titles);
}
?>
