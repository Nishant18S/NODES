<?php
session_start();

// Define the directory where the profile pictures will be saved
$target_dir = "uploads/profile-pics/";
$target_file = $target_dir . basename($_FILES["profile-pic"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if the file is an actual image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["profile-pic"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}

// Check file size (optional - limit to 5MB)
if ($_FILES["profile-pic"]["size"] > 5000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Allow only certain file formats (JPEG, PNG, GIF)
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" 
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
} else {
    // If everything is okay, try to upload the file
    if (move_uploaded_file($_FILES["profile-pic"]["tmp_name"], $target_file)) {
        // Set session variable for the profile picture path
        $_SESSION['profile-pic'] = $target_file;
        echo "The file ". htmlspecialchars( basename( $_FILES["profile-pic"]["name"])). " has been uploaded.";
        // Redirect back to the dashboard or user profile page
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>
