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

$name = $_POST['name'];
$password = $_POST['password'];

// Use prepared statements to avoid SQL injection
$stmt = $conn->prepare("INSERT INTO users (name, password) VALUES (?, ?)");
$stmt->bind_param("ss", $name, $password);

if ($stmt->execute()) {
    echo "Registration successful!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
