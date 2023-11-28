<?php
include 'conn.php';
session_start();

$user_id = $_SESSION['user_id'];
$qry = $conn->query("SELECT * FROM info INNER JOIN profile ON profile.user_id = info.id WHERE info.id_num = '$user_id'");
if($qry){
    $row = $qry->fetch_assoc();
    
    $name = $row['name'];
    $phoneNumber = $row['phoneNumber'];
    $email = $row['email'];
    $pass = $row['password'];
    $yearlvl = $row['yr_level'];
    $dept = $row['course'];
    $id = $row['user_id'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process the form submission here
    // You can update the database with the new information
    // For example:
    $newName = $_POST['new_name'];
    $newPhoneNumber = $_POST['new_phone'];
    $newEmail = $_POST['new_email'];
    $newPassword = $_POST['new_password'];
    $newYearlvl = $_POST['new_yearlvl'];
    $newDepartment = $_POST['new_department'];
  

    // Update the database with the new information
    $updateQuery = "UPDATE info SET name='$newName', phoneNumber='$newPhoneNumber', email='$newEmail', password='$newPassword' WHERE id_num='$user_id'";
    $conn->query($updateQuery);
    $qry = $conn->query("UPDATE profile SET yr_level='$newYearlvl', course='$newDepartment' WHERE user_id='$id'");

    // Redirect to the profile page after the update
    header("Location: profile.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<style>
       <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
           
        }

        h2 {
            color: #007bff;
        }

        form {
            max-width: 600px;
            margin: auto;
        }

        .form-group {
            margin-bottom: 10px;
        }

        label {
            font-weight: bold;
        }

        button {
            background-color: #007bff;
            color: #ffffff;
        }

        .btn-secondary {
            margin-left: 10px;
        }

        /* Adjustments for smaller screens */
        @media (max-width: 768px) {
            form {
                max-width: 100%;
            }
        }
    </style>
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <!-- Add Bootstrap CDN links here -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Personal Information</h2>
        <form method="post" action="">
            <div class="form-group">
                <label for="new_name">Name:</label>
                <input type="text" class="form-control" name="new_name" value="<?= $name ?>">
            </div>
            
            <div class="form-group">
                <label for="new_phone">Phone Number:</label>
                <input type="text" class="form-control" name="new_phone" value="<?= $phoneNumber ?>">
            </div>
            <div class="form-group">
                <label for="new_email">Email:</label>
                <input type="email" class="form-control" name="new_email" value="<?= $email ?>">
            </div>
            <div class="form-group">
                <label for="new_password">Password:</label>
                <input type="text" class="form-control" name="new_password" value="<?= $pass ?>">
            </div>
            <div class="form-group">
                <label for="new_yearlvl">Year Level:</label>
                <input type="text" class="form-control" name="new_yearlvl" value="<?= $yearlvl ?>">
            </div>
            <div class="form-group">
                <label for="new_department">Department:</label>
                <input type="text" class="form-control" name="new_department" value="<?= $dept ?>">
            </div>
         
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="profile.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
