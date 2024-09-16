<?php
session_start(); // Start session at the beginning

// Database connection details
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = "Nishant2003@"; // Replace with your MySQL password
$dbname = "education"; // Replace with your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$email = $_POST['email'];
$password = $_POST['password'];

// Prepare and execute query
$sql = "SELECT user_id, name, password FROM users WHERE email=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Check if a matching user was found
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    
    // Check if the provided password matches the stored plain text password
    if ($password === $user['password']) {
        // User authenticated
        $_SESSION['user'] = $user['name']; // Store the username in session
        header("Location: Dashboard-EduNexus.php"); // Use PHP extension for dashboard
        exit(); // Ensure no further code is executed
    } else {
        echo "Invalid email or password";
    }
} else {
    echo "Invalid email or password";
}

// Close connections
$stmt->close();
$conn->close();
?>
