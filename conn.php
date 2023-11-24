<?php
$servername = 'localhost';
$name = 'root';
$pass = '';
$dbname = 'slsu_repo_db';

$conn = new mysqli($servername,$name,$pass,$dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>