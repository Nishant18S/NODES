<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "village";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get parameters
$class = isset($_POST['class']) ? $_POST['class'] : '';
$subject = isset($_POST['subject']) ? $_POST['subject'] : '';

// Prepare SQL query
$sql = "SELECT date, user, fileName, subject FROM village_files WHERE class = ? AND subject = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Failed to prepare SQL statement: " . $conn->error);
}

$stmt->bind_param("ss", $class, $subject);
$stmt->execute();
$result = $stmt->get_result();

// Fetch results
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Output JSON
header('Content-Type: application/json');
echo json_encode($data);

// Close connection
$stmt->close();
$conn->close();
?>
