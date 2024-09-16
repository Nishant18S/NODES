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

$sql = "SELECT * FROM files";
$result = $conn->query($sql);

$files = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $files[] = $row;
    }
}

echo json_encode($files);

$conn->close();
?>
