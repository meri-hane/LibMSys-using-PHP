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


// Define how many results you want per page
$results_per_page = 10;

// Handle search query
$search_query = '';
if (isset($_GET['search'])) {
    $search_query = mysqli_real_escape_string($conn, $_GET['search']);
}

// Handle sorting
$sort_field = 'book_id'; // Default sort field
$sort_order = 'ASC'; // Default sort order
if (isset($_GET['sort_field']) && isset($_GET['sort_order'])) {
    $sort_field = mysqli_real_escape_string($conn, $_GET['sort_field']);
    $sort_order = mysqli_real_escape_string($conn, $_GET['sort_order']) == 'ASC' ? 'ASC' : 'DESC';
}

// Find out the number of results stored in database
$sql = "SELECT COUNT(checkout_id) AS total FROM checkouts";
if ($search_query != '') {
    $sql .= " WHERE book_id LIKE '%$search_query%' OR member_id LIKE '%$search_query%' OR borrow_date LIKE '%$search_query%' OR return_date LIKE '%$search_query%' OR statuss LIKE '%$search_query%'";
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
$sql = "SELECT checkouts.*, books.title AS book_title, members.lname AS member_lname, 
            borrow_librarian.name AS borrow_librarian_name, return_librarian.name AS return_librarian_name 
        FROM checkouts 
        JOIN books ON checkouts.book_id = books.book_id 
        JOIN members ON checkouts.member_id = members.member_id
        LEFT JOIN librarians AS borrow_librarian ON checkouts.borrow_librarian_id = borrow_librarian.librarian_id
        LEFT JOIN librarians AS return_librarian ON checkouts.return_librarian_id = return_librarian.librarian_id";
if ($search_query != '') {
    $sql .= " WHERE books.title LIKE '%$search_query%' OR members.lname LIKE '%$search_query%' OR borrow_date LIKE '%$search_query%' OR return_date LIKE '%$search_query%' OR statuss LIKE '%$search_query%'";
}
$sql .= " ORDER BY $sort_field $sort_order LIMIT $starting_limit, $results_per_page";
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
  </ul>

</aside>

<main id="main" class="main">

<div class="pagetitle">
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index1.php">Home</a></li>
          <li class="breadcrumb-item active">Transaction</li>
        </ol>
      </nav>

    
      <div class="container my-4">
        <header class="d-flex justify-content-between align-items-center my-4">
            <h1>Transaction List</h1>
            <div class="d-flex">
    <form method="GET" action="transaction.php" class="me-2">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search for books..." value="<?php echo htmlspecialchars($search_query); ?>">
            <div class="input-group-append">
                <button type="submit" class="btn btn-pink">Search</button>
            </div>
        </div>
    </form>
    <div style="height: 38px;">
        <button type="button" class="btn btn-pink" data-bs-toggle="modal" data-bs-target="#addCheckoutModal">Borrow</button>
    </div>
</div>

        </header>
        <?php if (isset($_SESSION["create"])): ?>
            <div class="alert alert-success">
                <?= $_SESSION["create"] ?>
            </div>
        <?php unset($_SESSION["create"]); endif; ?>
        <?php if (isset($_SESSION["update"])): ?>
            <div class="alert alert-success">
                <?= $_SESSION["update"] ?>
            </div>
        <?php unset($_SESSION["update"]); endif; ?>
    

        <?php
        $start_result = $starting_limit + 1;
        $end_result = min($starting_limit + $results_per_page, $total_results);
        ?>
        
        <?php if (isset($_SESSION["error"])): ?>
    <div class="alert alert-danger"><?php echo $_SESSION["error"]; ?></div>
    <?php unset($_SESSION["error"]); ?>
<?php endif; ?>

        <table class="table table-bordered table-girly">
        <colgroup>
    <col style="width: 12.5%;">
    <col style="width: 12.5%;">
    <col style="width: 12.5%;">
    <col style="width: 12.5%;">
    <col style="width: 12.5%;">
    <col style="width: 12.5%;">
    <col style="width: 12.5%;">
    <col style="width: 12.5%;">
</colgroup>

    <thead>
    <tr>
        <th>Book Title</th>
        <th>Member Name</th>
        <th>Date Borrow</th>
        <th>Borrow Librarian</th>
        <th>Date Return</th>
        <th>Return Librarian</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
<?php while($data = mysqli_fetch_array($result)): ?>
    <tr>
        <td><?= $data['book_title']; ?></td>
        <td><?= $data['member_lname']; ?></td>
        <td><?= $data['borrow_date']; ?></td>
        <td><?= $data['borrow_librarian_name'] ?: $librarian_name; ?></td>
        <!-- Use the librarian's name fetched from the session if it's not available in the database -->
        <td><?= $data['return_date']; ?></td>
        <td><?= $data['return_librarian_name']; ?></td>
        <td><?= $data['statuss']; ?></td>
        <td>
            <a href="viewcheckout.php?id=<?= $data['checkout_id']; ?>" class="btn btn-pink">Read More</a>
            <a href="editcheckout.php?id=<?= $data['checkout_id']; ?>" class="btn btn-warning">Edit</a>
        </td>
    </tr>
<?php endwhile; ?>
</tbody>



        </table>

        <nav class="pagination-container">
            <p class="result-count">Showing <?php echo $starting_limit + 1; ?> to <?php echo min($starting_limit + $results_per_page, $total_results); ?> of <?php echo $total_results; ?> results</p>
            <ul class="pagination">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item<?= $i == $page ? ' active' : ''; ?>">
                    <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $i])); ?>"><?= $i; ?></a>
                </li>
                <?php endfor; ?>
            </ul>
        </nav>
       
  <!-- Modal Structure ADD -->
