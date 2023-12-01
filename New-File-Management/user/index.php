<?php
session_start();
include 'user_class.php';

if(!$_SESSION['user_id']){
    header('location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User | Dashboard</title>
    <?php include 'header.php';?>
</head>
<body>
    <?php include 'views/sidebar.php';?>
    <div class="content">
        <?php include 'views/navbar.php';?>
        <?php include 'views/main.php';?>
    </div>
    <script src="../assets/plugins/js/script.js"></script>
</body>
</html>