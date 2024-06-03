<?php include 'includes/header.php'; ?>
<link rel="stylesheet" href="assets/css/templatemo-softy-pinko.css">
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
<a class="nav-link collapsed" href="transaction.php">
  <i class="bi bi-menu-button-wide"></i><span>Transaction</span>
</a>
</li>
<!-- End Components Nav -->

  <li class="nav-item">
  <a class="nav-link" href="book1.php">
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
        <li class="breadcrumb-item active">Books</li>
        <li class="breadcrumb-item active">View Book</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

    <div class="container my-4">
        <header class="d-flex justify-content-between my-4">
            <h1>Book Details</h1>
            <div>
                <a href="book1.php" class="btn btn-pink">Back</a>
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
          echo "<h3>No books found</h3>";
        }
      } else {
        echo "<h3>No books found</h3>";
      }
      ?>
    </div>
        </div>
    </main>
</body>
</html>
