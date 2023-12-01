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
    <title>Admin | Logs</title>
    <?php include 'header.php';?>
    <style>
        .log-container{
            padding: 3%;
            border-radius: 20px;
            height: 400px;
            overflow: auto;
        }
    </style>
</head>
<body>
    <?php include 'views/sidebar.php';?>
    <div class="content">
        <?php include 'views/navbar.php';?>
        <!-- Main Content -->
        <main>
            <div class="header" style='margin-bottom: 20px;'>
                <div class="left">
                    <h1>Logs</h1>
                </div>
            </div>
            <div class="log-container container grey lighten-5">
                <table class="log-table highlight">
                    <thead>
                        <tr>
                            <th>Logs</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody class="load_body">
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    <script src="../assets/plugins/js/script.js"></script>
    <script>
        $(document).ready(function(){
            function loadAllLogs(){
                $.ajax({
                    type: 'GET',
                    url: 'user_ajax.php',
                    dataType: 'json',
                    data: {loadLogs : 'loadLogs'},
                    success: function(response){
                        var loadLogs = '';
                        response.forEach(function(item){
                            loadLogs += '<tr>';
                            loadLogs += '<td>'+item.logs+'</td>';
                            loadLogs += '<td>'+item.date+'</td>';
                            loadLogs += '</tr>';
                        });
                        $('.load_body').html(loadLogs);
                    }
                });
            }
            loadAllLogs();
        });
    </script>
</body>
</html>