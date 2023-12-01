<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Logs</title>
    <?php include 'header.php'; ?>
    <style>
        .backgr{
            background: linear-gradient(289deg, #bdc4ef, #e6c9c9);
        }
        .table-responsive {
            overflow: auto;
            max-height: 400px; /* Adjust the maximum height as needed */
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <?php include 'topbar.php';?>
        <?php include 'sidebar.php';?>
        <div class="backgr content-wrapper">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive container mt-5">
                                <h2>All Logs</h2>
                                <table class="table table-head-fixed text-nowrap mt-3">
                                    <thead>
                                        <tr>
                                            <th>Activity Logs</th>
                                            <th>User</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        include 'admin_class.php';
                    
                                        $action = new Admin();
                                        $logs = $action->getAllLogs();
                                        foreach($logs as $data){?>
                                            <tr>
                                                <td><?= $data['logs'] ?></td>
                                                <td><?= $data['status'] ?></td>
                                                <td><?= date("F j, Y g:i A", strtotime($data['date']))?></td>
                                            </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include 'footer.php'; ?>
    </div>
</body>
</html>