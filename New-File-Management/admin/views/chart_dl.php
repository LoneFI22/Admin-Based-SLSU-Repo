<?php
include '../admin_class.php';

$action = new Admin();

$data = $action->dlChart();

// Output the data as JSON
header('Content-Type: application/json');
echo json_encode($data);

?>