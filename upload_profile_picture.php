<?php
// Ensure that the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Check if the file was uploaded without errors
    if (isset($_FILES["profile_picture"]) && $_FILES["profile_picture"]["error"] == UPLOAD_ERR_OK) {
        
        // Define the upload directory
        $uploadDirectory = "assets/profile/"; // Change this to your desired directory

        // Create the upload directory if it doesn't exist
        if (!file_exists($uploadDirectory)) {
            mkdir($uploadDirectory, 0777, true);
        }

        // Get the original name of the uploaded file
        $originalFileName = $_FILES["profile_picture"]["name"];

        // Generate a unique name for the uploaded file
        $uniqueFileName = uniqid() . "_" . $originalFileName;

        // Construct the full path to save the file
        $targetFilePath = $uploadDirectory . $uniqueFileName;

        // Move the uploaded file to the destination
        if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $targetFilePath)) {
            // File upload successful

            // Include the database connection file
            include 'conn.php';

            // Get the user ID from the session
            session_start();
            $user_id = $_SESSION['user_id'];
            

            // Example SQL update statement
            $id = $conn->query("SELECT * FROM info WHERE id_num = '$user_id'")->fetch_array()['id'];
            $updateQuery = "UPDATE profile SET image_path = '$targetFilePath' WHERE user_id = '$id'";
            $result = $conn->query($updateQuery);

            if ($result) {
                // Database update successful

                // Redirect to the profile page or any other page as needed
                header("Location: profile.php");
                exit();
            } else {
                // Error in updating the database
                echo "Error updating the database: " . $conn->error;
            }
        } else {
            // Failed to move the file
            echo "Error uploading the file.";
        }
    } else {
        // Error in the file upload
        echo "Error: " . $_FILES["image_path"]["error"];
    }
} else {
    // Redirect to the form page if accessed directly without submission
    header("Location: profile.php");
    exit();
}
?>
