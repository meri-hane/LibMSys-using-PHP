<?php
// Include your database connection file
include('includes/connect.php');

// Check if the 'q' parameter is set in the URL
if(isset($_GET['q'])) {
    // Sanitize and escape the user input
    $search_query = mysqli_real_escape_string($conn, $_GET['q']);

    // Construct the SQL query to search for member names
    $sql = "SELECT CONCAT(fname, ' ', lname) AS full_name FROM members WHERE fname LIKE '%$search_query%' OR lname LIKE '%$search_query%' LIMIT 10";

    // Execute the SQL query
    $result = mysqli_query($conn, $sql);

    // Check if any matching member names were found
    if(mysqli_num_rows($result) > 0) {
        // Fetch and output the matching member names as suggestions
        while($row = mysqli_fetch_assoc($result)) {
            echo "<div>{$row['full_name']}</div>";
        }
    } else {
        // No matching member names found
        echo "<div>No matching member names found.</div>";
    }
} else {
    // 'q' parameter not set
    echo "<div>No input provided.</div>";
}
?>
