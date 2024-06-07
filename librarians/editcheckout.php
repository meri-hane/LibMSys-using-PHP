<?php
session_start(); // Start the session before any output
include('includes/connect.php');
// Check if librarian is not logged in, redirect to login page
if (!isset($_SESSION['librarian_id'])) {
    header('Location: login.php');
    exit();
}

// Retrieve librarian's name
$librarian_id = $_SESSION['librarian_id'];
$query_librarian = "SELECT name FROM librarians WHERE librarian_id = '$librarian_id'";
$result_librarian = mysqli_query($conn, $query_librarian);
$row_librarian = mysqli_fetch_assoc($result_librarian);
$librarian_name = $row_librarian['name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>Edit Transaction</title>

    <!-- Custom CSS to adjust datepicker size -->
    <style>
        .datepicker {
            font-size: 1.2em;
        }
    </style>
</head>

<?php include 'includes/header.php'; ?>
<link rel="stylesheet" href="assets/css/templatemo-softy-pinko.css"
<body>
<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

  <ul class="sidebar-nav" id="sidebar-nav">

    
  <li class="nav-item">
    <a class="nav-link collapsed" href="index1.php">
        <i class="bi bi-grid"></i><span>Dashboard</span>
      </a>
    </li><!-- End Tables Nav -->


   <li class="nav-item">
  <a class="nav-link" href="transaction.php">
    <i class="bi bi-menu-button-wide"></i><span>Transaction</span>
  </a>
</li>
<!-- End Components Nav -->

    <li class="nav-item">
    <a class="nav-link collapsed" href="book1.php">
        <i class="bi bi-journal-text"></i><span>Books</span>
      </a>
    </li><!-- End Forms Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" href="member1.php">
        <i class="bi bi-layout-text-window-reverse"></i>
        
        <span>Members</span>
      </a>
    </li>


    <li class="nav-item">
    <a class="nav-link collapsed" href="librarian.php">
        <i class="bi bi-layout-text-window-reverse"></i><span>Librarian</span>
      </a>
    </li><!-- End Tables Nav --><!-- End Tables Nav -->
  </ul>

</aside>
<main id="main" class="main">
  <div class="pagetitle">
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index1.php">Home</a></li>
        <li class="breadcrumb-item active">Transaction</li>
        <li class="breadcrumb-item active">Edit Transaction</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

<div class="container my-4">
    <header class="d-flex justify-content-between my-4">
        <h1>Edit Transaction</h1>
        <div>
            <a href="transaction.php" class="btn btn-pink">Back</a>
        </div>
    </header>
    <form action="processcheckout.php" method="post">

        <?php 
        include("includes/connect.php");
        if (isset($_GET['id'])) {
            
            $checkout_id = $_GET['id'];
            $sql = "SELECT * FROM checkouts WHERE checkout_id=$checkout_id";
            $result = mysqli_query($conn, $sql);
            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_array($result);
            ?>
            <div class="form-group my-4">
                <label for="book_id">Book ID:</label>
                <span><?php echo $row['book_id']; ?></span>
            </div>
            <div class="form-group my-4">
                <label for="member_id">Member ID:</label>
                <span><?php echo $row['member_id']; ?></span>
            </div>
            <div class="form-group my-4">
                <label for="borrow_date">Borrow Date:</label>
                <span><?php echo $row['borrow_date']; ?></span>
            </div>
            <div class="form-group my-4">
                <label for="return_date">Return Date:</label>
                <input type="text" class="form-control datepicker" name="return_date" id="return_date" value="<?php echo $row['return_date']; ?>" placeholder="Return Date" required>
            </div>
            <input type="hidden" name="return_librarian_id" value="<?php echo $librarian_id; ?>">

</div>

            <div class="form-group my-4">
                <label for="statuss">Status:</label>
                <select class="form-control" name="statuss" id="statuss" required>
                    <option value="Returned" <?php if($row['statuss'] == 'Returned') echo 'selected'; ?>>Returned</option>
                </select>
            </div>
            <input type="hidden" value="<?php echo $checkout_id; ?>" name="checkout_id">
            <div class="form-element my-4">
                <input type="submit" name="edit" value="Edit Transaction" class="btn btn-pink">
            </div>
        <?php
            } else {
                echo "<h3>Checkout record does not exist</h3>";
            }
        } else {
            echo "<h3>Checkout ID is not set</h3>";
        }
        ?>
    </form>
</div>


    <!-- Initialize Datepicker -->
    <script>
        $(document).ready(function(){
            $('#borrow_date, #return_date').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true
            });
        });
    </script>
</body>

</html>
