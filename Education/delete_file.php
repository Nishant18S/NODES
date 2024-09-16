<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "education";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve fileName from POST data
    $fileName = $_POST['fileName'];
    // Specify the file path in the uploads folder
    $filePath = 'uploads/' . $fileName;

    // Check if the file exists before attempting to delete it
    if (file_exists($filePath)) {
        // Attempt to delete the file from the server
        if (unlink($filePath)) {
            // Prepare and execute the SQL statement to delete the record from the database
            $stmt = $conn->prepare("DELETE FROM files WHERE fileName = ?");
            $stmt->bind_param("s", $fileName);

            if ($stmt->execute()) {
                // Use htmlspecialchars to prevent XSS
                $message = htmlspecialchars('File deleted successfully.');
                echo "<script>alert('$message'); window.location.href = 'Dashboard-EduNexus.php';</script>";
            } else {
                // Use htmlspecialchars to prevent XSS
                $error = htmlspecialchars('Error deleting file from database: ' . $stmt->error);
                echo "<script>alert('$error'); window.location.href = 'Dashboard-EduNexus.php';</script>";
            }

            $stmt->close();
        } else {
            // Error deleting the file
            echo "<script>alert('Error deleting file from server.'); window.location.href = 'Dashboard-EduNexus.php';</script>";
        }
    } else {
        // File does not exist
        echo "<script>alert('File not found on the server.'); window.location.href = 'Dashboard-EduNexus.php';</script>";
    }
}

$conn->close();
?>
