<?php
session_start();
include 'admin_class.php';

if(!isset($_SESSION['admin_id'])){
    header('location: login.php');
    exit();
}

$user = new Admin();

// if(isset($_POST['submit'])){
//     $id = $_POST['idNum'];
//     if($user->userExist($id) == true){
//         echo "<script>alert('The {$id} ID Already Exists');</script>";
//     }else{
//         if($user->addUser()){
//             echo "<script>alert('Register Successful!!');</script>";
//         }
//     }
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User</title>
    <?php include 'header.php'; ?>
    <style>
        .backgr{
            background: linear-gradient(289deg, #bdc4ef, #e6c9c9);
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
                                User Table
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <!-- Main content -->
            <div class="content">
            <div class="container">
                <button class="mb-3 btn bg-primary btn-sm align-items-center" data-toggle="modal" data-target="#registrationModal">
                    <span class="info-box-text">Add User</span>
                </button>
                    <div class="row">
                    <!-- Modal -->
                    <div class="modal fade" id="registrationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">User Registration</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" id="registrationForm">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="idNum">ID Number</label>
                                                <input type="text" class="form-control" id="idNum" name="idNum" required>
                                            </div>
                                            <div class="col-6">
                                                <label for="name">Name</label>
                                                <input type="text" class="form-control" id="name" name="name" required>
                                            </div>
    
                                            <div class="col-6">
                                                <label for="number">Phone Number</label>
                                                <input type="text" class="form-control" id="number" name="phoneNumber" required>
                                            </div>
                                            <div class="col-6">
                                                <label for="status">Status</label>
                                                <select name="status" id="status" class="form-control">
                                                    <option value="admin">Admin</option>
                                                    <option value="user">User</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label for="email">Email</label>
                                                <input type="email" class="form-control" id="email" name="email" required>
                                            </div>
                                            <div class="col-12">
                                                <label for="password">Password</label>
                                                <input type="password" class="form-control" id="password" name="password" required>
                                            </div>
                                            <br><br><br><br>
                                            <button type="button" id="submitReg" name='submit' class="btn btn-primary col-12">Register</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>

                        </div>
                    </div>

                    
                    <div class="col-12 px-0">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">User Table</h3>

                            <div class="d-flex card-tools align-items-center">

                                <!-- <button class='rounded btn btn-primary btn-sm'>Asc</button>
                                <button class='rounded btn btn-info btn-sm'>Desc</button>&nbsp; -->
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="table_search" id='searchInput' class="form-control float-right" placeholder="Search">

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
                            <table class="table table-head-fixed text-nowrap" id="usertable">
                            <thead>
                                <tr>
                                <th>ID Number</th>
                                <th>Name</th>
                                <th>Phone Number</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="loadUserData">
                                <?php 
                                    $getData = new Admin();
                                    $data = $getData->getAllUser();

                                    foreach($data as $user){
                                    ?>
                                        <tr>
                                        <td><?= $user['id_num']?></td>
                                        <td><?= $user['name']?></td>
                                        <td><?= $user['phoneNumber']?></td>
                                        <td><?= $user['email']?></td>
                                        <td><?= $user['status']?></td>
                                        <td><?= date("F j, Y g:i A", strtotime($user['date']))?></td>
                                        <td>
                                            <button class="view_info btn btn-primary btn-sm" data-toggle='modal' data-target='#viewData' data-id='<?= $user['id']?>'>View</button>
                                            <button class="delUser btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteUser" data-id="<?= $user['id']?>">Delete</button>
                                        </td>
                                        </tr>
                                    <?php } ?>
                            </tbody>
                            </table>
                        </div>
                        <!-- Load modal -->
                            <div class="modal fade" id="viewData">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">User</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body" id='modal-data'>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="viewData">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">User</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body" id='modal-data'>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="edit_info">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">User</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="deleteUser">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <h class="4">Are you sure you want to delete?</h>
                                            <div class="hidden_con"></div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="button" class="delete_user btn btn-primary">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include 'footer.php';?>
    </div>

    <script>
        $(document).ready(function() {
            // function loadUser(){
            //     $.ajax({
            //         type: 'POST',
            //         url: 'jquery_admin.php',
            //         data: { load_data: 'load_data'},
            //         success: function(response){
            //             $('#loadUserData').html(response);
            //         }
            //     });
            // }
            // loadUser();
            $('#submitReg').click(function(){
                var formData = $('#registrationForm').serialize();

                $.ajax({
                    type: 'POST',
                    url: 'jquery_admin.php',
                    data: formData,
                    success: function(response){
                        if(response == 'exist'){
                            toastr.info('ID Already Exists');
                        }else if(response == 'success'){
                            toastr.success('Delete Successfully');
                            window.location.reload();
                        }
                    },
                    error: function(){
                        toastr.error('Error');
                    }
                });
            });
            // Add an input event listener to the search input field
            $('#searchInput').on('input', function() {
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
            
            $('.super').click(function(){
                const data = $(this).data('id');
                console.log(data);
            });
            $('.view_info').on('click',function(){
                const data = $(this).data('id');
                $.ajax({
                    type: 'GET',
                    url: 'jquery_admin.php',
                    data: { data_id: data },
                    success: function (response) {
                        var info_data = JSON.parse(response);
                        console.log(info_data);
                        var load_data = '';
                        var userLogs = '';
                        var infoButton = '';
                        var info = '';
                        
                        //Comparing the status of the user for the button
                        if(info_data.data[0].status === 'admin'){
                            infoButton += '<button class="btn btn-primary btn-sm" onclick="window.location.href=\'updateAdminData.php?id='+info_data.data[0].user_id+'\'">Edit</button>';
                        }else{
                            infoButton += '<button class="btn btn-primary btn-sm" onclick="window.location.href=\'updateData.php?id='+info_data.data[0].user_id+'\'">Edit</button>';
                        }
                        //Comparing the status of the user for the info
                        if(info_data.data[0].status === 'admin'){
                            info += '<p><span>Id Number: </span><strong>'+info_data.data[0].id_num+'</strong></p>';
                            info += '<p><span>Phone Number: </span><strong>'+info_data.data[0].phoneNumber+'</strong></p>';
                        }else{
                            info += '<p><span>Id Number: </span><strong>'+info_data.data[0].id_num+'</strong></p>';
                            info += '<p><span>Phone Number: </span><strong>'+info_data.data[0].phoneNumber+'</strong></p>';
                            info += '<p><span>Course: </span><strong>'+info_data.data[0].course+'</strong></p>';
                            info += '<p><span>Year Level: </span><strong>'+info_data.data[0].yr_level+'</strong></p>';
                        }

                        //If the length of the logs array 0 it will execute to no logs else with logs
                        if (Object.keys(info_data.logs).length === 0) {
                            userLogs += '<tr>';
                            userLogs += '<td>No logs </td>';
                            userLogs += '</tr>';
                        } else {
                            info_data.logs.forEach(function(items) {
                                userLogs += '<tr>';
                                userLogs += '<td>' + items.logs + '</td>'; // Close the <td> tags
                                // Format the date
                                const formattedDate = new Date(items.date);
                                const options = { year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric', hour12: true };
                                const formattedDateString = formattedDate.toLocaleDateString(undefined, options);
                                userLogs += '<td>' + formattedDateString + '</td>'; // Close the <td> tags
                                userLogs += '</tr>';
                            });
                        }
                        load_data += '<div class="card">' +
                                    '<div class="card-header">' +
                                    '<ul class="nav nav-pills">' +
                                    '<li class="nav-item"><a href="#profile" class="nav-link active" data-toggle="tab">Profile</a></li>' +
                                    '<li class="nav-item"><a href="#logs" class="nav-link" data-toggle="tab">Logs</a></li>' +
                                    '</ul>' +
                                    '</div>' +
                                    '<div class="card-body">' +
                                    '<div class="tab-content">' +
                                    '<div class="tab-pane active" id="profile">' +
                                    '<div class="row">' +
                                    '<div class="col-12 col-md-4">' +
                                    '<div class="card card-primary card-outline">' +
                                    '<div class="card-body box-profile">' +
                                    '<div class="text-center">' +
                                    '<div>'+
                                    '<img class="profile-user-img img-fluid img-circle" id="userImage" src="' + (info_data.data[0].image_path ? info_data[0].image_path : '../assets/profile/default.png') + '" alt="User profile picture">' +
                                    '<form id="imageUploadForm" enctype="multipart/form-data">'+
                                    '<input type="file" id="fileInput" accept="image/*" name="image" style="display: none;">' +
                                    '<input type="hidden" id="userId" name="data_id" value="'+info_data.data[0].user_id+'" >' +
                                    '<button class="btn btn-primary btn-sm mt-2" onclick="uploadImage()">Upload Image</button>'+
                                    '</form>'+
                                    '</div>'+
                                    '</div>' +
                                    '<input type="hidden" id="person_id" data-id="'+info_data.data[0].user_id+'" >' +
                                    '<h3 class="profile-username text-center">' + info_data.data[0].name + '</h3>' +
                                    '<p class="text-muted text-center">'+info_data.data[0].email+'</p>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>' +
                                    '<div class="col-12 col-md-8">' +
                                    '<div class="card">'+
                                    '<div class="card-header row">'+
                                    '<div class="col-10">'+
                                    '<h4>Information</h4>'+
                                    '</div>'+
                                    '<div class="col-2">'+ infoButton +
                                    '</div>'+
                                    '</div>'+
                                    '<div class="card-body">'+ info +
                                    '</div>'+
                                    '</div>'+
                                    '</div>' +
                                    '<div class="card">'+
                                    '<div class="card-header row">'+
                                    '<div class="col-11">'+
                                    '<h4>Information</h4>'+
                                    '</div>'+
                                    '<div class="col-1">'+
                                    '<button class="btn btn-primary btn-sm" onclick="window.location.href=\'updateAbout.php?id='+info_data.data[0].user_id+'\'">Edit</button>'+
                                    '</div>'+
                                    '</div>'+
                                    '<div class="card-body">'+
                                    '<p><span></span><strong>'+info_data.data[0].about+'</strong></p>'+
                                    '</div>'+
                                    '</div>'+
                                    '</div>' +
                                    '</div>' +
                                    '<div class="tab-pane" id="logs">' +
                                    '<table class="table table-responsive table-default" style="height: 200px">'+
                                    '<thead>'+
                                    '<tr>'+
                                    '<td>Logs</td>'+
                                    '<td>Date</td>'+
                                    '</tr>'+
                                    '</thead>'+
                                    '<tbody>'+
                                    '<div class="card">'+ userLogs +
                                    '</div>'+
                                    '</tbody>'+
                                    '</table>'+
                                    '</div>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>';

                        $('#modal-data').html(load_data);
                    }
                });
            });

            $(document).on('click', '#userImage', function() {
                $('#fileInput').click();
            });

            $(document).on('change', '#fileInput', function(e) {
                const file = e.target.files[0];
                const reader = new FileReader();

                reader.onload = function(e) {
                    $('#userImage').attr('src', e.target.result);
                }

                reader.readAsDataURL(file);
            });

            
            $('.delUser').click(function(){
                const data = $(this).data('id');
                $.ajax({
                    type: 'GET',
                    url: 'jquery_admin.php',
                    data: { get_data : data},
                    success: function(response){
                        var res = '';

                        res+= '<input type="hidden" id="hidden_id" value="'+response+'"/>';
                        console.log(response);
                        $('.hidden_con').html(res);
                    },
                    error: function(){
                        console.log('error');
                    }
                });
            });
            $('.delete_user').click(function(){
                const data = $('#hidden_id').val();

                $.ajax({
                    type: 'GET',
                    url: 'jquery_admin.php',
                    dataType: 'json',
                    data: { data : data},
                    success: function(response){
                        if(response == true){
                            toastr.success('Delete Successfully');

                            setTimeout(function() {
                                window.location.href='user.php';
                            }, 2000);
                        }
                    },
                    error: function(){
                        toastr.error('Error Deleting');
                    }
                });
            });
        });


        function uploadImage() {
            const formData = new FormData(document.getElementById('imageUploadForm'));
            // const imageData = $('#userImage').attr('src');
            // const userId = $('#userId');
            // const user_id = userId.attr('data-id');

            // Send imageData to PHP for database update via AJAX

            console.log(user_id);
            $.ajax({
                type: 'POST',
                url: 'jquery_admin.php',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    // Handle success (if needed)
                    console.log(response);
                    toastr.success('Upload Profile Picture Successfully.');
                },
                error: function() {
                    // Handle error (if needed)
                }
            });
        }
    </script>
</body>
</html>