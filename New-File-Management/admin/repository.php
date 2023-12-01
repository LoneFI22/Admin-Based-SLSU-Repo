<?php
session_start();
include 'admin_class.php';

if(!$_SESSION['admin_id']){
    header('location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Repository</title>
    <?php include 'header.php';?>
    <style>
        .adduser{
            font-size: 50px; 
            border-radius: 50%;
            color: #d1b799;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            cursor: pointer;
        }
        .adduser:hover{
            opacity: 0.8;
        }
        .adduser:active{
            opacity: 0.4;
        }
        .mycontainer{
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .search-box {
            width: 300px;
            height: 50px;
            display: flex;
            align-items: center;
            border: 1px solid #ccc;
            border-radius: 20px;
            padding: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .search-box input[type="text"] {
            border-radius: 8px;
            border: none;
            outline: none;
            flex: 1;
            padding: 8px;
        }
        .profile_fit{
            object-fit: cover;
            border-radius: 50%;
        }

        .search-box button {
            border: none;
            background-color: #007bff;
            color: white;
            padding: 8px 16px;
            border-radius: 20px 8px 20px 8px;
            cursor: pointer;
        }
        .delete_icon{
            cursor: pointer;
        }
        .like_icon{
            cursor: pointer;
        }
        .borderpage{
            border-radius: 25px;
        }
    </style>
</head>
<body>
    <?php include 'views/sidebar.php';?>
    <div class="content">
        <?php include 'views/navbar.php';?>
        <!-- Main Content -->
        <main>
            <div class="header">
                <div class="left">
                    <h1>Repository</h1>
                </div>
            </div>
            <div class="">
                <div class="row">
                    <div class="col s12 m8" style="padding: 10px;">
                        <div style="display: flex; align-items: center;">
                            <label for="adduser">
                                <span class="icon-container"><i class="adduser bx bxs-plus-circle"></i></span>&nbsp;&nbsp;
                            </label>
                            <form id="fileUploadForm" method="post" enctype="multipart/form-data">
                                <input type="file" name="fileDoc" id="adduser" accept=".doc, .docx, .pdf" style="display: none;">
                                <button class="waves-effect waves-light btn" type="submit">Upload</button>
                            </form>
                        </div>
                    </div>
                    <div class="col s12 m4" style="padding: 10px;">
                        <div class="search-box">
                            <input type="text" id="searchInput" placeholder="Search...">
                            <button type="submit"><i class='bx bx-search'></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <ul style="margin-top: 10px;">
                <div class="collapsible load_file row white" style="padding: 10px; border-radius: 20px;">

                </div>
            </ul>
            <?php include 'views/footer.php';?>
        </main>
    </div>
    <script src="../assets/plugins/js/script.js"></script>
    <script>
        $(document).ready(function(){
            function loadFile(){
                $.ajax({
                    type: 'GET',
                    url: 'admin_ajax.php',
                    dataType: 'json',
                    data: {contentFile: 'contentFile'},
                    success: function(response){
                        var loadFile = '';

                        response.forEach(function(item){
                            loadFile += '<li class="col s12 m4">';
                            loadFile += '<div class="borderpage card grey lighten-5 collapsible-header">';
                            loadFile += '<span>';
                            loadFile += '<p>'+item.file_name+'</p>';
                            loadFile += '<small>'+item.file_type+'</small>';
                            loadFile += '</span>';
                            loadFile += '</div>';
                            loadFile += '<div class="borderpage card grey lighten-4 collapsible-body">';
                            loadFile +='<div style="display: flex; justify-content: end;">';
                            loadFile += '<span class="delete_icon" data-id="'+item.id+'" onclick="deleteFile('+item.id+')"><i class="bx bx-trash red-text" style="font-size: 18px;"></i></span>';
                            loadFile +='</div>';
                            loadFile += '<p>Date: '+item.date+'</p>';
                            loadFile += '<p>Downloads: '+item.download_count+'</p>';
                            loadFile += '<p>Likes: '+item.like_count+'</p>';
                            loadFile +='<div style="display: flex; justify-content: space-between;">';
                            loadFile += '<div class="like_icon" data-id="'+item.id+'" onclick="likeButton('+item.id+')" style="border-radius: 20px;"><span><i class="bx bx-like"></i></span></div>';
                            loadFile += '<button class="waves-effect waves-light btn" onclick="downloadButton('+item.id+')" style="border-radius: 20px;">Download</button>';
                            loadFile +='</div>';
                            loadFile += '</div>';
                            loadFile += '</li>';
                        });
                        $('.load_file').html(loadFile);

                        $('.collapsible').collapsible();
                    }
                });
            }
            loadFile();
            
            $('#searchInput').on('input',function(){
                const search = $(this).val();
                
                $.ajax({
                    type: 'GET',
                    url: 'admin_ajax.php',
                    dataType: 'json',
                    data: {searchFile: search},
                    success: function(response){
                        var loadFile = '';
            
                        response.forEach(function(item){
                            loadFile += '<li class="col s12 m4">';
                            loadFile += '<div class="borderpage card grey lighten-5 collapsible-header">';
                            loadFile += '<span>';
                            loadFile += '<p>'+item.file_name+'</p>';
                            loadFile += '<small>'+item.file_type+'</small>';
                            loadFile += '</span>';
                            loadFile += '</div>';
                            loadFile += '<div class="borderpage card grey lighten-4 collapsible-body">';
                            loadFile +='<div style="display: flex; justify-content: end;">';
                            loadFile += '<span class="delete_icon" data-id="'+item.id+'" onclick="deleteFile('+item.id+')"><i class="bx bx-trash red-text" style="font-size: 18px;"></i></span>';
                            loadFile +='</div>';
                            loadFile += '<p>Date: '+item.date+'</p>';
                            loadFile += '<p>Downloads: '+item.download_count+'</p>';
                            loadFile += '<p>Likes: '+item.like_count+'</p>';
                            loadFile +='<div style="display: flex; justify-content: space-between;">';
                            loadFile += '<div class="like_icon" data-id="'+item.id+'" onclick="likeButton('+item.id+')" style="border-radius: 20px;"><span><i class="bx bx-like"></i></span></div>';
                            loadFile += '<button class="waves-effect waves-light btn" onclick="downloadButton('+item.id+')" style="border-radius: 20px;">Download</button>';
                            loadFile +='</div>';
                            loadFile += '</div>';
                            loadFile += '</li>';
                        });
                        $('.load_file').html(loadFile);
            
                        $('.collapsible').collapsible();
                        
                    }
                });
            });
            $('#fileUploadForm').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                
                $.ajax({
                    url: 'admin_ajax.php',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log(response);
                        if(response == 'True'){
                            M.toast({html: 'Upload File Successfully!!', classes: 'rounded green'});
                            setTimeout(function(){
                                window.location.reload();
                            },1000);
                        }else{
                            M.toast({html: 'Error Uploading File', classes: 'rounded red'})
                        }
                    },
                });
            });
        });
        function deleteFile(id){
            var deleteFile = id;

            if(confirm('Are you sure you want to delete?')){
                $.ajax({
                    type: 'GET',
                    url: 'admin_ajax.php',
                    data: {deleteFile: deleteFile},
                    success: function(response){
                        if(response == 'True'){
                            M.toast({html: 'Delete Successfully!!', classes: 'rounded green'});

                            setTimeout(function(){
                                window.location.href="repository.php";
                            },1000);
                        }
                    }
                });
            }
        }
        function downloadButton(id){
            const download = id;

            window.location.href="admin_ajax.php?download="+download+"";
        }
        function likeButton(id){
            const likeId = id;
            console.log(likeId);
            $.ajax({
                type: 'GET',
                url: 'admin_ajax.php',
                data: {likeId: likeId},
                success: function(response){
                    console.log(response);
                    if(response == 'True'){
                        M.toast({html: 'Like File', classes: 'rounded green'});
                        
                        setTimeout(function(){
                            window.location.href="repository.php";
                        },1000);
                    }else{
                        M.toast({html: 'UnLike File', classes: 'rounded green'});
                        setTimeout(function(){
                            window.location.href="repository.php";
                        },1000);
                    }
                }
            });
        }
    </script>
</body>
</html>