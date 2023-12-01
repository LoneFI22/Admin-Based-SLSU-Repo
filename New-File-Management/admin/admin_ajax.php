<?php
include 'admin_class.php';

$action = new Admin();

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

if(isset($_GET['loadUser'])){
    $res = $_GET['loadUser'];

    if($res == 'loadUser'){
        $countUser = count($action->getAllUser());
    }

    echo json_encode($countUser);
}

if(isset($_GET['loadFile'])){
    $res = $_GET['loadFile'];

    if($res == 'loadFile'){
        $countFile = count($action->getAllDocument($action));

    }
    echo json_encode($countFile);
}

if(isset($_GET['loadDownload'])){
    $res = $_GET['loadDownload'];

    if($res == 'loadDownload'){
        $countDownload = $action->totalDownloads();
    }

    echo json_encode($countDownload);
}

if(isset($_GET['loadLike'])){
    $res = $_GET['loadLike'];

    if($res == 'loadLike'){
        $countLike = count($action->totalLikes());
    }

    echo json_encode($countLike);
}

if(isset($_GET['loadGraph'])){
    $res = $_GET['loadGraph'];

    if($res == 'loadGraph'){
        $data = $action->dlChart();
    }

    echo json_encode($data);
}

if(isset($_GET['loadAllUser'])){
    $res = $_GET['loadAllUser'];

    if($res == 'loadAllUser'){
        $data = $action->getAllUser();
    }
    echo json_encode($data);
}

if(isset($_GET['deleteUser'])){
    $userId = $_GET['deleteUser'];

    $res = $action->deleteUser($userId);
    if($res == true){
        echo 'True';
    }
}

if(isset($_GET['deleteFile'])){
    $fileId = $_GET['deleteFile'];

    $res = $action->deleteFile($fileId);
    if($res == true){
        echo 'True';
    }
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

if(isset($_GET['loadLogs'])){
    $res = $_GET['loadLogs'];

    if($res == 'loadLogs'){
        $data = $action->getAllLogs();
    }
    echo json_encode($data);
}

if(isset($_GET['user_id'])){
    $res = $_GET['user_id'];

    $data = $action->getUserLogs($res);

    echo json_encode($data);
}

if(isset($_GET['infoLoad_id'])){
    $res = $_GET['infoLoad_id'];

    $data = $action->getUser($res);

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

    $data = $action->searchDoc($res,$action);
    echo json_encode($data);
}

if(isset($_GET['edit_user_id'])){
    $res = $_GET['edit_user_id'];

    $data = $action->getUser($res);

    echo json_encode($data);
}

if(isset($_GET['addingUser'])){
    extract($_GET);

    if($action->userExist($id_num)){
        echo 'exist';
    }else{
        $res = $action->addUser($id_num,$name,$phoneNumber,$email,$status,$password);
        if($res){
            echo 'True';
        }else{
            echo 'False';
        }
    }
}

if(isset($_GET['editInfo'])){
    extract($_GET);

    $res = $action->updateAdmin($Name,$Email,$PhoneNumber,$Password,$About);
    if($res == true){
        echo  "True";
    }else{
        echo "False";
    }
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

if(isset($_GET['searchUser'])){
    $res = $_GET['searchUser'];
    $data = $action->searchUser($res);
    echo json_encode($data);
}

//Uploading Image
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['imageProfile'])){
    $res = $action->addProfile();
    if($res == true){
        echo 'True';
    }
}
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['imageProfile1'])){
    $res = $action->addAdminProfile();
    if($res == true){
        echo 'True';
    }
}

//Uploading Files
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['fileDoc'])){
    $file = $_FILES['fileDoc']['tmp_name'];
    $res = $action->addFile($file);
    if($res == 1){
        echo 'True';
    }
    
}

//Downloading File
if(isset($_GET['download'])){
    $res = $_GET['download'];
    $action->downloadFile($res);
}
?>