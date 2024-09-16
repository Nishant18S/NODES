<?php
// updateProfilePicture.php

// Database connection parameters
$servername = "localhost";
$username = "root"; // replace with your MySQL username
$password = "Nishant2003@"; // replace with your MySQL password
$dbname = "village"; // replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if a file was uploaded
if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
    // Get user ID from POST data
    $userId = intval($_POST['userId']);
    
    // File upload parameters
    $targetDir = "uploads/"; // Directory to save the uploaded file
    $fileName = basename($_FILES["profile_picture"]["name"]);
    $targetFile = $targetDir . $fileName;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Validate file type (optional)
    $allowedTypes = array("jpg", "jpeg", "png", "gif");
    if (!in_array($fileType, $allowedTypes)) {
        echo json_encode(array("status" => "error", "message" => "Invalid file type."));
        exit;
    }

    // Move the uploaded file to the target directory
    if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $targetFile)) {
        // Update the database with the new file name
        $sql = "UPDATE users SET profile_picture = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $fileName, $userId);
        
        if ($stmt->execute()) {
            echo json_encode(array("status" => "success", "message" => "Profile picture updated successfully."));
        } else {
            echo json_encode(array("status" => "error", "message" => "Database update failed."));
        }

        $stmt->close();
    } else {
        echo json_encode(array("status" => "error", "message" => "File upload failed."));
    }
} else {
    echo json_encode(array("status" => "error", "message" => "No file uploaded or file upload error."));
}

$conn->close();
?>
