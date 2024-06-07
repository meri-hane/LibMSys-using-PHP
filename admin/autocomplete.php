<?php
// Include database connection code
include('includes/connect.php');

// Get the user input from the query parameter
$input = $_GET['q'];

// Perform a database query to fetch book titles that match the user input
$sql = "SELECT title FROM books WHERE title LIKE '%$input%'";
$result = mysqli_query($conn, $sql);

// Display the matching book titles as autocomplete suggestions
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div>" . $row['title'] . "</div>";
    }
} else {
    echo "No matching books found";
}
?>
