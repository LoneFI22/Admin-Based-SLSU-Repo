<?php
include 'user_class.php';

$action = new User();

if (isset($_GET['login'])) {
    $id_num = $_GET['username'];
    $password = $_GET['password'];

    // Perform login authentication
    $loginResult = $action->login($id_num, $password);
    
    echo $loginResult;
}

if(isset($_GET['logout'])){
    $logout = $_GET['logout'];

    if($logout =='logout'){
        $action->logout();
    }
    echo true;
}

if(isset($_GET['loadLogs'])){
    $res = $_GET['loadLogs'];

    if($res == 'loadLogs'){
        $data = $action->getUserLogs();
    }
    echo json_encode($data);
}

if(isset($_GET['contentFile'])){
    $res = $_GET['contentFile'];

    if($res == 'contentFile'){
        $data = $action->getAllDocument($action);
    }
    echo json_encode($data);
}

if(isset($_GET['searchFile'])){
    $res = $_GET['searchFile'];

    $data = $action->searchFile($res,$action);
    echo json_encode($data);
}

if(isset($_GET['likeId'])){
    $fileId = $_GET['likeId'];

    $res = $action->like($fileId);
    if($res == 1){
        echo 'True';
    }else if($res == 2){
        echo 'False';
    }else{
        echo 'True';
    }
}

//Downloading File
if(isset($_GET['download'])){
    $res = $_GET['download'];
    $action->downloadFile($res);
}

if(isset($_GET['user_id'])){
    $res = $_GET['user_id'];

    $data = $action->getUserLogs();

    echo json_encode($data);
}

if(isset($_GET['infoLoad_id'])){
    $res = $_GET['infoLoad_id'];

    $data = $action->getUser($res);

    echo json_encode($data);
}

if(isset($_GET['edit_user_id'])){
    $res = $_GET['edit_user_id'];

    $data = $action->getUser($res);

    echo json_encode($data);
}

if(isset($_GET['editUserInfo'])){
    extract($_GET);

    $res = $action->updateUser($id,$Name,$Course,$Yr_level,$Email,$PhoneNumber,$Password,$About);
    if($res == true){
        echo  "True";
    }else{
        echo "False";
    }
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['imageProfile1'])){
    $res = $action->addUserProfile();
    if($res == true){
        echo 'True';
    }
}
?>