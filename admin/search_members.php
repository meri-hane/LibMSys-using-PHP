<?php
include('includes/connect.php');

if (isset($_GET['query'])) {
    $search_query = mysqli_real_escape_string($conn, $_GET['query']);
    $sql = "SELECT lname FROM members WHERE lname LIKE '%$search_query%' LIMIT 10";
    $result = mysqli_query($conn, $sql);
    $names = [];

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $names[] = $row['lname'];
        }
    } else {
        error_log("Database query error: " . mysqli_error($conn));
    }

    echo json_encode($names);
}
?>
