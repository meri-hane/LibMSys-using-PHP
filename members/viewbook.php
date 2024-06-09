<?php
// Start session
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);


// Include database connection
include('includes/connect.php');

// Assuming you are getting the book ID from a GET request
$book_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Check if the book ID is valid
if ($book_id > 0) {
    // Prepare and execute the SQL query
    $stmt = $conn->prepare("SELECT title, description, author, isbn FROM books WHERE book_id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $book_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Fetch the book details
        $row = $result->fetch_assoc();
    } else {
        // If the statement preparation fails
        die("Error preparing the SQL statement: " . $conn->error);
    }
} else {
    die("Invalid book ID.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Details</title>
    <style>
        /* Custom styles for the book details page */
        .book-details h4 {
            font-weight: bold;
            color: #ff4081;
        }
        .book-details p {
            font-size: 1.1em;
            color: #333;
        }
        .book-details {
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        .btn-pink {
            background-color: #ff4081;
            color: #fff;
        }
        .btn-pink:hover {
            background-color: #e8376d;
            color: #fff;
        }
        /* Ensures the content is below the fixed header */
        .content-wrapper {
            padding-top: 110px; /* Adjust based on the height of your fixed header */
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <link rel="stylesheet" href="assets/css/templatemo-softy-pinko.css">

    <div class="content-wrapper">
        <div class="container my-4">
            <header class="d-flex justify-content-between my-4">
                <h1>Book Details</h1>
                <div>
                    <a href="home.php" class="btn btn-pink">Back</a>
                </div>
            </header>

            <div class="book-details p-5 my-4">
                <?php
                if (isset($row)) {
                ?>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <h4>Title:</h4>
                        </div>
                        <div class="col-md-9">
                            <p><?php echo htmlspecialchars($row["title"]); ?></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <h4>Description:</h4>
                        </div>
                        <div class="col-md-9">
                            <p><?php echo htmlspecialchars($row["description"]); ?></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <h4>Author:</h4>
                        </div>
                        <div class="col-md-9">
                            <p><?php echo htmlspecialchars($row["author"]); ?></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <h4>ISBN:</h4>
                        </div>
                        <div class="col-md-9">
                            <p><?php echo htmlspecialchars($row["isbn"]); ?></p>
                        </div>
                    </div>
                <?php
                } else {
                    echo "<h3>No book found</h3>";
                }

                // Close the database connection
                $conn->close();
                ?>
            </div>
        </div>
    </div>
</body>
</html>
