<?php
$dsn = 'mysql:host=localhost;dbname=education';
$username = 'your_db_user';
$password = 'your_db_password';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>
