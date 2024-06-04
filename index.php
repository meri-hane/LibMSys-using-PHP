<?php
// Start session
session_start();

// Check if member is logged in
if (!isset($_SESSION['member_id'])) {
    header('Location: login.php');
    exit();
}

// Include database connection
include('members/includes/connection.php');

// Retrieve member's name
$member_id = $_SESSION['member_id'];
$query_member = "SELECT fname, lname FROM members WHERE member_id = '$member_id'";
$result_member = mysqli_query($conn, $query_member);
$row_member = mysqli_fetch_assoc($result_member);
$member_name = $row_member['fname'] . ' ' . $row_member['lname'];

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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,300,400,500,700,900" rel="stylesheet">
    <title>Home</title>

    <!-- Additional CSS Files -->
    <link rel="stylesheet" type="text/css" href="admin/assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="admin/assets/css/font-awesome.css">
    <link rel="stylesheet" href="admin/assets/css/templatemo-softy-pinko.css">

    <style>
        body {
  padding-top: 110px; /* Adjust as needed */
  color: #000; /* Black text */
}
        </style>
</head>
<body>

<?php include 'members/includes/header.php'; ?>

        <?php
        $start_result = $starting_limit + 1;
        $end_result = min($starting_limit + $results_per_page, $total_results);
        ?>
       

  <div class="container my-4">
    <header class="d-flex justify-content-between align-items-center my-4">
        <div class="d-flex">
            <form method="GET" action="index.php" class="me-2">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search for books..." value="<?php echo htmlspecialchars($search_query); ?>">
                    <button type="submit" class="btn btn-pink">Search</button>
                </div>
            </form>   
        </div>
    </header>

    <?php
    $start_result = $starting_limit + 1;
    $end_result = min($starting_limit + $results_per_page, $total_results);
    ?>
    
    <table class="table table-bordered table-girly"> <!-- Added girly table styling -->
      <colgroup>
    <col style="width: 35%;">
    <col style="width: 20%;">
    <col style="width: 25%;">
    <col style="width: 20%;">
</colgroup>
        <thead>
            <tr>
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
                <td><?php echo $data['title']; ?></td>
                <td><?php echo $data['author']; ?></td>
                <td><?php echo substr($data['isbn'], 0, 15); ?></td> <!-- Limiting to 15 characters -->
                <td>
                    <a href="viewbook.php?id=<?php echo $data['book_id']; ?>" class="btn btn-pink">Read More</a> <!-- Changed to light pink button -->
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
    
   
            </div>
</body>
</html>
