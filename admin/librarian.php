<?php
include('includes/connect.php');
session_start(); // Add session start

// Check if search query is set
if (isset($_GET['search'])) {
    $search_query = $_GET['search'];
    $sql = "SELECT * FROM librarians WHERE name LIKE '%$search_query%'";
} else {
    $sql = "SELECT * FROM librarians";
}

$result = mysqli_query($conn, $sql);
?>

<body>

<?php include 'includes/header.php'; ?>
<link rel="stylesheet" href="assets/css/templatemo-softy-pinko.css">

<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
  <ul class="sidebar-nav" id="sidebar-nav">
    <li class="nav-item">
      <a class="nav-link collapsed" href="index1.php">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link collapsed" href="transaction.php">
        <i class="bi bi-menu-button-wide"></i><span>Transaction</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link collapsed" href="book1.php">
        <i class="bi bi-journal-text"></i><span>Books</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link collapsed" href="member1.php">
        <i class="bi bi-layout-text-window-reverse"></i><span>Members</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link " href="librarian.php">
        <i class="bi bi-layout-text-window-reverse"></i><span>Librarian</span>
      </a>
    </li>
  </ul>
</aside><!-- End Sidebar-->

<main id="main" class="main">
<div class="pagetitle">
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index1.php">Home</a></li>
          <li class="breadcrumb-item active">Librarian</li>
        </ol>
      </nav>

    <!-- Librarian List Header -->
    <div class="container my-4">
      <header class="d-flex justify-content-between align-items-center my-4">
        <h1>Librarian List</h1>
        <!-- Search Form and Add Librarian Button -->
        <div class="d-flex">
          <form method="GET" action="librarian.php" class="me-2">
            <div class="input-group">
              <input type="text" name="search" class="form-control" placeholder="Search..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
              <button type="submit" class="btn btn-pink">Search</button>
            </div>
          </form>
          <div style="height: 38px;">
            <button type="button" class="btn btn-pink" data-bs-toggle="modal" data-bs-target="#addLibrarianModal">Add Librarian</button>
          </div>
        </div>
      </header>

      <!-- Display Session Messages -->
      <?php if (isset($_SESSION["create"])): ?>
        <div class="alert alert-success">
          <?php 
          echo $_SESSION["create"];
          unset($_SESSION["create"]);
          ?>
        </div>
      <?php endif; ?>
      <?php if (isset($_SESSION["error"])): ?>
        <div class="alert alert-danger">
          <?php 
          echo $_SESSION["error"];
          unset($_SESSION["error"]);
          ?>
        </div>
      <?php endif; ?>

      <!-- Librarian Table -->
      <table class="table table-bordered table-girly">
        <colgroup>
          <col style="width: 5%;">
          <col style="width: 20%;">
          <col style="width: 20%;">
        </colgroup>
        <thead>
          <tr>
            <th>Librarian ID</th>
            <th>Librarian Name</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php while($data = mysqli_fetch_array($result)): ?>
          <tr>
            <td><?php echo $data['librarian_id']; ?></td>
            <td><?php echo $data['name']; ?></td>
            <td>
              <!-- Edit and Delete Buttons -->
              <a href="editlibrarian.php?id=<?php echo $data['librarian_id']; ?>" class="btn btn-warning">Edit</a>
              <a href="deletelibrarian.php?id=<?php echo $data['librarian_id']; ?>" class="btn btn-danger">Delete</a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</main><!-- End #main -->

<!-- Add Librarian Modal -->
<div class="modal fade" id="addLibrarianModal" tabindex="-1" aria-labelledby="addLibrarianModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addLibrarianModalLabel">Add Librarian</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Add Librarian Form -->
        <form action="processlibrarian.php" method="POST">
          <div class="mb-3">
            <label for="librarianName" class="form-label">Librarian Name</label>
            <input type="text" class="form-control" id="librarianName" name="name" required>
          </div>
          <button type="submit" class="btn btn-pink" name="create">Add</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/chart.js/chart.umd.js"></script>
<script src="assets/vendor/echarts/echarts.min.js"></script>
<script src="assets/vendor/quill/quill.js"></script>
<script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
<script src="assets/vendor/tinymce/tinymce.min.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>

<!-- Template Main JS File -->
<script src="assets/js/main.js"></script>

</body>
</html>
