<?php
session_start();
include 'user_class.php';

if(!$_SESSION['user_id']){
    header('location: login.php');
    exit();
}
$action = new User();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Setting</title>
    <?php include 'header.php';?>
    <style>
        .left{
            margin-bottom: 20px;
        }
        .center-pic{
            display: flex;
            justify-content: center;
            align-items: center;
            border: none;
        }
        .box-box{
            margin-bottom: 20px;
        }
        .user-profile-image {
            height: auto;
            border-radius: 100px;
            object-fit: cover;
        }
        .box-container {
            padding-top: 10%;
            padding-bottom: 10%;
            border-radius: 10%;
        }
        .box2-container {
            padding-top: 20px;
            padding-left: 30px;
            padding-right: 30px;
            padding-bottom: 10%;
            border-radius: 25px;
        }
        .align-button{
            padding: 10px;
            display: flex;
            justify-content: center;
        }
        .log-table{
            height: 350px;
            overflow: auto;
        }
        #information{
            height: auto;
        }
        #edit{
            height: auto;
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
                    <h1>Setting</h1>
                </div>
            </div>
            <input type='hidden' id='idOfAdmin' value='<?php echo isset($_SESSION["user_id"]) ? $action->getId($_SESSION["user_id"]) : ""; ?>'>

            <input type="hidden" name="">
            <div class="userProfile">
                <?php
                    $id = $action->getId($_SESSION['user_id']);
                    $data = $action->getUser($id);
                ?>
                <div class="row">
                    <div class="box-box col s12 m4">
                        <div class="box-container container grey lighten-5">
                            <label for="profile-pic-upload" class="center-pic">
                                <img id="profile-pic" src="<?= $data[0]['image_path'] ? $data[0]['image_path'] : '../assets/img/default.png'?>" class="user-profile-image" width="200" height="200" alt="Profile Image">
                            </label>
                            <form id="imageUploadForm1" class="align-button" enctype="multipart/form-data">
                                <input id="adminId" type="hidden" name="adminId" value="<?= $data[0]['user_id']?> ">
                                <input id="profile-pic-upload" name="imageProfile1" type="file" accept="image/*" style="display: none;">
                                <button class="btn waves-effect waves-light" type="submit">Upload</button>
                            </form>
                        </div>
                    </div>
                    <div class="box-box col s12 m8">
                        <div class="box2-container grey lighten-5">
                            <div class="row">
                                <div class="col s12">
                                    <ul class="tabs">
                                        <li class="tab col s12 m3"><a class="active" href="#information">Information</a></li>
                                        <li class="tab col s12 m3"><a href="#logs">Logs</a></li>
                                        <li class="tab col s12 m3"><a href="#edit">Edit</a></li>
                                    </ul>
                                </div><br><br><br>
                                <div id="information" class="col s12">
                                    <div class="row">
                                        <div class="infoUser col s12 m12">
                                        </div>
                                    </div>
                                </div>
                                    <div id="logs" class="log-table col s12">
                                        <table class="highlight">
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
                                <div id="edit" class="col s12">
                                    <form action="" method="post" id="editForm">
                                        <div class="row">
                                            <div class="edit_user_info col s12">
                                            </div>
                                            <button type="button" class="editInfoButton waves-effect waves-light btn" style="padding-left: 30px; padding-right: 30px">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="../assets/plugins/js/script.js"></script>
    <script>
        function compareId() {
            const admin_id = $('#idOfAdmin').val();

            return admin_id;
        }
        console.log(compareId());
        $(document).ready(function(){
            $('.tabs').tabs();
            function loadLogs(user_id){
                $.ajax({
                    type: 'GET',
                    url: 'user_ajax.php',
                    data: {user_id: user_id},
                    dataType: 'json',
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
            function infoUserLoad(user_id){
                $.ajax({
                    type: 'GET',
                    url: 'user_ajax.php',
                    data: {infoLoad_id: user_id},
                    dataType: 'json',
                    success: function(response){
                        console.log(response);
                        var infoLoad = '';
                        infoLoad += '<div class="row">' ;
                        infoLoad += '<div class="input-field col s12 m6">' ;
                        infoLoad += '<label for="name">Name</label>' ;
                        infoLoad += '<input id="name" type="text" class="validate" value="' + response[0].name + '" disabled>' ;
                        infoLoad += '</div>' ;
                        infoLoad += '<div class="input-field col s12 m6">' ;
                        infoLoad += '<label for="user">ID Number</label>' ;
                        infoLoad += '<input id="user" type="text" class="validate" value="' + response[0].id_num + '" disabled>' ;
                        infoLoad += '</div>' ;
                        infoLoad += '</div>' ;
                        infoLoad += '<div class="row">' ;
                        infoLoad += '<div class="input-field col s12 m6">' ;
                        infoLoad += '<label for="phoneNumber">Phone Number</label>' ;
                        infoLoad += '<input id="phoneNumber" type="text" class="validate" value="' + response[0].phoneNumber + '" disabled>' ;
                        infoLoad += '</div>' ;
                        infoLoad += '<div class="input-field col s12 m3">' ;
                        infoLoad += '<label for="yr_level">Year Level</label>' ;
                        infoLoad += '<input id="yr_level" type="text" class="validate" value="' + response[0].yr_level + '" disabled>' ;
                        infoLoad += '</div>' ;
                        infoLoad += '<div class="input-field col s12 m3">' ;
                        infoLoad += '<label for="course">Course</label>' ;
                        infoLoad += '<input id="course" type="text" class="validate" value="' + response[0].course + '" disabled>' ;
                        infoLoad += '</div>' ;
                        infoLoad += '</div>' ;
                        infoLoad += '<div class="row">' ;
                        infoLoad += '<div class="input-field col s12 m6">' ;
                        infoLoad += '<label for="email">Email</label>' ;
                        infoLoad += '<input id="email" type="email" class="validate" value="' + response[0].email + '" disabled>' ;
                        infoLoad += '</div>' ;
                        infoLoad += '<div class="input-field col s12 m6">' ;
                        infoLoad += '<label for="password">Password</label>' ;
                        infoLoad += '<input id="password" type="password" class="validate" value="'+response[0].password+'" disabled>' ;
                        infoLoad += '</div>' ;
                        infoLoad += '</div>';
                        infoLoad += '<div class="row">';
                        infoLoad += '<div class="input-field col s12 m12">' ;
                        infoLoad += '<textarea id="about" class="materialize-textarea" disabled>'+response[0].about+'</textarea>';
                        infoLoad += '<label for="about">About</label>';
                        infoLoad += '</div>';
                        infoLoad += '</div>';
                        $('.infoUser').empty();
                        $('.infoUser').html(infoLoad);
                        $('.infoUser input, .infoUser textarea').each(function(){
                            M.updateTextFields();
                        });
                    }
                });
            }
            function editUserInfo(user_id){
                $.ajax({
                    type: 'GET',
                    url: 'user_ajax.php',
                    data: {edit_user_id: user_id},
                    dataType: 'json',
                    success: function(response){
                        console.log(response);
                        var infoLoad = '';
                        infoLoad += '<div class="row">' ;
                        infoLoad += '<input id="id" name="id" type="hidden" class="validate" value="' + response[0].user_id + '">' ;
                        infoLoad += '<div class="input-field col s12 m6">' ;
                        infoLoad += '<label for="Name">Name</label>' ;
                        infoLoad += '<input id="Name" name="Name" type="text" class="validate" value="' + response[0].name + '">' ;
                        infoLoad += '</div>' ;
                        infoLoad += '<div class="input-field col s12 m6">' ;
                        infoLoad += '<label for="id_num">ID Number</label>' ;
                        infoLoad += '<input id="id_num" name="id_num" type="text" class="validate" value="' + response[0].id_num + '" disabled>' ;
                        infoLoad += '</div>' ;
                        infoLoad += '</div>' ;
                        infoLoad += '<div class="row">' ;
                        infoLoad += '<div class="input-field col s12 m6">' ;
                        infoLoad += '<label for="PhoneNumber">Phone Number</label>' ;
                        infoLoad += '<input id="PhoneNumber" name="PhoneNumber" type="text" class="validate" value="' + response[0].phoneNumber + '">' ;
                        infoLoad += '</div>' ;
                        infoLoad += '<div class="input-field col s12 m3">' ;
                        infoLoad += '<label for="Yr_level">Year Level</label>' ;
                        infoLoad += '<input id="Yr_level" name="Yr_level" type="text" class="validate" value="' + response[0].yr_level + '">' ;
                        infoLoad += '</div>' ;
                        infoLoad += '<div class="input-field col s12 m3">' ;
                        infoLoad += '<label for="Course">Course</label>' ;
                        infoLoad += '<input id="Course" name="Course" type="text" class="validate" value="' + response[0].course + '">' ;
                        infoLoad += '</div>' ;
                        infoLoad += '</div>' ;
                        infoLoad += '<div class="row">' ;
                        infoLoad += '<div class="input-field col s12 m6">' ;
                        infoLoad += '<label for="Email">Email</label>' ;
                        infoLoad += '<input id="Email" name="Email" type="email" class="validate" value="' + response[0].email + '">' ;
                        infoLoad += '</div>' ;
                        infoLoad += '<div class="input-field col s12 m6">' ;
                        infoLoad += '<label for="Password">Password</label>' ;
                        infoLoad += '<input id="Password" name="Password" type="password" class="validate" value="'+response[0].password+'">' ;
                        infoLoad += '</div>' ;
                        infoLoad += '</div>';
                        infoLoad += '<div class="row">';
                        infoLoad += '<div class="input-field col s12 m12">' ;
                        infoLoad += '<textarea id="About" name="About" class="materialize-textarea">'+response[0].about+'</textarea>';
                        infoLoad += '<label for="About">About</label>';
                        infoLoad += '</div>';
                        infoLoad += '</div>';
                        $('.edit_user_info').empty();
                        $('.edit_user_info').html(infoLoad);
                        $('.edit_user_info input, .edit_user_info textarea').each(function(){
                            M.updateTextFields();
                        });
                    }
                });
            }
            loadLogs(compareId());
            infoUserLoad(compareId());
            editUserInfo(compareId());

            $('.editInfoButton').click(function(){
                var formData = {editUserInfo: 'editInfo',};

                $('#editForm').find('input, textarea, select').each(function(index, element) {
                    var field = $(element);
                    formData[field.attr('id')] = field.val();
                });
                $.ajax({
                    type: 'GET',
                    url: 'user_ajax.php',
                    data: formData,
                    success: function(response){
                        if(response == 'True'){
                            M.toast({ html: 'Record updated successfully', classes: 'rounded green' });
                        }else{
                            M.toast({ html: 'Error update record', classes: 'rounded red' });
                        }
                    },
                });
            });
            $('#profile-pic-upload').on('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        // Set the source of the image to the selected file
                        $('#profile-pic').attr('src', e.target.result);
                    }
                    // Read the selected file as a data URL
                    reader.readAsDataURL(file);
                }
            });
            $('#imageUploadForm1').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                
                $.ajax({
                    url: 'user_ajax.php',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log(response);
                        if(response == 'True'){
                            M.toast({html: 'Upload Image Profile Successfully!!', classes: 'rounded green'})
                        }
                    },
                });
            });
        });
    </script>
</body>
</html>