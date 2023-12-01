<?php

class Admin{
    private $db;

    function __construct(){
        include '../conn.php';

        $this->db = $conn;
    }

    function __destruct(){
        $this->db->close();
    }

    function login(){
        extract($_POST);
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
    function updateUser($user_id,$name,$course,$year_level,$email,$number,$password){
        session_start();
        $admin_id = $_SESSION['admin_id'];
        $qry = $this->db->query("SELECT id, name FROM info WHERE id_num = '$admin_id'")->fetch_assoc();
        $admin_name = $qry['name'];
        $admin_id = $qry['id'];
        
        $user = $this->db->query("SELECT name FROM info WHERE id = '$user_id'")->fetch_array()['name'];
        
        $data = " name = '$name' ".", email = '$email' ".", phoneNumber = '$number' ".", password = '$password' ";
        $data2 = " yr_level = '$year_level' ".", course = '$course' ";
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

    function updateAdmin($user_id,$name,$email,$number,$password){
        session_start();
        $admin_id = $_SESSION['admin_id'];
        $qry = $this->db->query("SELECT id, name FROM info WHERE id_num = '$admin_id'")->fetch_assoc();
        $admin_name = $qry['name'];
        $admin_id = $qry['id'];
        
        $user = $this->db->query("SELECT name FROM info WHERE id = '$user_id'")->fetch_array()['name'];
        
        $data = " name = '$name' ".", email = '$email' ".", phoneNumber = '$number' ".", password = '$password' ";
        $query = "UPDATE `info` SET ".$data." WHERE `id` = $user_id";
        
        if ($this->db->query($query) === TRUE) {
            $qry = $this->db->query("INSERT INTO activity_logs (logs,user_id) VALUES('$admin_name is updating the user $user','$admin_id')");
            if($qry){
                return true;
            }
        } else {
            return false;
        }

    }
    function updateAbout($user_id,$about){
        session_start();
        $admin_id = $_SESSION['admin_id'];
        $qry = $this->db->query("SELECT id, name FROM info WHERE id_num = '$admin_id'")->fetch_assoc();
        $admin_name = $qry['name'];
        $admin_id = $qry['id'];
        
        $user = $this->db->query("SELECT name FROM info WHERE id = '$user_id'")->fetch_array()['name'];
        
        $data2 = " about = '$about' ";
        $query2 = "UPDATE `profile` SET ".$data2." WHERE `user_id` = $user_id";
        
        if ($this->db->query($query2) == true) {
            $qry = $this->db->query("INSERT INTO activity_logs (logs,user_id) VALUES('$admin_name is updating the user $user','$admin_id')");
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
        $sql = "SELECT * FROM info ORDER BY date DESC";
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
        $sql ="SELECT * FROM info WHERE CONCAT('',id_num,name,phoneNumber,email,status,DATE_FORMAT(date, '%M %d, %Y %h:%i %p')) LIKE CONCAT('%','$search', '%')";
        $result = $this->db->query($sql);
        if($result->num_rows > 0){
            while($user = $result->fetch_assoc()){
                echo '<tr>';
                echo '<td>' . $user['id_num'] . '</td>';
                echo '<td>' . $user['name'] . '</td>';
                echo '<td>' . $user['phoneNumber'] . '</td>';
                echo '<td>' . $user['email'] . '</td>';
                echo '<td>' . $user['status'] . '</td>';
                echo '<td>' . date("F j, Y g:i A", strtotime($user['date'])) . '</td>';
                echo '<td>';
                echo '<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#viewDatass" data-id="'. $user['id'] .'">View</button>&nbsp;&nbsp';
                echo '<button class="delUser btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteUser" data-id="'. $user['id'] .'">Delete</button>';
                echo '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="7">No users found.</td></tr>';
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
            $fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['file']['name'];
            $move = move_uploaded_file($tmp_file, $fileDirectory . $fname);

            if($move){
                $file = $_FILES['file']['name']; 
                $fileExtension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                $query = $this->db->query("INSERT INTO `uploaded_files`(`file_name`, `file_type`, `file_path`) VALUES ('$file','$fileExtension','$fname')");
                if($query){
                    $qry = $this->db->query("INSERT INTO activity_logs (logs , user_id) VALUES ('$name is adding $file','$admin_id')");
                    echo "<script>alert('Uploaded File');window.location.href='repository.php';</script>";
                }else{
                    echo "<script>alert('Failed to Upload File');window.location.href='repository.php';</script>";
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


    //This function is use to get all the document in the database
    function getAllDocument(){
        $data = array();

        $sql = "SELECT * FROM uploaded_files ORDER BY date desc";
        $result = $this->db->query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $data[] = $row;
            }
        }
        return $data;
    }

    //This function is use to search document
    function searchDoc($search, $action){
        $sql ="SELECT * FROM uploaded_files WHERE CONCAT('',file_name,file_type,DATE_FORMAT(date, '%M %d, %Y %h:%i %p')) LIKE CONCAT('%','$search', '%')";
        $result = $this->db->query($sql);
        if($result->num_rows > 0){
            while($file = $result->fetch_assoc()){
                echo '<tr>';
                echo '<td>' . $file['file_name'] . '</td>';
                echo '<td>' . $file['file_type'] . '</td>';
                echo '<td>' . $action->countLike($file['id']) . '</td>';
                echo '<td>' . $action->getRate($file['id']) . '</td>';
                echo '<td>' . $file['download_count'] . '</td>';
                echo '<td>' . date("F j, Y g:i A", strtotime($file['date'])) . '</td>';
                ?>
                    <td><?php if($action->getLikeVal($file['id']) == true){?>
                        <button class="like like-liked" data-id="<?= $file['id']?>"><i class="fa fa-regular fa-thumbs-up"></i></button>
                    <?php }else{?>
                        <button class="like" data-id="<?= $file['id']?>"><i class="fa fa-regular fa-thumbs-up"></i></button>
                    <?php }?>
                    </td>
                <?php
                echo '<td>';
                echo '<button class="btn btn-primary btn-sm" onclick="window.location.href=\'download.php?file=' . $file['id'] . '\'">Update</button>';
                echo '<button class="delete-btn btn btn-danger btn-sm" data-id="'.$file['id'].'">Delete</button>';
                echo '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="7">No file found.</td></tr>';
        }
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

        $qry_like = $this->db->query("SELECT * FROM Likes WHERE file_id = '$file_id' AND user_id = '$data'");
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
                }else{
                    $qry = $this->db->query("INSERT INTO activity_logs (logs, user_id) VALUES ('".$name." unliked the file ".$file_name."','$data')");
                }
            }
        }else{
            $qry = $this->db->query("INSERT INTO Likes (file_id , user_id, liked) VALUES('$file_id','$data','1')");
            if($qry){
                $this->db->query("INSERT INTO activity_logs (logs, user_id) VALUES ('".$name." liked the file ".$file_name."','$data')");
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