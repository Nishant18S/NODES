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

// Fetch data from the village_files table
$sql = "SELECT date, user, fileName, class, subject FROM village_files";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Village Files</title>
    <link rel="stylesheet" href="styles.css" />
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #e9e9e9;
        }
    </style>
</head>
<body>

<h1>Village Files</h1>

<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>User</th>
            <th>File Name</th>
            <th>Class</th>
            <th>Subject</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>" . htmlspecialchars($row['date']) . "</td>
                    <td>" . htmlspecialchars($row['user']) . "</td>
                    <td><a href='uploads/" . htmlspecialchars($row['fileName']) . "' download>" . htmlspecialchars($row['fileName']) . "</a></td>
                    <td>" . htmlspecialchars($row['class']) . "</td>
                    <td>" . htmlspecialchars($row['subject']) . "</td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No records found</td></tr>";
        }
        ?>
    </tbody>
</table>

<?php
// Close connection
$conn->close();
?>

</body>
</html>
