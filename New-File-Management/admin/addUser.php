<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <?php include 'header.php';?>
    <style>
    .nav-content{
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .nav-right{
        display: flex;
        align-items: center;
    }
</style>
</head>
<body>
    <div class="sidebar">
        <a href="index.php" class="logo">
            <i class='bx bx-code-alt'></i>
            <div class="logo-name"><span>SLSU</span>Repo</div>
        </a>
        <ul class="side-menu">
            <li><a href="index.php"><i class='bx bxs-dashboard'></i>Dashboard</a></li>
            <li><a href="repository.php"><i class='bx bx-archive'></i>Repository</a></li>
            <li class="active"><a href="user.php"><i class='bx bx-group'></i>Users</a></li>
            <li><a href="logs.php"><i class='bx bxl-blogger'></i>Logs</a></li>
            <li><a href="setting.php"><i class='bx bx-cog'></i>Settings</a></li>
        </ul>
        <ul class="side-menu">
            <li>
                <a href="#" class="logout">
                    <i class='bx bx-log-out-circle'></i>
                    Logout
                </a>
            </li>
        </ul>
    </div>
    <div class="content">
        <nav class='nav-content'>
            <div class="nav-start">
                <i class='bx bx-menu'></i>
            </div>
        </nav>
        <main>
            <div class="header">
                <div class="container">
                    <h4>User Registration</h4>
                    <form id="registrationForm">
                        <div class="row">
                            <div class="col s12 m6">
                                <div class="input-field">
                                    <input id="id_num" name="id_num" type="text" class="validate" required>
                                    <label for="id_num">ID Number</label>
                                </div>
                            </div>
                            <div class="col s12 m6">
                                <div class="input-field">
                                    <input id="name" name="name" type="text" class="validate" required>
                                    <label for="name">Name</label>
                                </div>
                            </div>
                            <div class="col s12 m6">
                                <div class="input-field">
                                    <input id="phoneNumber" name="phoneNumber" type="text" class="validate" required>
                                    <label for="phoneNumber">Phone Number</label>
                                </div>
                            </div>
                            <div class="col s12 m6">
                                <div class="input-field">
                                    <input id="email" name="email" type="email" class="validate" required>
                                    <label for="email">Email</label>
                                </div>
                            </div>
                            <div class="col s12 m6">
                                <div class="input-field">
                                    <input id="password" name="password" type="password" class="validate" required>
                                    <label for="password">Password</label>
                                </div>
                            </div>
                            <div class="col s12 m6">
                                <div class="input-field">
                                    <span>Status</span>
                                    <div class="row">
                                        <p class="col s6">
                                            <label>
                                                <input name="status" type="radio" value="admin"/>
                                                <span>Admin</span>
                                            </label>
                                        </p>
                                        <p class="col s6">
                                            <label>
                                                <input name="status" type="radio" value="user"/>
                                                <span>User</span>
                                            </label>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col s12">
                                <button class="btn waves-effect waves-light" type="submit">Register</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
    <script src="../assets/plugins/js/script.js"></script>
    <script>
        $(document).ready(function() {
            $('#registrationForm').submit(function(e) {
                e.preventDefault();

                // Gather form data
                var formData = {
                    addingUser: 'addingUser',
                    id_num: $('#id_num').val(),
                    name: $('#name').val(),
                    phoneNumber: $('#phoneNumber').val(),
                    email: $('#email').val(),
                    password: $('#password').val(),
                    status: $('input[name=status]:checked').val()
                };

                // AJAX POST request
                $.ajax({
                    type: 'GET',
                    url: 'admin_ajax.php',
                    data: formData,
                    success: function(response) {
                        console.log(response);
                        if(response == 'exist'){
                            M.toast({html: 'User ID Already Exist', classes: 'rounded red'})
                        }else if(response == 'True'){
                            M.toast({html: 'Register Successfully!!', classes: 'rounded green'})

                            setTimeout(function(){
                                window.location.href="user.php";
                            },1000);
                        }else{
                            M.toast({html: 'Error Registering', classes: 'rounded red'})
                        }
                    },
                });
            });
        });
    </script>
</body>
</html>