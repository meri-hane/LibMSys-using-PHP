<?php
session_start();
// Check if librarian is already logged in, redirect to index.php if yes
if(isset($_SESSION['librarian_id'])) {
    header("Location: index1.php");
    exit();
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database connection
    include('includes/connect.php');

    $librarian_id = $_POST['librarian_id'];

    // Query to check if librarian ID exists in the database
    $query = "SELECT * FROM librarians WHERE librarian_id = '$librarian_id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        // Librarian exists, set session variable and redirect to index.php
        $_SESSION['librarian_id'] = $librarian_id;
        header("Location: index1.php");
        exit();
    } else {
        // Librarian does not exist, display error message
        $error = 'Invalid Librarian ID';
    }

    // Close database connection
    mysqli_close($conn);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Librarian Login</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title text-center">Librarian Login</h3>
                        <?php if (isset($_GET['error']) && $_GET['error'] == 1) { ?>
                            <div class="alert alert-danger" role="alert">
                                Invalid librarian ID.
                            </div>
                        <?php } ?>
                        <form action="login.php" method="POST">
                            <div class="mb-3">
                                <label for="librarian_id" class="form-label">Librarian ID</label>
                                <input type="text" class="form-control" id="librarian_id" name="librarian_id" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
