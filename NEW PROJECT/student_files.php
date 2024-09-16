<?php
// Start session
session_start();

// Include database connection
include 'db_connection.php'; // Ensure this file contains $conn for DB connection

// Assuming the logged-in user ID is stored in session
$loggedInUserId = $_SESSION['user_id'];

// Step 1: Fetch student data based on user_id
$queryStudent = "SELECT class, subject FROM students WHERE user_id = ?";
$stmtStudent = $conn->prepare($queryStudent);
$stmtStudent->bind_param("i", $loggedInUserId);
$stmtStudent->execute();
$resultStudent = $stmtStudent->get_result();

if ($resultStudent->num_rows > 0) {
    $studentData = $resultStudent->fetch_assoc();
    $class = $studentData['class'];
    $subject = $studentData['subject'];

    echo "Class: " . $class . "<br>";
    echo "Subject: " . $subject . "<br><br>";

    // Step 2: Fetch files related to the student's class and subject
    $queryFiles = "SELECT file_name, file_path FROM files WHERE class = ? AND subject = ?";
    $stmtFiles = $conn->prepare($queryFiles);
    $stmtFiles->bind_param("ss", $class, $subject);
    $stmtFiles->execute();
    $resultFiles = $stmtFiles->get_result();

    if ($resultFiles->num_rows > 0) {
        echo "Available files:<br>";
        while ($file = $resultFiles->fetch_assoc()) {
            echo "<a href='" . $file['file_path'] . "' target='_blank'>" . $file['file_name'] . "</a><br>";
        }
    } else {
        echo "No files available for this class and subject.";
    }
} else {
    echo "No student data found for this user.";
}

// Close connections
$stmtStudent->close();
$stmtFiles->close();
$conn->close();
?>
