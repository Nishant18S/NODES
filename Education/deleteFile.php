<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "education";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fileName = $_POST['fileName'];

    $stmt = $conn->prepare("DELETE FROM files WHERE fileName = ?");
    $stmt->bind_param("s", $fileName);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => $stmt->error]);
    }

    $stmt->close();
}

$conn->close();
?>
