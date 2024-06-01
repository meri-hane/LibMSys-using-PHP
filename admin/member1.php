<?php
session_start(); // Start the session before any output
include('includes/connect.php');
// Check if admin is not logged in, redirect to login.php if not
if(!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Define how many results you want per page
$results_per_page = 10;

// Handle search query
$search_query = '';
if (isset($_GET['search'])) {
    $search_query = mysqli_real_escape_string($conn, $_GET['search']);
}

// Handle sorting
$sort_field = 'member_id'; // Default sort field
$sort_order = 'ASC'; // Default sort order
if (isset($_GET['sort_field']) && isset($_GET['sort_order'])) {
    $sort_field = mysqli_real_escape_string($conn, $_GET['sort_field']);
    $sort_order = mysqli_real_escape_string($conn, $_GET['sort_order']) == 'ASC' ? 'ASC' : 'DESC';
}

// Find out the number of results stored in database
$sql = "SELECT COUNT(member_id) AS total FROM members";
if ($search_query != '') {
    $sql .= " WHERE fname LIKE '%$search_query%' OR lname LIKE '%$search_query%' OR membership_type LIKE '%$search_query%'";
}
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$total_results = $row['total'];

// Determine number of total pages available
$total_pages = ceil($total_results / $results_per_page);

// Determine which page number visitor is currently on
$page = 1; // Default page
if (isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0) {
    $page = (int)$_GET['page'];
    if ($page > $total_pages) {
        $page = $total_pages; // Cap at the maximum page number
    }
}

// Determine the sql LIMIT starting number for the results on the displaying page
$starting_limit = ($page - 1) * $results_per_page;

// Retrieve selected results from database and display them on page
$sql = "SELECT * FROM members";
if ($search_query != '') {
    $sql .= " WHERE fname LIKE '%$search_query%' OR lname LIKE '%$search_query%' OR membership_type LIKE '%$search_query%'";
}
$sql .= " ORDER BY $sort_field $sort_order LIMIT $starting_limit, $results_per_page";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

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

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">
   
      <i class="bi bi-list toggle-sidebar-btn"></i><!-- End Logo -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->

        
       

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2">M. Admin</span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>Mary Jane P. Calulang</h6>
              <span>Admin</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            
            <li>
              <a class="dropdown-item d-flex align-items-center" href="#">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

  <ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-item">
      <a class="nav-link" href="index1.php">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li><!-- End Dashboard Nav -->


   <li class="nav-item">
  <a class="nav-link collapsed" href="transaction.php">
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
        <i class="bi bi-layout-text-window-reverse"></i><span>Members</span>
      </a>
    </li><!-- End Tables Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-layout-text-window-reverse"></i><span>Librarian</span>
      </a>
    </li><!-- End Tables Nav -->
  </ul>

</aside><!-- End Sidebar-->


  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Member List</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index1.php">Home</a></li>
          <li class="breadcrumb-item active">Members</li>
        </ol>
      </nav>

      <div class="d-flex">
            <form method="GET" action="members.php" class="me-2">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search for members..." value="<?php echo htmlspecialchars($search_query); ?>">
                    <button type="submit" class="btn btn-pink">Search</button>
                </div>
            </form>
            <button type="button" class="btn btn-pink" data-bs-toggle="modal" data-bs-target="#addMemberModal">Add New Member</button> <!-- Changed to light pink button -->
               </div>
    </div><!-- End Page Title -->

    <?php if (isset($_SESSION["create"])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION["create"]; ?>
            </div>
            <?php unset($_SESSION["create"]); ?>
        <?php endif; ?>
        
        <?php if (isset($_SESSION["update"])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION["update"]; ?>
            </div>
            <?php unset($_SESSION["update"]); ?>
        <?php endif; ?>
        
        <?php if (isset($_SESSION["delete"])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION["delete"]; ?>
            </div>
            <?php unset($_SESSION["delete"]); ?>
        <?php endif; ?>

        <?php
        $start_result = $starting_limit + 1;
        $end_result = min($starting_limit + $results_per_page, $total_results);
        ?>
        
        <table class="table table-bordered table-girly">
        <thead>
            <tr>
                <th><a href="?<?php echo http_build_query(array_merge($_GET, ['sort_field' => 'member_id', 'sort_order' => ($sort_field == 'member_id' && $sort_order == 'ASC') ? 'DESC' : 'ASC'])); ?>" class="sort-link">ID<?php echo $sort_field == 'member_id' ? ($sort_order == 'ASC' ? ' <i class="fa fa-arrow-up sort-icon"></i>' : ' <i class="fa fa-arrow-down sort-icon"></i>') : ''; ?></a></th>
                <th><a href="?<?php echo http_build_query(array_merge($_GET, ['sort_field' => 'fname', 'sort_order' => ($sort_field == 'fname' && $sort_order == 'ASC') ? 'DESC' : 'ASC'])); ?>" class="sort-link">First Name<?php echo $sort_field == 'fname' ? ($sort_order == 'ASC' ? ' <i class="fa fa-arrow-up sort-icon"></i>' : ' <i class="fa fa-arrow-down sort-icon"></i>') : ''; ?></a></th>
                <th><a href="?<?php echo http_build_query(array_merge($_GET, ['sort_field' => 'lname', 'sort_order' => ($sort_field == 'lname' && $sort_order == 'ASC') ? 'DESC' : 'ASC'])); ?>" class="sort-link">Last Name<?php echo $sort_field == 'lname' ? ($sort_order == 'ASC' ? ' <i class="fa fa-arrow-up sort-icon"></i>' : ' <i class="fa fa-arrow-down sort-icon"></i>') : ''; ?></a></th>
                <th><a href="?<?php echo http_build_query(array_merge($_GET, ['sort_field' => 'membership_type', 'sort_order' => ($sort_field == 'membership_type' && $sort_order == 'ASC') ? 'DESC' : 'ASC'])); ?>" class="sort-link">Membership Type<?php echo $sort_field == 'membership_type' ? ($sort_order == 'ASC' ? ' <i class="fa fa-arrow-up sort-icon"></i>' : ' <i class="fa fa-arrow-down sort-icon"></i>') : ''; ?></a></th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        while($data = mysqli_fetch_array($result)){
            ?>
            <tr>
                <td><?php echo $data['member_id']; ?></td>
                <td><?php echo $data['fname']; ?></td>
                <td><?php echo $data['lname']; ?></td>
                <td><?php echo $data['membership_type']; ?></td>
                <td>
                    <a href="editmember.php?id=<?php echo $data['member_id']; ?>" class="btn btn-warning">Edit</a>
                    <a href="deletemember.php?id=<?php echo $data['member_id']; ?>" class="btn btn-danger">Delete</a>
                </td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>

     <nav class="pagination-container">
            <p class="result-count">Showing <?php echo $starting_limit + 1; ?> to <?php echo min($starting_limit + $results_per_page, $total_results); ?> of <?php echo $total_results; ?> results</p>
        <ul class="pagination">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item<?php if ($i == $page) echo ' active'; ?>">
                <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, ['page' => $i])); ?>"><?php echo $i; ?></a>
            </li>
            <?php endfor; ?>
        </ul>
    </nav>
      <!-- Modal Structure ADD -->
      <div class="modal fade" id="addMemberModal" tabindex="-1" aria-labelledby="addMemberModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addMemberModalLabel">Add New Member</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="processmember.php" method="post">
                            <div class="form-elemnt my-4">
                                <input type="text" class="form-control" name="fname" placeholder="First Name" required>
                            </div>
                            <div class="form-elemnt my-4">
                                <input type="text" class="form-control" name="lname" placeholder="Last Name" required>
                            </div>
                        
                            <div class="form-group my-4">
                <label for="membership_type">Membership Type</label>
                <select class="form-control" name="membership_type" id="membership_type">
                    <option value="Basic">Basic</option>
                    <option value="Student">Student</option>
                    <option value="Student">Premium</option>
                </select>
            </div>
                            <div class="form-element my-4">
                                <input type="submit" name="create" value="Add Member" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
  
  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>Mary Jane P. Calulang</span></strong>. All Rights Reserved
    </div>
  </footer><!-- End Footer -->

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