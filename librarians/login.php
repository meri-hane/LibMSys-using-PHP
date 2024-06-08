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
    $password = $_POST['password']; // Assuming you have a password field in your form

    // Query to check if librarian ID exists in the database
    $query = "SELECT * FROM librarians WHERE librarian_id = '$librarian_id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        // Librarian exists, fetch the record
        $row = mysqli_fetch_assoc($result);
        // Verify the hashed password
        if (password_verify('lib' . date('Y'), $row['password'])) {
            // Password is correct, set session variable and redirect to index.php
            $_SESSION['librarian_id'] = $librarian_id;
            header("Location: index1.php");
            exit();
        } else {
            // Password is incorrect
            $error = 'Invalid password.';
        }
    } else {
        // Librarian ID not found
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
     <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/templatemo-softy-pinko.css">
</head>
<body>
    <div class="container">
        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="pt-4 pb-2">
                                    <h5 class="card-title text-center pb-0 fs-4" style="color: rgb(199, 21, 133);">Librarian Login</h5>
                                    <?php if (!empty($error)) { ?>
                                        <div class="alert alert-danger"><?php echo $error; ?></div>
                                    <?php } ?>
                                    <form action="login.php" method="POST">
                                        <div class="col-md-12 mb-3">
                                            <label for="librarian_id" class="form-label">Librarian ID</label>
                                            <input type="text" class="form-control" id="librarian_id" name="librarian_id" required>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="password" name="password" required>
                                        </div>
                                        <div class="col-md-12">
                                        <button type="submit" class="btn btn-pink w-100">Login</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>
</html>
