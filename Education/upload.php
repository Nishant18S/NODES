<?php
session_start(); // Start session

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.html"); // Redirect to login if not authenticated
    exit();
}

$loggedInUser = htmlspecialchars($_SESSION['user']); // Get the logged-in user's name

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
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileName = $_FILES['file']['name'];
    $fileNameNew = pathinfo($fileName, PATHINFO_FILENAME) . '_' . uniqid() . '.' . pathinfo($fileName, PATHINFO_EXTENSION);
    $fileDestination = 'uploads/' . $fileNameNew;

    $class = $_POST['class'];
    $subject = $_POST['subject'];
    $date = date('Y-m-d H:i:s');
    $user = $_SESSION['user']; // Use session to get the logged-in user's name

    // Move file to the uploads directory
    if (move_uploaded_file($fileTmpName, $fileDestination)) {
        // Store file information in database
        $stmt = $conn->prepare("INSERT INTO files (date, user, fileName, class, subject) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $date, $user, $fileNameNew, $class, $subject);

        if ($stmt->execute()) {
            // Success: Display alert and redirect
            echo "<script>
                    alert('File uploaded successfully.');
                    window.location.href = 'Dashboard-EduNexus.php'; // Change to the desired redirect URL
                  </script>";
        } else {
            // Error: Display error message
            echo "<script>
                    alert('Error uploading file: " . htmlspecialchars($stmt->error, ENT_QUOTES, 'UTF-8') . "');
                    window.location.href = 'Dashboard-EduNexus.php'; // Change to the desired redirect URL
                  </script>";
        }

        $stmt->close();
    } else {
        // Error: Failed to move uploaded file
        echo "<script>
                alert('Failed to upload file.');
                window.location.href = 'Dashboard-EduNexus.php'; // Change to the desired redirect URL
              </script>";
    }
}

$conn->close();
?>
