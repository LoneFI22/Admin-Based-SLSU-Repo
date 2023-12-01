<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <?php include 'header.php';?>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f5f5f5;
        }

        .login-card {
            width: 350px;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <h4 class="center-align">Login</h4>
        <form method="post" id="loginForm">
            <div id="incorrect" class="input-field red white-text" style="padding: 10px; border-radius: 4px; display: none;">
                <p for="">Incorrect Username or Password</p>
            </div>
            <div id="notfound" class="input-field red white-text" style="padding: 10px; border-radius: 4px; display: none;">
                <p for="">Username Not Found</p>
            </div>
            <div class="input-field">
                <input id="id_num" type="text" class="validate" required>
                <label for="id_num">ID Number</label>
            </div>
            <div class="input-field">
                <input id="password" type="password" class="validate" required>
                <label for="password">Password</label>
            </div>
            <div style="display:flex; justify-content: center;">
                <button class="login btn waves-effect waves-light" style="padding-left: 30px; padding-right: 30px;" type="submit">Login</button>
            </div>
        </form>
    </div>
    <script>
        $(document).ready(function(){
            $('.login').click(function(e){
                e.preventDefault();
                const username = $('#id_num').val();
                const password = $('#password').val();
                $.ajax({
                    type: 'GET',
                    url: 'user_ajax.php',
                    data: {login: 'login',username: username, password: password},
                    success: function(response){
                        if(response.trim() == 1){
                            window.location.href = 'index.php';
                        }else if(response.trim() == 2){
                            $('#incorrect').show();
                            $('#notfound').hide();
                        }else if(response.trim() == 3){
                            $('#notfound').show();
                            $('#incorrect').hide();
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
