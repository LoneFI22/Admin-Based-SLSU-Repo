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
    <title>Admin | Users</title>
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
        .userPage{
            margin-top: 10px;
        }
        .user_head{
            display: flex;
            align-items: center;
        }
        .edit_icon{
            cursor: pointer;
        }
        .delete_icon{
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
        <main>
            <div class="header">
                <div class="left">
                    <h1>Users</h1>
                </div>
            </div>
            <div class="mycontainer">
                <span class="icon-container" onclick="window.location.href='addUser.php'"><i class="adduser bx bxs-plus-circle"></i></span>
                <div class="search-box">
                    <input type="text" id="searchInput" placeholder="Search...">
                    <button type="submit"><i class='bx bx-search'></i></button>
                </div>
            </div>
            <!-- User Content -->
            <ul>
                <div class="collapsible userList row" style="padding: 10px; border-radius: 20px; background-color: rgb(246, 246, 249);">

                </div>
            </ul>
        </main>
    </div>
    <script src="../assets/plugins/js/script.js"></script>
    <script>
        $(document).ready(function(){
            function loadAllUser(){
                  $.ajax({
                    type: 'GET',
                    url: 'admin_ajax.php',
                    json: 'json',
                    data: { loadAllUser: 'loadAllUser'},
                    success: function(response){
                        var res = JSON.parse(response);
                        console.log(res)
                        var load = '';
                        res.forEach(function(item){
                        load += '<li class="userPage col s12 m3" data-id="'+item.id+'">';
                        load += '<div class="borderpage card grey lighten-5 collapsible-header user_head">';
                        load += '<div class="profile-radius">';
                        load += '<img class="profile_fit" src="'+(item.image_path ? item.image_path : "../assets/img/default.png") +'" width="60" height="60">';
                        load += '</div>';
                        load += '<span style="margin-left: 25px;">';
                        load += '<p>'+item.name+'</p>';
                        load += '<small>'+item.status+'</small>';
                        load += '</span>';
                        load += '</div>';
                        load += '<div class="borderpage card grey lighten-4 collapsible-body">';
                        load += '<div style="display: flex; justify-content: end;">';
                        load += '<span class="edit_icon" onclick="window.location.href=\'setting.php?user_id='+item.user_id+'\'"><i class="bx bx-edit-alt" style="font-size: 18px;"></i></span>&nbsp;';
                        load += '<span class="delete_icon" data-id="'+item.user_id+'" onclick="deleteUser('+item.user_id+')"><i class="bx bx-trash red-text" style="font-size: 18px;"></i></span>';
                        load += '</div>';
                        load += '<p>Id Number: '+item.id_num+'</p>';
                        load += '<p>Email: '+item.email+'</p>';
                        load += '<p>Phone Number: '+item.phoneNumber+'</p>';
                        load += '</div>';
                        load += '</li>';
                        });
                    $('.userList').html(load); // Add the content to the list
                    
                    // Initialize Materialize Collapsible after content is loaded
                    $('.collapsible').collapsible();
                    }
                });
            
            }
            loadAllUser();

            $('#searchInput').on('input',function(){
                const search = $(this).val();
            
                $.ajax({
                    type: 'GET',
                    url: 'admin_ajax.php',
                    data: {searchUser : search},
                    success: function(response){
                        const res = JSON.parse(response);
                        console.log(res);
                        var load = '';
                        res.forEach(function(item){
                            load += '<li class="userPage col s12 m3" data-id="'+item.id+'">';
                            load += '<div class="borderpage card grey lighten-5 collapsible-header user_head">';
                            load += '<div>';
                            load += '<img class="profile_fit" src="'+(item.image_path ? item.image_path : "../assets/img/default.png") +'" width="60" height="60">';
                            load += '</div>';
                            load += '<span style="margin-left: 25px;">';
                            load += '<p>'+item.name+'</p>';
                            load += '<small>'+item.status+'</small>';
                            load += '</span>';
                            load += '</div>';
                            load += '<div class="borderpage card grey lighten-4 collapsible-body">';
                            load += '<div style="display: flex; justify-content: end;">';
                            load += '<span class="edit_icon" onclick="window.location.href=\'setting.php?user_id='+item.user_id+'\'"><i class="bx bx-edit-alt" style="font-size: 18px;"></i></span>';
                            load += '<span class="delete_icon" data-id="'+item.user_id+'" onclick="deleteUser('+item.user_id+')"><i class="bx bx-trash red-text" style="font-size: 18px;"></i></span>';
                            load += '</div>';
                            load += '<p>Id Number: '+item.id_num+'</p>';
                            load += '<p>Email: '+item.email+'</p>';
                            load += '<p>Phone Number: '+item.phoneNumber+'</p>';
                            load += '</div>';
                            load += '</li>';
                        });
                        $('.userList').html(load);
    
                        $('.collapsible').collapsible();
                    }
                });
            });
        });
        function deleteUser(id){
            var deleteUser = id;

            if(confirm('Are you sure you want to delete?')){
                $.ajax({
                    type: 'GET',
                    url: 'admin_ajax.php',
                    data: {deleteUser: deleteUser},
                    success: function(response){
                        if(response == 'True'){
                            M.toast({html: 'Delete Successfully!!', classes: 'rounded green'});

                            setTimeout(function(){
                                window.location.href="user.php";
                            }, 1000);
                        }
                    }
                });
            }
        }
    </script>
</body>
</html>