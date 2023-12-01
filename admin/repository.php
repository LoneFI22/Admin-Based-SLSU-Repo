<?php
session_start();
if(!isset($_SESSION['admin_id'])){
    header('location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Repository</title>
    <?php include 'header.php'; ?>
    <style>
        .backgr{
            background: linear-gradient(289deg, #bdc4ef, #e6c9c9);
        }
        .like{
            border: none;
            background: none;
            color: gray;
        }
        .like:hover {
            border: none;
            background: none;
            color: blue;
        }
        .like-liked{
            border: none;
            background: none;
            color: blue;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <?php include 'topbar.php';?>
        <?php include 'sidebar.php';?>
        <!-- Main Content of Repository -->
        <div class="backgr content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2 text-center">
                        <div class="col-sm-12">
                            <h1 class="m-0">
                                File Repository
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <!-- Main content -->
            <div class="content">
                <div class="container">
                    <button class="mb-3 btn bg-primary btn-sm align-items-center" onclick="window.location.href='upload.php'">
                    <span class="info-box-text">Upload File</span>
                    </button>
                    <div class="row">
                    
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">File Table</h3>

                                    <div class="card-tools">
                                        <div class="input-group input-group-sm" style="width: 150px;">
                                            <input type="text" name="table_search" id='searchFile' class="form-control float-right" placeholder="Search">

                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-default">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    <!-- /.card-header -->
                                <div class="card-body table-responsive p-0" style="height: 300px;">
                                    <table id='repotable' class="table table-head-fixed text-nowrap">
                                        <thead>
                                            <tr>
                                            <th>File Name</th>
                                            <th>File Type</th>
                                            <th>Downloads</th>
                                            <th>Total Likes</th>
                                            <th>Rating</th>
                                            <th>Date Uploaded</th>
                                            <th>Like</th>
                                            <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            include 'admin_class.php';
                                            $getData = new Admin();
                                            $data = $getData->getAllDocument();

                                            foreach($data as $fileData){
                                            ?>
                                                <tr>
                                                <td name-id="<?= $fileData['file_name']?>"><?= $fileData['file_name']?></td>
                                                <td><?= $fileData['file_type']?></td>
                                                <td class='download-count' data-id="<?= $fileData['id']?>"><?= $fileData['download_count']?></td>
                                                <td class="like-count" data-id="<?= $fileData['id']?>"><?= $getData->countLike($fileData['id'])?></td>
                                                <td><?= $getData->getRate($fileData['id']) ?></td>
                                                <td><?= date("F j, Y g:i A", strtotime($fileData['date']))?></td>
                                                <td><?php if($getData->getLikeVal($fileData['id']) == true){?>
                                                        <button class="like like-liked" data-id="<?= $fileData['id']?>"><i class="fa fa-regular fa-thumbs-up"></i></button>
                                                    <?php }else{?>
                                                        <button class="like" data-id="<?= $fileData['id']?>"><i class="fa fa-regular fa-thumbs-up"></i></button>
                                                    <?php }?>
                                                </td>
                                                <td>
                                                    <button class="download-btn btn btn-primary btn-sm" onclick="window.location.href='download.php?file=<?= $fileData['id'] ?>'">Download</button>
                                                    <button class="delete-btn btn btn-danger btn-sm" data-id="<?= $fileData['id']?>">Delete</button>
                                                </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                 <!-- /.card-body -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include 'footer.php';?>
    </div>

    <script>
        // $(function () {
        //     $("#repotable").DataTable({
        //     "responsive": true, "lengthChange": false, "autoWidth": false,
        //     }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        // });
        $(document).ready(function() {
            // Add an input event listener to the search input field
            $('#searchFile').on('input', function() {
            const query = $(this).val();

            // Make an AJAX request to a PHP script passing the query as a parameter
                $.ajax({
                    type: 'GET',
                    url: 'search.php',
                    data: { file: query },
                    success: function(data) {
                    // Update the table with the search results
                    $('.table tbody').html(data);
                    }
                });
            });

            $('.like').click(function(){
                const data = $(this).attr('data-id');
                
                $.ajax({
                    type: 'POST',
                    url: 'like.php',
                    data: { id : data},
                    success: function(response){
                        var parsedResponse = JSON.parse(response);
                        $('td.like-count[data-id="'+data+'"]').text(parsedResponse.like_count);
                        if(parsedResponse.bool_like == true){
                            $('button.like[data-id="'+data+'"]').addClass('like-liked');
                        }else{
                            $('button.like[data-id="'+data+'"]').removeClass('like-liked');
                        }
                    }
                    
                });
            });
            
            $('.delete-btn').click(function(){
                const data = $(this).attr('data-id');

                if(confirm('Are you sure you want to delete?')){
                    $.ajax({
                        type: 'GET',
                        url: 'jquery_admin.php',
                        data: { delete_file_id : data},
                        success: function(response){
                            if(response){
                                alert('Delete Successfully!!');
                            }
                            setTimeout(function(){
                            location.reload(); // Reload the page after a delay
                            }, 1000);

                        }
                    });
                }else{
                    console.log('Canceling Response of File ID Num '+data+'')
                }
            });
        });
    </script>
</body>
</html>