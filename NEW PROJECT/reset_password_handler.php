<?php
$servername = "localhost";
$username = "root";
$password = "Nishant2003@";
$dbname = "village";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user = $_POST['username'] ?? '';
$newPassword = $_POST['new_password'] ?? '';

if ($user && $newPassword) {
    $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

    // Update the user's password
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE name = ?");
    $stmt->bind_param("ss", $hashedPassword, $user);

    if ($stmt->execute() && $stmt->affected_rows > 0) {
        echo 'Your password has been reset successfully.';
    } else {
        echo 'Failed to reset password. Please try again.';
    }

    $stmt->close();
} else {
    echo 'Invalid request.';
}

$conn->close();
?>
