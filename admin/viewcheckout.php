<?php include 'includes/header.php'; ?>
<body>
    <div class="container my-4">
        <header class="d-flex justify-content-between my-4">
            <h1>Transaction Details</h1>
            <div>
                <a href="checkout.php" class="btn btn-primary">Back</a>
            </div>
        </header>
        <div class="member-details p-5 my-4">
            <?php
            include('includes/connect.php');
            if (isset($_GET['id'])) {
                $checkout_id = $_GET['id'];
                $sql = "SELECT * FROM checkouts WHERE checkout_id = $checkout_id";
                
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
            ?>
                 <h3>Book ID:</h3>
                 <p><?php echo $row["book_id"]; ?></p>
                 <h3>Member ID:</h3>
                 <p><?php echo $row["member_id"]; ?></p>
                 <h3>Borrow Date: </h3>
                 <p><?php echo $row["borrow_date"]; ?></p>
                 <h3>Return Date: </h3>
                 <p><?php echo $row["return_date"]; ?></p>
                 <h3>Status: </h3>
                 <p><?php echo $row["statuss"]; ?></p>
            <?php
                } else {
                    echo "<h3>No checkout found</h3>";
                }
            } else {
                echo "<h3>No checkout found</h3>";
            }
            ?>
        </div>
    </div>
</body>
</html>
