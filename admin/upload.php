<?php
include '../conn.php';
include 'admin_class.php';


$action = new Admin();
if(isset($_FILES['file'])){
    $file = $_FILES['file']['tmp_name'];
    
    $action->addFile($file);
}

if(isset($_GET['id'])){
    $id = $_GET['id'];

    echo "<script>
            const result = confirm('Are you sure you want to delete?');

            if(result){
                window.location.href='deleteData.php?file_id=$id';
            }else{
                window.location.href='repository.php';
            }
        </script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Document</title>
    <?php include 'header.php';?>
    <style>
        .backgr{
            background: linear-gradient(289deg, #bdc4ef, #e6c9c9);
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <?php include 'topbar.php';?>
        <?php include 'sidebar.php';?>
        <div class="backgr content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2 text-center">
                        <div class="col-sm-12">
                            <h1 class="m-0">
                                File Repository
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="content">
                <div class="container-fluid">
                    <div class="container-sm">
                        <form method="post" action="" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="file">Choose a file: </label>
                                <input type="file" class="form-control-file" name="file" id="file" accept=".doc, .docx, .pdf">
                            </div>
                            <button>Upload</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>