<?php
$servername = "localhost";
$username = "root";
$password = "Nishant2003@";
$dbname = "village";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_POST['username'];
$password = $_POST['password'];

// Prepare and execute the query
$stmt = $conn->prepare("SELECT * FROM users WHERE name = ? AND password = ?");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo 'Login successful';
} else {
    echo 'Invalid username or password';
}

$stmt->close();
$conn->close();
?>
