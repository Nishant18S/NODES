<?php
session_start(); // Start session

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.html"); // Redirect to login if not authenticated
    exit();
}

$loggedInUser = htmlspecialchars($_SESSION['user']); // Get the logged-in user's name

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile-pic'])) {
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "education";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $file = $_FILES['profile-pic'];
    if ($file['error'] === UPLOAD_ERR_OK) {
        $fileName = basename($file['name']);
        $targetDir = "uploads/";
        $targetFile = $targetDir . $fileName;

        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            // Update the profile picture in the database
            $stmt = $conn->prepare("UPDATE users SET profile_pic = ? WHERE name = ?");
            $stmt->bind_param("ss", $targetFile, $loggedInUser);
            $stmt->execute();
            $stmt->close();

            // Update the session variable
            $_SESSION['profile-pic'] = $targetFile;

            header("Location: Dashboard-EduNexus.php?update=success");
            exit();
        } else {
            echo "File upload failed.";
        }
    } else {
        echo "Error uploading file.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Update Profile Picture</title>
    <link rel="stylesheet" href="Dashboard-EduNexus.css" />
</head>
<body>
    <h1>Update Profile Picture</h1>
    <form action="update_image.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="profile-pic" accept="image/*" required />
        <button type="submit">Upload Profile Picture</button>
    </form>
</body>
</html>
