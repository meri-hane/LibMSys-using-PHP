<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>Edit Transaction</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap Bundle JS (includes Popper) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

    <!-- Bootstrap Datepicker CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

    <!-- Bootstrap Datepicker JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <!-- Custom CSS to adjust datepicker size -->
    <style>
        .datepicker {
            font-size: 1.2em;
        }
    </style>
</head>
<body>
<div class="container my-5">
    <header class="d-flex justify-content-between my-4">
        <h1>Edit Transaction</h1>
        <div>
            <a href="transaction.php" class="btn btn-primary">Back</a>
        </div>
    </header>
    <form action="processcheckout.php" method="post">
        <?php 
        include("includes/connect.php");
        if (isset($_GET['id'])) {
            
            $checkout_id = $_GET['id'];
            $sql = "SELECT * FROM checkouts WHERE checkout_id=$checkout_id";
            $result = mysqli_query($conn, $sql);
            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_array($result);
            ?>
            <div class="form-group my-4">
                <label for="book_id">Book ID:</label>
                <span><?php echo $row['book_id']; ?></span>
            </div>
            <div class="form-group my-4">
                <label for="member_id">Member ID:</label>
                <span><?php echo $row['member_id']; ?></span>
            </div>
            <div class="form-group my-4">
                <label for="borrow_date">Borrow Date:</label>
                <span><?php echo $row['borrow_date']; ?></span>
            </div>
            <div class="form-group my-4">
                <label for="return_date">Return Date:</label>
                <input type="text" class="form-control datepicker" name="return_date" id="return_date" value="<?php echo $row['return_date']; ?>" placeholder="Return Date" required>
            </div>
            <div class="form-group my-4">
                <label for="return_librarian_id">Librarian Received:</label>
                <select class="form-control" name="return_librarian_id" id="return_librarian_id" required>
                    <option value="">Select Librarian</option>
                    <?php
                    $librarian_query = "SELECT librarian_id, name FROM librarians";
                    $librarian_result = mysqli_query($conn, $librarian_query);
                    while ($librarian = mysqli_fetch_assoc($librarian_result)) {
                        $selected = ($librarian['librarian_id'] == $row['return_librarian_id']) ? 'selected' : '';
                        echo "<option value='{$librarian['librarian_id']}' $selected>{$librarian['name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group my-4">
                <label for="statuss">Status:</label>
                <select class="form-control" name="statuss" id="statuss" required>
                    <option value="Returned" <?php if($row['statuss'] == 'Returned') echo 'selected'; ?>>Returned</option>
                </select>
            </div>
            <input type="hidden" value="<?php echo $checkout_id; ?>" name="checkout_id">
            <div class="form-element my-4">
                <input type="submit" name="edit" value="Edit Transaction" class="btn btn-primary">
            </div>
        <?php
            } else {
                echo "<h3>Checkout record does not exist</h3>";
            }
        } else {
            echo "<h3>Checkout ID is not set</h3>";
        }
        ?>
    </form>
</div>


    <!-- Initialize Datepicker -->
    <script>
        $(document).ready(function(){
            $('#borrow_date, #return_date').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true
            });
        });
    </script>
</body>

</html>
