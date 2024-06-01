<?php include 'includes/header.php'; ?>
<body>
    <div class="container my-4">
        <header class="d-flex justify-content-between my-4">
            <h1>Book Details</h1>
            <div>
                <a href="book1.php" class="btn btn-primary">Back</a>
            </div>
        </header>
        <div class="book-details p-5 my-4">
            <?php
            include('includes/connect.php');
            if (isset($_GET['id'])) {
                $book_id = $_GET['id'];
                $sql = "SELECT * FROM books WHERE book_id = $book_id";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
            ?>
                 <h3>Title:</h3>
                 <p><?php echo $row["title"]; ?></p>
                 <h3>Description:</h3>
                 <p><?php echo $row["description"]; ?></p>
                 <h3>Author:</h3>
                 <p><?php echo $row["author"]; ?></p>
                 <h3>ISBN</h3>
                 <p><?php echo $row["isbn"]; ?></p>
            <?php
                } else {
                    echo "<h3>No books found</h3>";
                }
            } else {
                echo "<h3>No books found</h3>";
            }
            ?>
        </div>
    </div>
</body>
</html>
