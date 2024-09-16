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

// Query to fetch files from the database
$sql = "SELECT date, user, fileName, class, subject FROM files";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>Date</th>
                <th>User</th>
                <th>File Name</th>
                <th>Class</th>
                <th>Subject</th>
                <th>Action</th>
            </tr>";
    
    // Output each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['date'] . "</td>
                <td>" . $row['user'] . "</td>
                <td><a href='uploads/" . $row['fileName'] . "' download>" . $row['fileName'] . "</a></td>
                <td>" . $row['class'] . "</td>
                <td>" . $row['subject'] . "</td>
                <td><form method='POST' action='delete_file.php'>
                        <input type='hidden' name='fileName' value='" . $row['fileName'] . "'>
                        <button type='submit'>Delete</button>
                    </form>
                </td>
            </tr>";
    }
    echo "</table>";
} else {
    echo "No files found.";
}

$conn->close();
?>
