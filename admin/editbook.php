<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>Edit Book</title>
</head>
<body>
    <div class="container my-5">
        <header class="d-flex justify-content-between my-4">
            <h1>Edit Book</h1>
            <div>
                <a href="book1.php" class="btn btn-primary">Back</a>
            </div>
        </header>
        <form action="processbook.php" method="post">
            <?php 
            include('includes/connect.php');
            if (isset($_GET['id'])) {
                $book_id = $_GET['id'];
                $sql = "SELECT * FROM books WHERE book_id=$book_id";
                $result = mysqli_query($conn,$sql);
                $row = mysqli_fetch_array($result);
                ?>
                <div class="form-element my-4">
                    <input type="text" class="form-control" name="title" placeholder="Book Title:" value="<?php echo $row["title"]; ?>">
                </div>
                <div class="form-element my-4">
                    <input type="text" class="form-control" name="author" placeholder="Author Name:" value="<?php echo $row["author"]; ?>">
                </div>
                <div class="form-element my-4">
                    <input type="text" class="form-control" name="isbn" placeholder="ISBN: ">
                </div>
                <div class="form-element my-4">
                    <textarea name="description" id="" class="form-control" placeholder="Book Description:"><?php echo $row["description"]; ?></textarea>
                </div>
                <input type="hidden" value="<?php echo $book_id; ?>" name="book_id">
                <div class="form-element my-4">
                    <input type="submit" name="edit" value="Edit Book" class="btn btn-primary">
                </div>
            <?php
            } else {
                echo "<h3>Book Does Not Exist</h3>";
            }
            ?>
        </form>
    </div>
</body>
</html>