<div class="modal fade" id="addCheckoutModal" tabindex="-1" aria-labelledby="addCheckoutModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCheckoutModalLabel">Add New Checkout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="processcheckout.php" method="post">
                    <div class="form-element my-4">
                    <input type="text" id="book-title-input" name="book_title" class="form-control" placeholder="Type to search book title...">
<div id="book-title-list"></div>

                    <div class="form-element my-4">
                    <input type="text" id="member-name-input" name="member_name" class="form-control" placeholder="Type to search member name...">
                    <div id="member-name-list"></div>
                    </div>
                    <div class="form-group my-4">
                        <input type="text" class="form-control" name="borrow_date" id="borrow_date" placeholder="Borrow Date:" required>
                    </div>
                   
                    <input type="hidden" name="borrow_librarian_id" value="<?php echo $_SESSION['librarian_id']; ?>">
                    <div class="form-group my-4">
                        <label for="statuss">Status:</label>
                        <select class="form-control" name="statuss" id="statuss">
                            <option value="Borrowed">Borrowed</option>
                        </select>
                    </div>
                    <div class="form-element my-4">
                        <input type="submit" name="create" value="Add Transaction" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Initialize Datepicker -->
<script>
$(document).ready(function(){
    $('#borrow_date').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true
    });
});
</script>

<script>
document.getElementById("book-title-input").addEventListener("input", function() {
    var input = this.value;
    if (input.trim().length === 0) {
        document.getElementById("book-title-list").style.display = "none";
        return;
    }
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            var list = document.getElementById("book-title-list");
            list.innerHTML = this.responseText;
            if (this.responseText.trim() !== "") {
                list.style.display = "block";
            } else {
                list.style.display = "none";
            }
        }
    };
    xmlhttp.open("GET", "autocomplete.php?q=" + input, true);
    xmlhttp.send();
});

document.addEventListener("click", function(e) {
    var list = document.getElementById("book-title-list");
    var input = document.getElementById("book-title-input");
    if (!list.contains(e.target)) {
        list.style.display = "none";
    } else {
        input.value = e.target.textContent;
        list.style.display = "none";
    }
});
</script>

<script>
document.getElementById("member-name-input").addEventListener("input", function() {
    var input = this.value;
    if (input.trim().length === 0) {
        document.getElementById("member-name-list").style.display = "none";
        return;
    }
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            var list = document.getElementById("member-name-list");
            list.innerHTML = this.responseText;
            if (this.responseText.trim() !== "") {
                list.style.display = "block";
            } else {
                list.style.display = "none";
            }
        }
    };
    xmlhttp.open("GET", "autocomplete_member.php?q=" + input, true);
    xmlhttp.send();
});

document.addEventListener("click", function(e) {
    var list = document.getElementById("member-name-list");
    var input = document.getElementById("member-name-input");
    if (!list.contains(e.target)) {
        list.style.display = "none";
    } else {
        input.value = e.target.textContent;
        list.style.display = "none";
    }
});
</script>

</div>
</div>
        </main>

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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
</body>
</html>

