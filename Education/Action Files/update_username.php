<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "Nishant2003@";
$dbname = "village";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get POST data
$new_username = isset($_POST['username']) ? $_POST['username'] : '';

// Validate and sanitize input
if (empty($new_username)) {
    echo json_encode(['success' => false, 'error' => 'Username cannot be empty.']);
    exit();
}

// Assuming you have a session or some way to get the current user ID
// For example, we'll use a dummy user ID here
$user_id = 1; 

// Prepare and bind
$stmt = $conn->prepare("UPDATE users SET username = ? WHERE id = ?");
$stmt->bind_param("si", $new_username, $user_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Failed to update username.']);
}

// Close connection
$stmt->close();
$conn->close();
?>
