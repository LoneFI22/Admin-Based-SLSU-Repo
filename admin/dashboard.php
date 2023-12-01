<?php
session_start();
include 'admin_class.php';

if(!$_SESSION['admin_id']){
    header('location: login.php');
    exit();
}

$action = new Admin();
$countUser = count($action->getAllUser());

$countFile = count($action->getAllDocument());

$countLike = count($action->totalLikes());

$countDownload = $action->totalDownloads();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <?php include 'header.php'; ?>
    <style>
        .backgr{
            background: linear-gradient(289deg, #bdc4ef, #e6c9c9);
        }
        canvas {
            max-width: 100%;
            height: auto;
            margin: auto;
            display: block;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <?php include 'topbar.php';?>
        <?php include 'sidebar.php';?>

        <div class="backgr content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2 text-center">
                        <div class="col-sm-12">
                            <h1 class="m-0">Dashboard</h1>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-6 col-sm-6 col-md-3">
                            <div class="info-box" style="background: #b4b4ec">
                                <span class="info-box-icon" onclick="window.location.href='user.php'"><i class='far fa-regular fa-user'></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Users</span>
                                    <span class="info-box-number"><?= $countUser ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-sm-6 col-md-3">
                            <div class="info-box bg-warning">
                                <span class="info-box-icon" onclick="window.location.href='repository.php'"><i class='far fa-regular fa-file'></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Files</span>
                                    <span class="info-box-number"><?= $countFile ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-sm-6 col-md-3">
                            <div class="info-box bg-info">
                                <span class="info-box-icon" onclick="window.location.href='repository.php'"><i class='fa fa-regular fa-download'></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Downloads</span>
                                    <span class="info-box-number"><?= $countDownload ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-sm-6 col-md-3">
                            <div class="info-box bg-gradient-success">
                                <span class="info-box-icon" onclick="window.location.href='repository.php'"><i class='far fa-thumbs-up'></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Likes</span>
                                    <span class="info-box-number"><?= $countLike ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-7 mt-2">
                            <div class="card card-dark">
                                <div class="card-header">
                                    <h3 class="card-title">Download Graph</h3>

                                    <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                    <div class="chart">
                                        <canvas id="downloadsChart"></canvas>  
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4 col-md-5 mt-2">
                            <div class="card card-dark">
                                <div class="card-header">
                                    <h3 class='card-title'>Recent Upload</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table class="table table-responsive">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                            </tr>
                                        </thead>
                                        <tbody class="recentUpload">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-12 col-sm-4 col-md-3 mt-2">
                            <div class="card card-dark">
                                <div class="card-header">
                                    <h3 class='card-title'>Recent </h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">

                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
        <?php include 'footer.php';?>
    </div>

    <script>
            function recent_upload(){
            $.ajax({
                type: 'GET',
                url: 'jquery_admin.php',
                data: { recentUpload : 'recent'},
                success: function(response){
                    var loadUpload = JSON.parse(response);
                    var content = '';
                    console.log(response);
                    loadUpload.forEach(function(item){
                        content += '<tr>';
                        content += '<td>' + item.file_name + '</td>';
                        content += '</tr>';
                    });
                    $('.recentUpload').html(content);
                }
            });
        }
        recent_upload();

        function createChart() {
            fetch('chart_dl.php')
                .then(response => response.json())
                .then(data => {
                    const dates = data.map(entry => entry.download_date);
                    const downloads = data.map(entry => entry.total_downloads);

                    const ctx = document.getElementById('downloadsChart').getContext('2d');
                    const myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: dates,
                            datasets: [{
                                label: 'Downloads',
                                data: downloads,
                                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    precision: 0,
                                    ticks: {
                                        stepSize: 1,
                                        precision: 0
                                    }
                                }
                            }
                        }
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function adjustChartSize() {
            const canvas = document.getElementById('downloadsChart');
            const parentWidth = canvas.parentElement.clientWidth;

            canvas.style.height = '200px';
            canvas.style.width = parentWidth + 'px';
        }

        document.addEventListener('DOMContentLoaded', function() {
            createChart();
            adjustChartSize();
        });

        window.addEventListener('resize', adjustChartSize);
    </script>
</body>
</html>
