<?php
// Start session
session_start();

// Check if member is logged in
if (!isset($_SESSION['member_id'])) {
    header('Location: login.php');
    exit();
}

// Include database connection
include('includes/connect.php');

// Retrieve member's borrowed and returned books
// Retrieve member's name
$member_id = $_SESSION['member_id'];
$query_member = "SELECT fname, lname FROM members WHERE member_id = '$member_id'";
$result_member = mysqli_query($conn, $query_member);
$row_member = mysqli_fetch_assoc($result_member);
$member_name = $row_member['fname'] . ' ' . $row_member['lname'];

// Determine sorting parameters
$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'date';
$sort_order = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'ASC';

// Determine whether to display borrowed or returned books
$type = isset($_GET['type']) && ($_GET['type'] == 'borrowed' || $_GET['type'] == 'returned') ? $_GET['type'] : 'borrowed';

// Adjust query based on the type of books to display
if ($type == 'borrowed') {
    $query = "SELECT books.title, books.author, books.isbn, checkouts.borrow_date AS date 
              FROM checkouts
              INNER JOIN books ON checkouts.book_id = books.book_id
              WHERE checkouts.member_id = '$member_id' AND checkouts.return_date IS NULL
              ORDER BY $sort_by $sort_order";
    $type_label = 'Borrowed';
} else {
    $query = "SELECT books.title, books.author, books.isbn, checkouts.return_date AS date 
              FROM checkouts
              INNER JOIN books ON checkouts.book_id = books.book_id
              WHERE checkouts.member_id = '$member_id' AND checkouts.return_date IS NOT NULL
              ORDER BY $sort_by $sort_order";
    $type_label = 'Returned';
}

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Transactions</title>
    <link href="assets/img/LMS.png" rel="icon">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <style>
        body {
            padding-top: 110px; /* Adjust as needed */
            color: #000; /* Black text */
        }

        .table-container {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<?php include 'includes/header.php'; ?>
<link rel="stylesheet" href="assets/css/templatemo-softy-pinko.css">

<header id="header" class="header fixed-top d-flex align-items-center justify-content-between">
  <!-- Logo pic -->
  <img src="assets/img/new_logo.png" alt="Logo" class="logo-pic">

  <!-- Navigation Links -->
  <nav class="main-nav">
    <ul class="nav justify-content-center">
      <li class="nav-item">
      <a class="nav-link" href="home.php" style="color: black;">Home</a>
      </li>
      <li class="nav-item">
      <a class="nav-link" href="transaction.php" style="color: black;">Transaction</a>
      </li>
    </ul>
  </nav>

  <!-- Profile Link and Logout Button -->
  <div class="d-flex align-items-center">
    <a href="https://github.com/meri-hane" target="_blank" class="nav-link nav-profile d-flex align-items-center pe-2">
      <img src="assets/img/mjpic.jpg" alt="Profile" class="rounded-circle me-2" style="width: 40px; height: 40px;">
      <span class="d-none d-md-block"><?php echo $member_name; ?></span>
    </a>

    <!-- Logout Link -->
    <a href="logout.php" class="btn btn-danger ms-2" style="margin-right: 25px;">Logout</a>
  </div>
</header>

<header class="d-flex justify-content-between align-items-center my-4">
        <h2>Welcome, <?php echo $member_name; ?></h2>
    </header>
<div class="container">
    <h2>Transactions</h2>
    <div class="mb-3">
        <label for="typeSelect" class="form-label">Show:</label>
        <select class="form-select form-select-sm" id="typeSelect">
            <option value="transaction.php?type=borrowed&sort_by=<?php echo $sort_by; ?>&sort_order=<?php echo $sort_order; ?>" <?php echo $type === 'borrowed' ? 'selected' : ''; ?>>Borrowed</option>
            <option value="transaction.php?type=returned&sort_by=<?php echo $sort_by; ?>&sort_order=<?php echo $sort_order; ?>" <?php echo $type === 'returned' ? 'selected' : ''; ?>>Returned</option>
        </select>
    </div>

    <h3><?php echo $type_label; ?> Books</h3>
    <div class="table-container">
    <table class="table table-bordered table-girly"> <!-- Added girly table styling -->
            <thead>
                <tr>
                    <th>Date</th>
                    <th>ISBN</th>
                    <th>Title</th>
                    <th>Author</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['date']; ?></td>
                        <td><?php echo $row['isbn']; ?></td>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['author']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    document.getElementById('typeSelect').addEventListener('change', function() {
        window.location.href = this.value;
    });
</script>


</body>
</html>
