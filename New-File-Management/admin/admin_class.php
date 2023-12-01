<?php

class Admin{
    private $db;

    function __construct(){
        include '../include/conn.php';

        $this->db = $conn;
    }

    function __destruct(){
        $this->db->close();
    }

    function login($id_num,$password){
        session_start();
         // Query the database for the user with the provided username
        $query = "SELECT * FROM info WHERE id_num = '$id_num' AND `status` = 'admin'";
        $result = $this->db->query($query);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if ($password == $row['password']) {
                // Password is correct
                $_SESSION['admin_id'] = $id_num;
                $query = $this->db->query("INSERT INTO activity_logs (logs, user_id) VALUES ('".$row['name']." is logging in','".$row['id']."')");
                return 1;
            } else {
                // Password is incorrect
                return 2;
            }
        } else {
            // User not found
            return 3;
        }
    }

    function logout(){
        session_start();
        $id_num = $_SESSION['admin_id'];
        $qry = "SELECT * FROM `info` WHERE id_num = '$id_num' AND `status` = 'admin'";
        $result = $this->db->query($qry);
        if($result->num_rows == 1){
            $row = $result->fetch_assoc();
            $qry = $this->db->query("INSERT INTO activity_logs (logs, user_id) VALUES ('".$row['name']." is logging out', '".$row['id']."')");
            if($qry){
                session_destroy();
            }
        }
    }

    //This function tells if the user found in database
    function userExist($id){
        $sql = "SElECT COUNT(*) as count FROM info WHERE id_num = ?";
        // Prepare the SQL query
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $row = $result->fetch_assoc();

        if ($row['count'] > 0) {
            return true;
        }else{
            return false;
        }
    }

    //This function retrieve specific data in the database
    function getUser($id){
        $data = array();
        $sql ="SELECT info.*, profile.* FROM info INNER JOIN profile On info.id = profile.user_id  WHERE info.id = $id";
        $result = $this->db->query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $data[] = $row;
            }
        }
        return $data;
    }
    function getId($id_num){
        $id = $this->db->query("SELECT id FROM info WHERE id_num = '$id_num'")->fetch_array()['id'];
        return $id;
    }

    //This function add user in the database
    function addUser($idNum,$name,$phoneNumber,$email,$status,$password) {
        session_start();
        $admin_id = $_SESSION['admin_id'];
        $qry = $this->db->query("SELECT id, name FROM info WHERE id_num = '$admin_id'")->fetch_assoc();
        $admin_name = $qry['name'];
        $admin_id = $qry['id'];

        //Inserting Data of the table info
        $sql = $this->db->query("INSERT INTO info (id_num,name,email,phoneNumber,status,password) VALUES ('$idNum','$name','$email','$phoneNumber','$status','$password')");
        $fetch = $this->db->query("SELECT id, name FROM info WHERE id_num = '$idNum'")->fetch_assoc();
        $id_num = $fetch['id'];
        $sql2 = $this->db->query("INSERT INTO `profile`(`user_id`,`yr_level`,`course`,`about`,`image_path`) VALUES ('$id_num','','','','')");
        if ($sql && $sql2) {
            $qry = $this->db->query("INSERT INTO activity_logs (logs,user_id) VALUES('$admin_name is adding new user','$admin_id')");
            return true;
        }
    }
    
    //This function is use to update specific data base on the condition
    function updateUser($user_id,$name,$course,$year_level,$email,$number,$password,$about){
        session_start();
        $admin_id = $_SESSION['admin_id'];
        $qry = $this->db->query("SELECT id, name FROM info WHERE id_num = '$admin_id'")->fetch_assoc();
        $admin_name = $qry['name'];
        $admin_id = $qry['id'];
        
        $user = $this->db->query("SELECT name FROM info WHERE id = '$user_id'")->fetch_array()['name'];
        
        $data = " name = '$name' ".", email = '$email' ".", phoneNumber = '$number' ".", password = '$password' ";
        $data2 = " yr_level = '$year_level' ".", course = '$course' ".",about = '$about'";
        $query = "UPDATE `info` SET ".$data." WHERE `id` = $user_id";
        $query2 = "UPDATE `profile` SET ".$data2." WHERE `user_id` = $user_id";
        
        if ($this->db->query($query) === TRUE && $this->db->query($query2)) {
            $qry = $this->db->query("INSERT INTO activity_logs (logs,user_id) VALUES('$admin_name is updating the user $user','$admin_id')");
            if($qry){
                return true;
            }
        } else {
            return false;
        }
    }

    function updateAdmin($name,$email,$number,$password,$about){
        session_start();
        $admin_id = $_SESSION['admin_id'];
        $qry = $this->db->query("SELECT id, name FROM info WHERE id_num = '$admin_id'")->fetch_assoc();
        $admin_name = $qry['name'];
        $admin_id = $qry['id'];
        
        $data = " name = '$name' ".", email = '$email' ".", phoneNumber = '$number' ".", password = '$password' ";
        $query = "UPDATE `info` SET ".$data." WHERE `id` = $admin_id";
        $data2 = " about = '$about' ";
        $query2 = "UPDATE `profile` SET ".$data2." WHERE `user_id` = $admin_id";
        
        if ($this->db->query($query) === TRUE && $this->db->query($query2) === TRUE) {
            $qry = $this->db->query("INSERT INTO activity_logs (logs,user_id) VALUES('$admin_name is updating the its profile','$admin_id')");
            return $qry;
            if($qry){
                return true;
            }
        } else {
            return false;
        }

    }
    
    //This function delete user base on the condition
    function deleteUser($user_id) {
        session_start();
        $admin_id = $_SESSION['admin_id'];
        $qry = $this->db->query("SELECT id, name FROM info WHERE id_num = '$admin_id'")->fetch_assoc();
        $name = $qry['name'];
        $admin_id = $qry['id'];

        $user_name = $this->db->query("SELECT name FROM info WHERE id = '$user_id'")->fetch_array()['name'];
        
        $sql = "DELETE FROM info WHERE id = $user_id";
        $sql2 = "DELETE FROM profile WHERE user_id = $user_id";
        $result = $this->db->query($sql);
        $result2 = $this->db->query($sql2);
        if($result == true && $result2 == true){
            $qry = $this->db->query("INSERT INTO activity_logs (logs, user_id) VALUES('$name is deleting user $user_name','$admin_id')");
            return true;
        }else{
            return false;
        }
    }
    
    //This function retrieve all the user in the database and display in the page
    function getAllUser() {
        $data = array();
        // SQL query to retrieve data from the "info" table
        $sql = "SELECT info.*, profile.* FROM info INNER JOIN profile ON info.id = profile.user_id ORDER BY info.date DESC";
        $result = $this->db->query($sql);
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }

    //This function is use to search User 
    function searchUser($search){
        $data = array();
        $sql ="SELECT info.*, profile.* FROM info INNER JOIN profile ON info.id = profile.user_id WHERE CONCAT('',info.id_num,info.name,info.phoneNumber,info.email,info.status,DATE_FORMAT(info.date, '%M %d, %Y %h:%i %p')) LIKE CONCAT('%','$search', '%') ORDER BY info.date DESC";
        $result = $this->db->query($sql);
        if($result->num_rows > 0){
            while($user = $result->fetch_assoc()){
                $data[] = $user;
            }
        }
        return $data;
    }
    
    function addProfile(){
        extract($_POST);
        session_start();
        $admin_id = $_SESSION['admin_id'];
        
        $qry = $this->db->query("SELECT id, name FROM info WHERE id_num = '$admin_id'")->fetch_assoc();
        $name = $qry['name'];
        $admin_id = $qry['id'];
        
        //Directory of the image
        $targetDirectory = '../assets/img/';
        $targetFile = $targetDirectory . basename($_FILES['imageProfile']['name']);
        
        $user_name = $this->db->query("SELECT name FROM info WHERE id = '$userId'")->fetch_array()['name'];

        if(move_uploaded_file($_FILES['imageProfile']['tmp_name'], $targetFile)){
            $sql = $this->db->query("UPDATE `profile` SET `image_path`='$targetFile' WHERE `user_id`= '$userId'");
            if($sql){
                $qry = $this->db->query("INSERT INTO activity_logs (logs , user_id) VALUES ('$name is updating profile picture of $user_name','$admin_id')");
                return true;
            }
        }else{
            return false;
        }
    }
    function addAdminProfile(){
        extract($_POST);
        session_start();
        $admin_id = $_SESSION['admin_id'];
        
        $qry = $this->db->query("SELECT id, name FROM info WHERE id_num = '$admin_id'")->fetch_assoc();
        $name = $qry['name'];
        $admin_id = $qry['id'];
        
        //Directory of the image
        $targetDirectory = '../assets/img/';
        $targetFile = $targetDirectory . basename($_FILES['imageProfile1']['name']);


        if(move_uploaded_file($_FILES['imageProfile1']['tmp_name'], $targetFile)){
            $sql = $this->db->query("UPDATE `profile` SET `image_path`='$targetFile' WHERE `user_id`= '$admin_id'");
            if($sql){
                $qry = $this->db->query("INSERT INTO activity_logs (logs , user_id) VALUES ('$name is updating the profile picture','$admin_id')");
                return true;
            }
        }else{
            return false;
        }
    }

    function addFile($tmp_file){
        session_start();
        $admin_id = $_SESSION['admin_id'];
        extract($_POST);

        $qry = $this->db->query("SELECT id, name FROM info WHERE id_num = '$admin_id'")->fetch_assoc();
        $name = $qry['name'];
        $admin_id = $qry['id'];


        $fileDirectory = '../assets/fileUpload/';
        if($tmp_file != ''){
            $fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['fileDoc']['name'];
            $move = move_uploaded_file($tmp_file, $fileDirectory . $fname);

            $file = $_FILES['fileDoc']['name']; 
            $fileExtension = strtolower(pathinfo($file, PATHINFO_EXTENSION));

            if($move){
                $query =("INSERT INTO `uploaded_files`(`file_name`, `file_type`, `file_path`, `download_count`) VALUES ('$file','$fileExtension','$fname', '0')");
                $res = $this->db->query($query);
                if($res){
                    $qry = $this->db->query("INSERT INTO activity_logs (logs , user_id) VALUES ('$name is adding $file','$admin_id')");
                    return 1;
                }
            }
        }
    }
    
    function deleteFile($id){
        session_start();
        $admin_id = $_SESSION['admin_id'];
        
        $qry = $this->db->query("SELECT id, name FROM info WHERE id_num = '$admin_id'")->fetch_assoc();
        $name = $qry['name'];
        $admin_id = $qry['id'];
        
        $query = $this->db->query("SELECT file_path, file_name FROM uploaded_files WHERE id = $id")->fetch_assoc();
        $path = $query['file_path'];
        $file = $query['file_name'];
        
        $del1 = $this->db->query("DELETE FROM `Likes` WHERE `file_id` = '$id'");
        $del2 = $this->db->query("DELETE FROM `rating` WHERE `file_id` = '$id'");
        $del3 = $this->db->query("DELETE FROM `uploaded_files` WHERE `id` = '$id'");
        if($del3){
            $qry = $this->db->query("INSERT INTO activity_logs (logs , user_id) VALUES ('$name is deleting $file','$admin_id')");
            unlink('../assets/fileUpload/'.$path);
            return true;
        }else{
            return false;
        }
    }

    function getDocLike(){
        $data = array();

        $sql = $this->db->query("SELECT like.* FROM likes INNER JOIN uploaded_files ON likes.file_id = uploaded_files.id");
        if($sql){
            while($row = $sql->num_rows){
                $data[] = $row;
            }
        }
        return $data;
    }
    //This function is use to get all the document in the database
    function getAllDocument($action){
        $data = array();

        $sql = "SELECT * FROM uploaded_files ORDER BY date desc";
        $result = $this->db->query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $like = $action->countLike($row['id']);
                $row['like_count'] = $like;
                $data[] = $row;
            }
        }
        return $data;
    }

    //This function is use to search document
    function searchDoc($search, $action){
        $data = array();
        $sql ="SELECT * FROM uploaded_files WHERE CONCAT('',file_name,file_type,DATE_FORMAT(date, '%M %d, %Y %h:%i %p')) LIKE CONCAT('%','$search', '%') ORDER BY date DESC";
        $result = $this->db->query($sql);
        if($result->num_rows > 0){
            while($file = $result->fetch_assoc()){
                $like = $action->countLike($file['id']);
                $file['like_count'] = $like;
                $data[] = $file;
            }
        }
        return $data;
    }

    function downloadFile($id){
        session_start();
        $user_id = $_SESSION['admin_id'];
        
        $qry = "SELECT id,name FROM info WHERE id_num = '$user_id'";
        $res = $this->db->query($qry);
        $row = $res->fetch_assoc();
        $data = $row['id'];
        $name = $row['name'];

        $path ='../assets/fileUpload/';
        $file_name = $this->db->query("SELECT `file_name` FROM `uploaded_files` WHERE `id` = '$id'")->fetch_array()['file_name'];
        $qry = $this->db->query("SELECT `file_path` FROM `uploaded_files` WHERE `id` = '$id'")->fetch_array()['file_path'];

        if(file_exists($path . $qry)){
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($path.$qry) . '"');
            header('Content-Length: ' . filesize($path.$qry));
            if(readfile($path.$qry)){
            $sql = $this->db->query("INSERT INTO `download` (download,user_id,file_id) VALUES(1,'$data','$id')");
            $sql = $this->db->query("UPDATE `uploaded_files` SET `download_count` = download_count + 1 WHERE id = $id");
            $qry2 = $this->db->query("INSERT INTO activity_logs (logs, user_id) VALUES ('$name is downloading $file_name','$data')");
            }
            exit;
        }else{
            echo "<script>alert('file not found')</script>";
        }
    }

    function downloadCount($id){
        $qry = $this->db->query("SELECT download_count FROM uploaded_files WHERE id = '$id'");
        if($qry->num_rows > 0){
            $download_count = $qry->fetch_array()['download_count'];
            echo $download_count;
        }else{
            echo 0;
        }
    }

    function countLike($file_id){
        $qry = $this->db->query("SELECT COUNT(liked) as count FROM Likes WHERE file_id = '$file_id' AND liked = 1");
        $row = $qry->fetch_assoc();
        if($qry){
            return $row['count'];
        }else{
            return $row['count'];
        }
    }
    
    function getRate($file_id){
        $qry = $this->db->query("SELECT AVG(rate) as rate FROM rating WHERE file_id = '$file_id'");
        $row = $qry->fetch_assoc();
        if($qry){
            $formatted = round($row['rate'],1);
            return $formatted;
        }else{
            echo 'Error';
        }
    }

    function like($file_id){
        session_start();
        $admin_id = $_SESSION['admin_id'];

        $qry = $this->db->query("SELECT id, name FROM info WHERE id_num = '$admin_id'")->fetch_assoc();
        $data = $qry['id'];
        $name = $qry['name'];

        $qry = "SELECT file_name FROM uploaded_files WHERE id = '$file_id'";
        $res = $this->db->query($qry);
        $row = $res->fetch_assoc();
        $file_name = $row['file_name'];
        
        $qry_like = $this->db->query("SELECT * FROM `likes` WHERE `user_id` = '$data' AND `file_id` = '$file_id'");
        if($qry_like->num_rows > 0){
            $row = $qry_like->fetch_assoc();
            $liked = $row['liked'];
            $new_like_state = $liked ? 0 : 1;
            $query = "UPDATE Likes SET liked = $new_like_state WHERE file_id = $file_id AND user_id = '$data'";
            if($this->db->query($query)){
                $requery = $this->db->query("SELECT liked FROM Likes WHERE user_id = '$data' and file_id = '$file_id' ");
                $like_row = $requery->fetch_assoc();
                if($like_row['liked'] == 1){
                    $qry = $this->db->query("INSERT INTO activity_logs (logs, user_id) VALUES ('".$name." liked the file ".$file_name."','$data')");
                    return 1;
                }else{
                    $qry = $this->db->query("INSERT INTO activity_logs (logs, user_id) VALUES ('".$name." unliked the file ".$file_name."','$data')");
                    return 2;
                }
            }
        }else{
            $qry = $this->db->query("INSERT INTO Likes (file_id , user_id, liked) VALUES('$file_id','$data','1')");
            if($qry){
                $this->db->query("INSERT INTO activity_logs (logs, user_id) VALUES ('".$name." liked the file ".$file_name."','$data')");
                return true;
            }
        }

    }

    function getLikeVal($file_id){
        $user_id =$_SESSION['admin_id'];
        
        $qry = "SELECT id FROM info WHERE id_num = '$user_id'";
        $res = $this->db->query($qry);
        $row = $res->fetch_assoc();
        $data = $row['id'];

        $qry = $this->db->query("SELECT * FROM Likes WHERE file_id = '$file_id' AND user_id = '$data'");
        if($qry->num_rows > 0){
            $row = $qry->fetch_assoc();
            if($row['liked'] == 1){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    function getUserLogs($user){
        $data = array();

        $qry = $this->db->query("SELECT * From activity_logs WHERE user_id = '$user' ORDER BY date DESC");
        if($qry->num_rows > 0){
            while($rows = $qry->fetch_assoc()){
                $data[] = $rows;
            }
        }
        return $data;
    }
    function getAllLogs(){
        $data = array();

        $qry = $this->db->query("SELECT activity_logs.*, info.* From activity_logs INNER JOIN info ON activity_logs.user_id = info.id  ORDER BY activity_logs.date DESC");
        if($qry->num_rows > 0){
            while($rows = $qry->fetch_assoc()){
                $data[] = $rows;
            }
        }
        return $data;
    }

    function totalDownloads(){
        $data = 0;

        $qry = $this->db->query("SELECT download_count FROM uploaded_files");
        if($qry->num_rows > 0){
            while($rows = $qry->fetch_assoc()){
                $data = $rows['download_count'];
            }
        }
        return $data;
    }
    
    function totalLikes(){
        $data = array();
    
        $likes = $this->db->query("SELECT liked FROM Likes");
        if($likes->num_rows > 0){
            while($rows = $likes->fetch_assoc()){
                if($rows['liked'] == 1){
                    $data[] = $rows;
                }
            }
        }
    
        return $data;

    }

    function dlChart(){
        $data = array();
        $qry = $this->db->query("SELECT DATE(date) AS download_date, SUM(download) AS total_downloads FROM download GROUP BY DATE(date) ORDER BY DATE(date) DESC
        ");
        if($qry->num_rows > 0){
            while($row = $qry->fetch_assoc()){
                $data[] = $row;
            }
        }
        return $data;
    }

    function updateProfImage($baseimg, $user_id){
        $sql = $this->db->query("UPDATE profile SET image_path='$baseimg' WHERE user_id = $user_id");

        if($sql){
            return 1;
        }
    }

    function recentUpload(){
        $data = array();
        $qry = $this->db->query("SELECT * FROM uploaded_files ORDER BY date DESC LIMIT 3");
        if($qry->num_rows > 0){
            while($row = $qry->fetch_assoc()){
                $data[] = $row;
            }
        }
        return $data;
    }

}

?>