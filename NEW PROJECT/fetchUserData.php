<?php
// fetchUserData.php

header('Content-Type: application/json');

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

// Fetch username and profile picture based on user ID
$userId = $_GET['userId']; // or get userId from session or other source
$sql = "SELECT username, profile_picture FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

// Output as JSON
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    echo json_encode($user);
} else {
    echo json_encode(array("username" => "Guest", "profile_picture" => "default.png"));
}

$stmt->close();
$conn->close();
?>
