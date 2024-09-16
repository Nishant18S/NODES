<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.html");
    exit();
}

$loggedInUser = $_SESSION['user']; // Get the logged-in user's name

// Check if a file was uploaded
if (isset($_FILES['profile-pic']) && $_FILES['profile-pic']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['profile-pic']['tmp_name'];
    $fileName = $_FILES['profile-pic']['name'];
    $fileSize = $_FILES['profile-pic']['size'];
    $fileType = $_FILES['profile-pic']['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));

    // Define allowed file extensions
    $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($fileExtension, $allowedExts)) {
        // Define upload path
        $uploadFileDir = 'uploads/profile_pics/';
        $dest_path = $uploadFileDir . $loggedInUser . '.' . $fileExtension;

        // Create upload directory if not exists
        if (!is_dir($uploadFileDir)) {
            mkdir($uploadFileDir, 0755, true);
        }

        // Move the uploaded file to the server
        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            // Update profile picture path in the database
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "education";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Escape user inputs
            $loggedInUserEscaped = $conn->real_escape_string($loggedInUser);
            $profilePicPath = $conn->real_escape_string($dest_path);

            // Update query
            $sql = "UPDATE users SET profile_pic = '$profilePicPath' WHERE username = '$loggedInUserEscaped'";

            if ($conn->query($sql) === TRUE) {
                // Update the session with new profile picture path
                $_SESSION['profile-pic'] = $dest_path;
                
                // Redirect after successful update
                header("Location: dashboard.php?update=success");
                exit();
            } else {
                echo "Error updating record: " . $conn->error;
            }

            $conn->close();
        } else {
            echo "There was an error moving the file.";
        }
    } else {
        echo "Upload failed. Allowed file types: jpg, jpeg, png, gif.";
    }
} else {
    echo "No file uploaded or there was an upload error.";
}
?>
