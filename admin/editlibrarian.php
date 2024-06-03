<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>Edit Librarian</title>
</head>
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
                <li class="breadcrumb-item active">Edit Librarian</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <div class="container my-5">
        <header class="d-flex justify-content-between my-4">
            <h1>Edit Librarian</h1>
            <div>
                <a href="librarian.php" class="btn btn-pink">Back</a>
            </div>
        </header>
        <?php
        session_start();
        // Display session messages
        if (isset($_SESSION["error"])) {
            echo '<div class="alert alert-danger">' . $_SESSION["error"] . '</div>';
            unset($_SESSION["error"]);
        }
        if (isset($_SESSION["update"])) {
            echo '<div class="alert alert-success">' . $_SESSION["update"] . '</div>';
            unset($_SESSION["update"]);
        }
        ?>
        <form action="processlibrarian.php" method="post">
            <?php
            include('includes/connect.php');
            if (isset($_GET['id'])) {
                $librarian_id = $_GET['id'];
                $sql = "SELECT * FROM librarians WHERE librarian_id=$librarian_id";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                ?>
                <div class="form-element my-4">
                    <input type="text" class="form-control" name="name" placeholder="Librarian Name" value="<?php echo $row["name"]; ?>">
                </div>
                <input type="hidden" value="<?php echo $librarian_id; ?>" name="librarian_id">
                <div class="form-element my-4">
                    <input type="submit" name="edit" value="Edit Librarian" class="btn btn-pink">
                </div>
                <?php
            } else {
                echo "<h3>Librarian Does Not Exist</h3>";
            }
            ?>
        </form>
    </div>
</main>
</body>
</html>
