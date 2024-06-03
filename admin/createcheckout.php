<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <title>Checkout Book</title>
</head>
<body>
    <div class="container my-5">
        <header class="d-flex justify-content-between my-4">
            <h1>Checkout Book</h1>
            <div>
                <a href="transaction.php" class="btn btn-primary">Back</a>
            </div>
        </header>
        
        <form action="processcheckout.php" method="post">
            <div class="form-group my-4">
                <input type="text" class="form-control" name="book_id" placeholder="Book ID:">
            </div>
            <div class="form-group my-4">
                <input type="text" class="form-control" name="member_id" placeholder="Member ID:">
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
                <input type="submit" name="create" value="Add Transaction" class="btn btn-primary">
            </div>
        </form>
    </div>

    <?php include 'includes/scripts.php'; ?>
</body>
</html>
