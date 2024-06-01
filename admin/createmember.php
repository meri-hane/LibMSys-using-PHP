<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>Add New Member</title>
</head>
<body>
    <div class="container my-5">
    <header class="d-flex justify-content-between my-4">
            <h1>Add New Member</h1>
            <div>
            <a href="members.php" class="btn btn-primary">Back</a>
            </div>
        </header>
        
        <form action="processmember.php" method="post">
            <div class="form-elemnt my-4">
                <input type="text" class="form-control" name="fname" placeholder="First Name">
            </div>
            <div class="form-elemnt my-4">
                <input type="text" class="form-control" name="lname" placeholder="Last Name">
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
</body>
</html>