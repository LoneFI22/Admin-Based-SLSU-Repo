<?php
include '../admin_class.php';

$action = new Admin();
$id = $action->getId($_SESSION['admin_id']);
$data = $action->getUser($id);
?>
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
<nav class='nav-content'>
    <div class="nav-start">
        <i class='bx bx-menu'></i>
    </div>
    <div class="nav-right">
        <a href="setting.php" class="profile" style="padding-top: 50%;">
            <img src="<?= $data[0]['image_path'] ? $data[0]['image_path'] : '../assets/img/default.png'?>">
        </a>
    </div>
</nav>