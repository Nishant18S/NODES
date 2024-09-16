<?php
// Database connection details
$sourceServername = "localhost";
$sourceUsername = "root";
$sourcePassword = "";
$sourceDbname = "education";

$destinationServername = "localhost";
$destinationUsername = "root";
$destinationPassword = "";
$destinationDbname = "village";

// File directories
$sourceDir = 'C:/xampp/htdocs/Education/uploads/';
$destinationDir = 'C:/xampp/htdocs/NEW PROJECT/uploads/';

// Ensure the destination directory exists
if (!is_dir($destinationDir)) {
    mkdir($destinationDir, 0777, true);
}

// Create connection to the source database
$sourceConn = new mysqli($sourceServername, $sourceUsername, $sourcePassword, $sourceDbname);
if ($sourceConn->connect_error) {
    die("Source connection failed: " . $sourceConn->connect_error);
}

// Create connection to the destination database
$destinationConn = new mysqli($destinationServername, $destinationUsername, $destinationPassword, $destinationDbname);
if ($destinationConn->connect_error) {
    die("Destination connection failed: " . $destinationConn->connect_error);
}

// Fetch data from the source database
$sql = "SELECT date, user, fileName, class, subject FROM files";
$result = $sourceConn->query($sql);

if ($result->num_rows > 0) {
    // Prepare the insert statement for the destination database
    $insertStmt = $destinationConn->prepare("INSERT IGNORE INTO village_files (date, user, fileName, class, subject) VALUES (?, ?, ?, ?, ?)");

    while ($row = $result->fetch_assoc()) {
        // Insert the record into the destination database, ignoring duplicates
        $insertStmt->bind_param("sssis", $row['date'], $row['user'], $row['fileName'], $row['class'], $row['subject']);
        if ($insertStmt->execute()) {
            echo "Record for file " . $row['fileName'] . " copied successfully.<br>";
            
            // Copy the actual file from the source directory to the destination directory
            $sourceFile = $sourceDir . $row['fileName'];
            $destinationFile = $destinationDir . $row['fileName'];

            if (file_exists($sourceFile)) {
                if (copy($sourceFile, $destinationFile)) {
                    echo "File " . $row['fileName'] . " copied successfully.<br>";
                } else {
                    echo "Failed to copy file " . $row['fileName'] . ".<br>";
                }
            } else {
                echo "Source file " . $row['fileName'] . " does not exist.<br>";
            }

        } else {
            echo "Failed to copy record for file " . $row['fileName'] . ": " . $destinationConn->error . "<br>";
        }
    }

    echo "Data processing complete!<br>";
} else {
    echo "No records found in source database.<br>";
}

// Close database connections
$insertStmt->close();
$sourceConn->close();
$destinationConn->close();
?>
