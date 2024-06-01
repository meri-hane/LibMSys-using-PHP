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
$sql = "SELECT * FROM checkouts";
if ($search_query != '') {
    $sql .= " WHERE book_id LIKE '%$search_query%' OR member_id LIKE '%$search_query%' OR borrow_date LIKE '%$search_query%' OR return_date LIKE '%$search_query%' OR statuss LIKE '%$search_query%'";
}
$sql .= " ORDER BY $sort_field $sort_order LIMIT $starting_limit, $results_per_page";
$result = mysqli_query($conn, $sql);
?>

<?php include 'includes/header.php'; ?>
<body>
<?php include 'includes/navbar.php'; ?>
    
    <div class="container my-4">
        <header class="d-flex justify-content-between align-items-center my-4">
            <h1>Transaction List</h1>
            <div class="d-flex">
                <form method="GET" action="checkout.php" class="me-2">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search for books..." value="<?php echo htmlspecialchars($search_query); ?>">
                        <button type="submit" class="btn btn-pink">Search</button>
                    </div>
                </form>
                <button type="button" class="btn btn-pink" data-bs-toggle="modal" data-bs-target="#addCheckoutModal">Add New Transaction</button> <!-- Changed to light pink button -->
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
        <?php if (isset($_SESSION["delete"])): ?>
            <div class="alert alert-success">
                <?= $_SESSION["delete"] ?>
            </div>
        <?php unset($_SESSION["delete"]); endif; ?>
        
        <table class="table table-bordered table-girly">
            <thead>
                <tr>
                    <th><a href="?<?= http_build_query(array_merge($_GET, ['sort_field' => 'checkout_id', 'sort_order' => ($sort_field == 'checkout_id' && $sort_order == 'ASC') ? 'DESC' : 'ASC'])); ?>" class="sort-link">ID<?php echo $sort_field == 'checkout_id' ? ($sort_order == 'ASC' ? ' <i class="fa fa-arrow-up sort-icon"></i>' : ' <i class="fa fa-arrow-down sort-icon"></i>') : ''; ?></a></th>
                    <th><a href="?<?= http_build_query(array_merge($_GET, ['sort_field' => 'book_id', 'sort_order' => ($sort_field == 'book_id' && $sort_order == 'ASC') ? 'DESC' : 'ASC'])); ?>" class="sort-link">Book ID<?php echo $sort_field == 'book_id' ? ($sort_order == 'ASC' ? ' <i class="fa fa-arrow-up sort-icon"></i>' : ' <i class="fa fa-arrow-down sort-icon"></i>') : ''; ?></a></th>
                    <th><a href="?<?= http_build_query(array_merge($_GET, ['sort_field' => 'member_id', 'sort_order' => ($sort_field == 'member_id' && $sort_order == 'ASC') ? 'DESC' : 'ASC'])); ?>" class="sort-link">Member ID<?php echo $sort_field == 'member_id' ? ($sort_order == 'ASC' ? ' <i class="fa fa-arrow-up sort-icon"></i>' : ' <i class="fa fa-arrow-down sort-icon"></i>') : ''; ?></a></th>
                    <th><a href="?<?= http_build_query(array_merge($_GET, ['sort_field' => 'borrow_date', 'sort_order' => ($sort_field == 'borrow_date' && $sort_order == 'ASC') ? 'DESC' : 'ASC'])); ?>" class="sort-link">Date Borrow<?php echo $sort_field == 'borrow_date' ? ($sort_order == 'ASC' ? ' <i class="fa fa-arrow-up sort-icon"></i>' : ' <i class="fa fa-arrow-down sort-icon"></i>') : ''; ?></a></th>
                    <th><a href="?<?= http_build_query(array_merge($_GET, ['sort_field' => 'return_date', 'sort_order' => ($sort_field == 'return_date' && $sort_order == 'ASC') ? 'DESC' : 'ASC'])); ?>" class="sort-link">Date Return<?php echo $sort_field == 'return_date' ? ($sort_order == 'ASC' ? ' <i class="fa fa-arrow-up sort-icon"></i>' : ' <i class="fa fa-arrow-down sort-icon"></i>') : ''; ?></a></th>
                    <th><a href="?<?= http_build_query(array_merge($_GET, ['sort_field' => 'statuss', 'sort_order' => ($sort_field == 'statuss' && $sort_order == 'ASC') ? 'DESC' : 'ASC'])); ?>" class="sort-link">Status<?php echo $sort_field == 'statuss' ? ($sort_order == 'ASC' ? ' <i class="fa fa-arrow-up sort-icon"></i>' : ' <i class="fa fa-arrow-down sort-icon"></i>') : ''; ?></a></th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php while($data = mysqli_fetch_array($result)): ?>
                <tr>
                    <td><?= $data['checkout_id']; ?></td> <!-- Display checkout ID -->
                    <td><?= $data['book_id']; ?></td>
                    <td><?= $data['member_id']; ?></td> <!-- Display member ID -->
                    <td><?= $data['borrow_date']; ?></td>
                    <td><?= $data['return_date']; ?></td>
                    <td><?= $data['statuss']; ?></td>
                    <td>
                        <a href="viewcheckout.php?id=<?= $data['checkout_id']; ?>" class="btn btn-pink">Read More</a>
                        <a href="editcheckout.php?id=<?= $data['checkout_id']; ?>" class="btn btn-warning">Edit</a>
                        <a href="deletecheckout.php?id=<?= $data['checkout_id']; ?>" class="btn btn-danger">Delete</a>
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
                            <div class="form-elemnt my-4">
                            <input type="text" class="form-control" name="book_id" placeholder="Book ID:" required>
                            </div>
                            <div class="form-elemnt my-4">
                            <input type="text" class="form-control" name="member_id" placeholder="Member ID:" required>
                            </div>
                        
                            <div class="form-group my-4">
                <input type="text" class="form-control" name="borrow_date" id="borrow_date" placeholder="Borrow Date:">
            </div>
            <div class="form-group my-4">
                <input type="text" class="form-control" name="return_date" id="return_date" placeholder="Return Date:" >
            </div>
            <div class="form-group my-4">
                <label for="statuss">Status:</label>
                <select class="form-control" name="statuss" id="statuss">
                    <option value="Borrowed">Borrowed</option>
                    <option value="Returned">Returned</option>
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
    </div>

    <?php include 'includes/scripts.php'; ?>
</body>
</html>


