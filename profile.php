
<?php
include 'conn.php';
session_start();

if(!isset($_SESSION['user_id'])){
    header('location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$qry = $conn->query("SELECT * FROM info INNER JOIN profile ON profile.user_id = info.id WHERE info.id_num = '$user_id'");
if($qry){
    $row = $qry->fetch_assoc();
    
    $name = $row['name'];
    $idnum = $row['id_num'];
    $phoneNumber = $row['phoneNumber'];
    $email = $row['email'];
    $status = $row['status'];
    $pass = $row['password'];
    $yearlvl = $row['yr_level'];
    $dept = $row['course'];
    $about = $row['about'];
    $image = $row['image_path']; 
 
    
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <?php include 'header.php';?>
    <!-- Add Bootstrap CDN links here -->
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }

        .wrapper {
            margin: 20px;
        }

        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card {
            margin-bottom: 20px;
        }

        h2 {
            color: #007bff;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
        }

        /* Add the following styles for the profile picture */
        #previewImage {
            width: 200px; /* Set the desired width */
            height: 200px; /* Set the desired height */
            object-fit: cover; /* Maintain aspect ratio and cover the container */
            border-radius: 50%; /* Make the image rounded */
            cursor: pointer; /* Add a pointer cursor for better UX */
        }

        /* Optional: Add a bit of margin to the profile picture */
        .profile-image-container {
            margin-bottom: 20px;
        }
        
    </style>
</head>
<body>
    <div class="wrapper">
        <?php include 'navbar.php';?>
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="profile-image-container">
                                
                                <img src="<?= $image ? $image : 'assets/profile/default.png' ?>" alt="Profile Picture" id="previewImage" class="card-img-top" onclick="triggerFileInput()">
                            </div>
                            <form action="upload_profile_picture.php" method="post" enctype="multipart/form-data" class="mt-3">
                                <div class="form-group">
                                    <input type="file" name="profile_picture" id="fileInput" accept="image/*" style="display: none" onchange="displayImage()">
                                </div>
                                <button type="submit" class="btn btn-primary">Upload Picture</button>
                            </form>
                            
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6">
                            <h2>Status</h2>
                            <p><?= $status ?></p>
                            <h2>Personal Information</h2>
                            <ul>
                                <li><strong>Name:</strong> <?= $name?></li>
                                <li><strong>ID_Number:</strong> <?= $idnum?></li>
                                <li><strong>Email:</strong> <?= $email?></li>
                                <p><strong>Password:</strong> <span><?= str_repeat('*', strlen($pass)) ?></span></p>
                                <li><strong>Phone:</strong> <?= $phoneNumber?></li>
                                <li><strong>Year Level:</strong> <?= $yearlvl?></li>
                                <li><strong>Department:</strong> <?= $dept?></li>
                                <a href="edit_profile.php" class="btn btn-info mt-3">Edit Information</a>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h2>About Me</h2>
                            <li><?=$about?> </li>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function triggerFileInput() {
            document.getElementById('fileInput').click();
        }

        function displayImage() {
            const fileInput = document.getElementById('fileInput');
            const previewImage = document.getElementById('previewImage');

            // Display the selected image on the profile picture preview
            if (fileInput.files && fileInput.files[0]) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    previewImage.src = e.target.result;
                };

                reader.readAsDataURL(fileInput.files[0]);
            }
        }
    </script>
   
</body>
</html>
