<?php
include 'admin_class.php';

$user = new Admin();
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $getUser = $user->getUser($id);
    foreach($getUser as $User){
        $name = $User['name'];
        $phoneNumber = $User['phoneNumber'];
        $email = $User['email'];
        $password = $User['password'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Update User</title>
        <?php include 'header.php';?>
    </head>
    <body>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header text-center">
                            Update Admin
                        </div>
                        <div class="card-body">
                            <input type="hidden" id="id" value="<?= $id ?>">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?= $name?>" required>
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= $email ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="number">Phone Number</label>
                                <input type="text" class="form-control" id="number" name="phoneNumber" value="<?= $phoneNumber?>" required>
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" value="<?= $password ?>" required>
                            </div>

                            <button type="submit" name="update" class="update btn btn-primary">Update</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function(){
                $('.update').click(function(){
                    const id = $('#id').val();
                    const name = $('#name').val();
                    const email = $('#email').val();
                    const number = $('#number').val();
                    const password = $('#password').val();

                    $.ajax({
                        type: 'POST',
                        url: 'jquery_admin.php',
                        dataType: 'json',
                        data: { update_admin_id:id, name:name, email:email, number:number, password:password},
                        success: function(response){
                            if(response == true){
                                toastr.success('Update Successfully');

                                setTimeout(function() {
                                    window.location.href = "user.php";
                                }, 2000);
                            }
                        },
                        error: function(){
                            toastr.error('Update Error.');
                        }
                    });
                });
            });
        </script>
    </body>
</html>