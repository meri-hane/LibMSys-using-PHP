<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>Edit Member</title>
</head>
<body>
    <div class="container my-5">
        <header class="d-flex justify-content-between my-4">
            <h1>Edit Member</h1>
            <div>
                <a href="member1.php" class="btn btn-primary">Back</a>
            </div>
        </header>
        <form action="processmember.php" method="post">
            <?php 
            include('includes/connect.php');
            if (isset($_GET['id'])) {
                $member_id = $_GET['id'];
                $sql = "SELECT * FROM members WHERE member_id=$member_id";
                $result = mysqli_query($conn,$sql);
                $row = mysqli_fetch_array($result);
                ?>
                <div class="form-element my-4">
                    <input type="text" class="form-control" name="fname" placeholder="First Name: " value="<?php echo $row["fname"]; ?>">
                </div>
                <div class="form-element my-4">
                    <input type="text" class="form-control" name="lname" placeholder="Last Name: " value="<?php echo $row["lname"]; ?>">
                </div>
                <div class="form-group my-4">
                <label for="membership_type">Membership Type</label>
                <select class="form-control" name="membership_type" id="membership_type" required>
                         <option value="Student" <?php if($row['membership_type'] == 'Student') echo 'selected'; ?>>Student</option>
                         <option value="Faculty" <?php if($row['membership_type'] == 'Faculty') echo 'selected'; ?>>Faculty</option>
                         <option value="Alumni" <?php if($row['membership_type'] == 'Alumni') echo 'selected'; ?>>Alumni</option>
                </select>
            </div>
        
                <input type="hidden" value="<?php echo $member_id; ?>" name="member_id">
                <div class="form-element my-4">
                    <input type="submit" name="edit" value="Edit Member" class="btn btn-primary">
                </div>
            <?php
            } else {
                echo "<h3>Member Does Not Exist</h3>";
            }
            ?>
        </form>
    </div>
</body>
</html>
