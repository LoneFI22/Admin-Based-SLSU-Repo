<div class="sidebar">
    <a href="index.php" class="logo">
        <i class='bx bx-cube-alt'></i>
        <div class="logo-name"><span>SLSU</span>Repo</div>
    </a>
    <ul class="side-menu">
        <li class="active"><a href="index.php"><i class='bx bxs-dashboard'></i>Repo</a></li>
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
<script>
    $('.logout').click(function(){
        $.ajax({
            type: 'GET',
            url: 'user_ajax.php',
            data: {logout : 'logout'},
            success: function(response){
                if(response == true){
                    window.location.href="login.php";
                }
            }
        });
    });
</script>