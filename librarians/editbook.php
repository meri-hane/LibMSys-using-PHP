<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>Edit Book</title>
</head>
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
        <li class="breadcrumb-item active">Edit Book</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <div class="container my-4">

    <header class="d-flex justify-content-between my-4">
      <h1>Edit Book</h1>
      <div>
        <a href="book1.php" class="btn btn-pink">Back</a>
      </div>
    </header>

    <form action="processbook.php" method="post">
      <?php 
      include('includes/connect.php');
      if (isset($_GET['id'])) {
        $book_id = $_GET['id'];
        $sql = "SELECT * FROM books WHERE book_id=$book_id";
        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
          $row = mysqli_fetch_assoc($result);
          ?>
          <div class="form-element my-4">
            <input type="text" class="form-control" name="title" placeholder="Book Title:" value="<?php echo htmlspecialchars($row["title"]); ?>">
          </div>
          <div class="form-element my-4">
            <input type="text" class="form-control" name="author" placeholder="Author Name:" value="<?php echo htmlspecialchars($row["author"]); ?>">
          </div>
          <div class="form-element my-4">
            <input type="text" class="form-control" name="isbn" placeholder="ISBN:"value="<?php echo htmlspecialchars($row["isbn"]); ?>">
          </div>
          <div class="form-element my-4">
            <textarea name="description" class="form-control" placeholder="Book Description:"><?php echo htmlspecialchars($row["description"]); ?></textarea>
          </div>
          <input type="hidden" value="<?php echo $book_id; ?>" name="book_id">
          <div class="form-element my-4">
            <input type="submit" name="edit" value="Edit Book" class="btn btn-pink">
          </div>
          <?php
        } else {
          echo "<h3>Book Does Not Exist</h3>";
        }
      } else {
        echo "<h3>Invalid Book ID</h3>";
      }
      ?>
    </form>
  </div>
</main><!-- End #main -->
</body>
</html>
