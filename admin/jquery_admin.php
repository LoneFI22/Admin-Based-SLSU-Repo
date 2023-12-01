<?php
session_start();
include 'admin_class.php';

//Creating Admin Object Class
$action = new Admin();

//Downloading Data of file
if(isset($_GET['download_file_id'])){
    $file_id = $_GET['download_file_id'];
    
    $count = $action->downloadCount($file_id);
    
    echo $count;
}

// if(isset($_POST['load_data'])){
//     $loadData = $_POST['load_data'];
//     if($loadData == 'load_data'){
//         $data = $action->getAllUser();

//         foreach($data as $user){
//             echo '<tr>';
//             echo '<td>'.$user['id_num'].'</td>';
//             echo '<td>'.$user['name'].'</td>';
//             echo '<td>'.$user['phoneNumber'].'</td>';
//             echo '<td>'.$user['email'].'</td>';
//             echo '<td>'.$user['status'].'</td>';
//             echo '<td>'.date("F j, Y g:i A", strtotime($user['date'])).'</td>';
//             echo '<td>';
//             echo    '<button class="view_info btn btn-primary btn-sm" data-toggle="modal" data-target="#viewData" data-id="'.$user['id'].'">View</button>';
//             echo    '<button class="delUser btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteUser" data-id="'.$user['id'].'">Delete</button>';
//             echo '</td>';
//             echo '</tr>';
//         }
//     }
// }

//Deleting Data of file
if(isset($_GET['delete_file_id'])){
    $file_id = $_GET['delete_file_id'];

    $action->deleteFile($file_id);
}

//Updating the user
if(isset($_POST['update_id'])){
    $user_id = $_POST['update_id'];
    $name = $_POST['name'];
    $course = $_POST['course'];
    $year_level = $_POST['year_level'];
    $email = $_POST['email'];
    $number = $_POST['number'];
    $password = $_POST['password'];

    $result = $action->updateUser($user_id,$name,$course,$year_level,$email,$number,$password);

    echo $result;
}

//Updating the admin
if(isset($_POST['update_admin_id'])){
    $user_id = $_POST['update_admin_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $number = $_POST['number'];
    $password = $_POST['password'];

    $result = $action->updateAdmin($user_id,$name,$email,$number,$password);

    echo $result;
}


if(isset($_POST['person_id'])){
    $user_id = $_POST['person_id'];
    $about = $_POST['about'];
    $result = $action->updateAbout($user_id,$about);

    echo $result;
}

if(isset($_GET['data_id'])){
    $user_id = $_GET['data_id'];

    $data = $action->getUser($user_id);
    $logs = $action->getUserLogs($user_id);

    $arr = array( 'data' => $data, 'logs' => $logs);

    echo json_encode($arr);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    extract($_POST);

    echo $user_id;
    // $result = $action->updateProfImage($base64_image, $user_id);
    // // Save $base64_image to your database as needed
    // if($result == 1){
    //     echo "Image uploaded successfully!";
    // }
}
if(isset($_POST['user_id'])){
    $user_id = $_POST['user_id'];

    $data = $action->getUserLogs($user_id);

    echo json_encode($data);
}

if(isset($_GET['get_data'])){
    $data = $_GET['get_data'];

    echo $data;
}

if(isset($_GET['recentUpload'])){
    $recent = $_GET['recentUpload'];

    if($recent == 'recent'){
        $result = $action->recentUpload();
    }
    echo json_encode($result);
}

//Delete User
if(isset($_GET['data'])){
    $data = $_GET['data'];

    $result = $action->deleteUser($data);

    echo $result;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_num']) && isset($_POST['password'])) {
    $id_num = $_POST['id_num'];
    $password = $_POST['password'];

    // Perform login authentication
    $loginResult = $action->login();
    
    echo $loginResult;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['idNum']) && isset($_POST['name'])) {
    $idNum = $_POST['idNum'];
    $name = $_POST['name'];
    $phoneNumber = $_POST['phoneNumber'];
    $email = $_POST['email'];
    $status = $_POST['status'];
    $password = $_POST['password'];

    if($action->userExist($idNum) == true){
        echo 'exist';
    }else{
        if($action->addUser($idNum,$name,$phoneNumber,$email,$status,$password)){
            echo 'success';
        }
    }
}
?>