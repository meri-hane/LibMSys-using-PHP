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
$sql = "SELECT COUNT(book_id) AS total FROM books";
if ($search_query != '') {
    $sql .= " WHERE title LIKE '%$search_query%' OR author LIKE '%$search_query%' OR isbn LIKE '%$search_query%'";
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
$sql = "SELECT * FROM books";
if ($search_query != '') {
    $sql .= " WHERE title LIKE '%$search_query%' OR author LIKE '%$search_query%' OR isbn LIKE '%$search_query%'";
}
$sql .= " ORDER BY $sort_field $sort_order LIMIT $starting_limit, $results_per_page";
$result = mysqli_query($conn, $sql);
?>

<?php include 'includes/header.php'; ?>
<body>
    <?php include 'includes/navbar.php'; ?>
    
    <div class="container my-4">
        <header class="d-flex justify-content-between align-items-center my-4">
            <h1>Book List</h1>
            <div class="d-flex">
                <form method="GET" action="book.php" class="me-2">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search for books..." value="<?php echo htmlspecialchars($search_query); ?>">
                        <button type="submit" class="btn btn-pink">Search</button>
                    </div>
                </form>
                <button type="button" class="btn btn-pink" data-bs-toggle="modal" data-bs-target="#addBookModal">Add New Book</button> <!-- Changed to light pink button -->
            </div>
        </header>

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

        <table class="table table-bordered table-girly"> <!-- Added girly table styling -->
            <thead>
                <tr>
                    <th><a href="?<?php echo http_build_query(array_merge($_GET, ['sort_field' => 'book_id', 'sort_order' => ($sort_field == 'book_id' && $sort_order == 'ASC') ? 'DESC' : 'ASC'])); ?>" class="sort-link">ID<?php echo $sort_field == 'book_id' ? ($sort_order == 'ASC' ? ' <i class="fa fa-arrow-up sort-icon"></i>' : ' <i class="fa fa-arrow-down sort-down sort-icon"></i>') : ''; ?></a></th>
                    <th><a href="?<?php echo http_build_query(array_merge($_GET, ['sort_field' => 'title', 'sort_order' => ($sort_field == 'title' && $sort_order == 'ASC') ? 'DESC' : 'ASC'])); ?>" class="sort-link">Title<?php echo $sort_field == 'title' ? ($sort_order == 'ASC' ? ' <i class="fa fa-arrow-up sort-icon"></i>' : ' <i class="fa fa-arrow-down sort-icon"></i>') : ''; ?></a></th>
                    <th><a href="?<?php echo http_build_query(array_merge($_GET, ['sort_field' => 'author', 'sort_order' => ($sort_field == 'author' && $sort_order == 'ASC') ? 'DESC' : 'ASC'])); ?>" class="sort-link">Author<?php echo $sort_field == 'author' ? ($sort_order == 'ASC' ? ' <i class="fa fa-arrow-up sort-icon"></i>' : ' <i class="fa fa-arrow-down sort-icon"></i>') : ''; ?></a></th>
                    <th><a href="?<?php echo http_build_query(array_merge($_GET, ['sort_field' => 'isbn', 'sort_order' => ($sort_field == 'isbn' && $sort_order == 'ASC') ? 'DESC' : 'ASC'])); ?>" class="sort-link">ISBN<?php echo $sort_field == 'isbn' ? ($sort_order == 'ASC' ? ' <i class="fa fa-arrow-up sort-icon"></i>' : ' <i class="fa fa-arrow-down sort-icon"></i>') : ''; ?></a></th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            while($data = mysqli_fetch_array($result)){
                ?>
                <tr>
                    <td><?php echo $data['book_id']; ?></td>
                    <td><?php echo $data['title']; ?></td>
                    <td><?php echo $data['author']; ?></td>
                    <td><?php echo substr($data['isbn'], 0, 15); ?></td> <!-- Limiting to 15 characters -->
                    <td>
                        <a href="viewbook.php?id=<?php echo $data['book_id']; ?>" class="btn btn-pink">Read More</a> <!-- Changed to light pink button -->
                        <a href="editbook.php?id=<?php echo $data['book_id']; ?>" class="btn btn-warning">Edit</a>
                        <a href="deletebook.php?id=<?php echo $data['book_id']; ?>" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>

        <nav class="pagination-container">
        <p class="result-count">Showing <?php echo $start_result; ?> to <?php echo $end_result; ?> of <?php echo $total_results; ?> results</p>
            <ul class="pagination">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item<?php if ($i == $page) echo ' active'; ?>">
                    <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, ['page' => $i])); ?>"><?php echo $i; ?></a>
                </li>
                <?php endfor; ?>
            </ul>
        </nav>
        
        <!-- Modal Structure ADD -->
        <div class="modal fade" id="addBookModal" tabindex="-1" aria-labelledby="addBookModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addBookModalLabel">Add New Book</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="processbook.php" method="post">
                            <div class="form-elemnt my-4">
                                <input type="text" class="form-control" name="title" placeholder="Book Title:" required>
                            </div>
                            <div class="form-elemnt my-4">
                                <input type="text" class="form-control" name="author" placeholder="Author Name:" required>
                            </div>
                            <div class="form-elemnt my-4">
                                <input type="text" class="form-control" name="isbn" placeholder="ISBN:" required>
                            </div>
                            <div class="form-element my-4">
                                <textarea name="description" class="form-control" placeholder="Book Description:" required></textarea>
                            </div>
                            <div class="form-element my-4">
                                <input type="submit" name="create" value="Add Book" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <?php include 'includes/scripts.php'; ?>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.2.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
