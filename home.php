<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header('location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SLSU Repo | Home</title>
    <?php include 'header.php';?>
    <style>
        .main-content{
            height: auto;
            border: #dfdfdf solid 1px;
            border-radius: 2px;
            background: #ffffff;
        }
        .top-content{
            height: 170px;
            border-radius: 2px;
            background: #ffffff;
        }
        .most-dl-content{
            height: 170px;
            border-radius: 2px;
            background: #ffffff;
        }
        /* .category{
            border-radius: 10px;
            background: #ffffff;
        } */
        .dl-button{
            border: solid 1px;
            border-radius: 5px;
            background: none;
        }
        .dl-button:hover{
            background: #333;
            color: #ffffff;
        }
        .like-normal {
            background: none;
            border: none;
            color: gray;
        }
        .like-normal:hover {
            background: none;
            border: none;
            color: blue;
        }

        .like-liked {
            background: none;
            border: none;
            color: blue;
        }

        .carousel-box{
            width: auto;
        }
        
    </style>
</head>
<body>
    <div class="please-no wrapper">
        <?php include 'navbar.php';?>
        <div class="container mt-5">
            <div class="row">
                <div class="main-content col-12 col-sm-6 col-md-8 mb-3">
                    <div class='card-header'>
                        <h3 class="card-title"><strong>Recent Documents</strong></h3>
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
                    <div class="card-body table-responsive p-0" style='height: 420px'>
                        <table class='table table-thead table-striped'>
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Date</th>
                                    <th>Total Downloads</th>
                                    <th>Total Like</th>
                                    <th>Rating</th>
                                    <th>Thumbs Up</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="row">
                        <div class="col-12">
                            <div class="top-content mb-3">
                                <p class='ps-3 pt-2'><strong>Top Rated Topics</strong></p>
                                <div class="carousel slide" data-bs-ride='carousel' data-bs-interval="8000">
                                    <div id='most-rated' class="card carousel-inner">
                                        <!-- The data are fetch in ajax -->
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#most-rated" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#most-rated" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="most-dl-content mb-3">
                                <p class='ps-3 pt-2'><strong>Most Downloaded</strong></p>
                                <div class="carousel slide" data-bs-ride='carousel' data-bs-interval="8000">
                                    <div id='most-dl' class="card carousel-inner">
                                        <!-- The data are fetch in ajax -->
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#most-dl" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#most-dl" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Add an input event listener to the search input field
            $('#searchFile').on('input', function() {
            const query = $(this).val();

            // Make an AJAX request to a PHP script passing the query as a parameter
                $.ajax({
                    type: 'GET',
                    url: 'search.php',
                    data: { q: query },
                    success: function(data) {
                    // Update the table with the search results
                    $('.table tbody').html(data);
                    }
                });
            });

            //Load the recent file content using ajax
            function loadFile(){
                $.ajax({
                    type: 'GET',
                    url: 'user_ajax.php',
                    data: { loadBody: 'getData'},
                    success: function(response){
                        $('#tableBody').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(status + ': ' + error);
                    }
                });
            }
            loadFile();

            $('#tableBody').on('click','.like-normal',function(){
                const data = $(this).attr('data-id');
                
                $.ajax({
                    type: 'POST',
                    url: 'user_ajax.php',
                    data: { file_id : data},
                    success: function(response){
                        var parsedResponse = JSON.parse(response);
                        $('td.like-count[data-id="'+data+'"]').text(parsedResponse.like_count);
                        if(parsedResponse.bool_like == true){
                            $('button.like-normal[data-id="'+data+'"]').addClass('like-liked');
                        }else{
                            $('button.like-normal[data-id="'+data+'"]').removeClass('like-liked');
                        }
                    }
                    
                });
            });

            //lod the top rated file content
            function loadTopRatedFile(){
                $.ajax({
                    type: 'GET',
                    url: 'user_ajax.php',
                    data: {mostRate : 'getRate'},
                    dataType: 'json',
                    success: function(response){
                        var topRateFile = '';
                        response.forEach(function(item, index){
                            if(index === 0){ // Check if it's the first item
                                topRateFile += '<div class="carousel-item active">';
                                topRateFile += '<div class="d-flex flex-column justify-content-around align-items-center container-sm border rated-content">';
                                topRateFile += '<h5 class="fontStyle">'+ item.file_name + '</h5>'; 
                                topRateFile += '<span><span style="color: gold;"><i class="fa fa-regular fa-star"></i></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+ item.avg_rating + '</span>'; 
                                topRateFile += '</div>';
                                topRateFile += '</div>';
                            } else {
                                topRateFile += '<div class="carousel-item">';
                                topRateFile += '<div class="d-flex flex-column justify-content-around align-items-center container-sm border rated-content">';
                                topRateFile += '<h5>'+ item.file_name + '</h5>'; 
                                topRateFile += '<span><span style="color: gold;"><i class="fa fa-regular fa-star"></i></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+ item.avg_rating + '</span>'; 
                                topRateFile += '</div>';
                                topRateFile += '</div>';
                            }
                        });
                        $('#most-rated').html(topRateFile);
                    }
                });
            }
            loadTopRatedFile();
            
            //load the top download file content
            function loadTopDLFile(){
                $.ajax({
                    type: 'GET',
                    url: 'user_ajax.php',
                    data: {mostDl : 'getDl'},
                    dataType: 'json',
                    success: function(response){
                        var topFileDl = '';
                        response.forEach(function(item, index){
                            if(index === 0){ // Check if it's the first item
                                topFileDl += '<div class="carousel-item text-center active">';
                                topFileDl += '<div class="d-flex flex-column justify-content-around align-items-center container-sm border rated-content">';
                                topFileDl += '<h5>'+ item.file_name + '</h5>'; 
                                topFileDl += '<span><span style="color: blue;"><i class="fa fa-regular fa-download"></i></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+ item.download_count + '</span>'; 
                                topFileDl += '</div>';
                                topFileDl += '</div>';
                            } else {
                                topFileDl += '<div class="carousel-item text-center">';
                                topFileDl += '<div class="d-flex flex-column justify-content-around align-items-center container-sm border rated-content">';
                                topFileDl += '<h5>'+ item.file_name + '</h5>'; 
                                topFileDl += '<span><span style="color: blue;"><i class="fa fa-regular fa-download"></i></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+ item.download_count + '</span>'; 
                                topFileDl += '</div>';
                                topFileDl += '</div>';
                            }
                        });
                        $('#most-dl').html(topFileDl);
                    }
                });
            }
            loadTopDLFile();
        });
    </script>
</body>
</html>