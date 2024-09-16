<?php
session_start(); // Start session

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.html"); // Redirect to login if not authenticated
    exit();
}

$loggedInUser = htmlspecialchars($_SESSION['user']); // Get the logged-in user's name

// Handle image update success message
$updateMessage = '';
if (isset($_GET['update']) && $_GET['update'] === 'success') {
    $updateMessage = 'Profile picture updated successfully!';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard - EduNexus</title>
    <link rel="icon" type="image/x-icon" href="https://icon-library.com/images/admin-login-icon/admin-login-icon-15.jpg">
    <link rel="stylesheet" href="Dashboard-EduNexus.css" />
    <style>
        /* General Body Styles */
        body {
            background-color: #121212; /* Dark background */
            color: #e0e0e0; /* Light text color */
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            display: flex;
            align-items: center;
            background-color: #1e1e1e;
            padding: 10px 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
        }

        .logo img {
            height: 40px;
            margin-right: 10px;
        }

        h1 {
            flex-grow: 1;
            margin: 0;
            font-size: 1.5em;
            color: #ffffff;
        }

        .user-info {
            display: flex;
            align-items: center;
            color: #e0e0e0;
        }

        .user-info img {
            height: 30px;
            margin-left: 10px;
        }

        .hamburger-btn {
            background: none;
            border: none;
            cursor: pointer;
        }

        .upload-container {
            padding: 20px;
            background-color: #1e1e1e;
        }

        .upload-box {
            margin-bottom: 10px;
        }

        .upload-label {
            display: block;
            padding: 10px;
            background-color: #333;
            color: #e0e0e0;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .upload-label:hover {
            background-color: #444;
        }

        .upload-btn {
            padding: 2px 20px;
            background-color: #007bff;
            color: #ffffff;
            border: none;
            border-radius: 15px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .upload-btn:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        .filter-section {
            padding: 20px;
            background-color: #1e1e1e;
        }

        .filter-container {
            display: flex;
            gap: 10px;
        }

        .filter-btn {
            padding: 10px;
            background-color: #333;
            color: #e0e0e0;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .filter-btn:hover {
            background-color: #444;
            transform: scale(1.05);
        }

        .main-filter-btn {
            padding: 10px 20px;
            background-color: #28a745;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .main-filter-btn:hover {
            background-color: #218838;
            transform: scale(1.05);
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th, td {
            border: 1px solid #333;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #444;
        }

        tr:nth-child(even) {
            background-color: #2a2a2a;
        }

        tr:hover {
            background-color: #555;
        }

        .remove-btn {
            padding: 5px 10px;
            background-color: #dc3545;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .remove-btn:hover {
            background-color: #c82333;
        }
        /* Add this to your existing CSS */
.filter-btn.active {
    background-color: #007bff; /* Change this to any color you prefer */
    color: #ffffff; /* Text color for active state */
}
/* Dropdown Menu Styles */
.dropdown-menu {
    display: none;
    position: absolute;
    right: 20px;
    top: 60px;
    background-color: #333;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    z-index: 1000;
}

.dropdown-menu ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.dropdown-menu li {
    padding: 10px 20px;
}

.dropdown-menu li a,
.dropdown-menu li button {
    color: #ffffff;
    text-decoration: none;
    display: block;
    width: 100%;
    text-align: left;
    border: none;
    background: none;
    cursor: pointer;
}

.dropdown-menu li:hover {
    background-color: #444;
}

/* Hamburger Menu */
.hamburger-btn {
    background: none;
    border: none;
    cursor: pointer;
    position: relative;
}

.hamburger-icon {
    width: 30px;
    height: 30px;
}
/* Styles for the upload section */
.upload-container {
    width: 90%;
    height: 200px;
    max-width: 60%;
    margin: 20px auto;
    padding: 30px;
    background-color: #222;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    color: #fff;
    animation: fadeIn 1s ease-in-out;
}

.upload-container form {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
}

.upload-container label {
    flex: 1;
    font-size: 14px;
    color: #ccc;
    margin-bottom: 5px;
    transition: color 0.3s ease;
}

.upload-container select,
.upload-container input[type="file"] {
    flex: 2;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #555;
    border-radius: 5px;
    background-color: #333;
    color: #fff;
    transition: background-color 0.3s ease, border 0.3s ease;
}

.upload-container select:focus,
.upload-container input[type="file"]:focus {
    background-color: #444;
    border: 1px solid #aaa;
    outline: none;
}

.upload-container button {
    padding: 12px 20px;
    font-size: 16px;
    color: #fff;
    background-color: #007bff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.3s ease;
    display: block;
    width: 100%;
    margin-top: 10px;
}

.upload-container button:hover {
    background-color: #0056b3;
    transform: scale(1.05);
}

/* Keyframe for fade-in animation */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
/* Multicolor animation for buttons */
@keyframes multicolor {
    0% {
        background-color: #ff007f; /* Pink */
        color: #fff;
    }
    25% {
        background-color: #7f00ff; /* Purple */
        color: #fff;
    }
    50% {
        background-color: #007fff; /* Blue */
        color: #fff;
    }
    75% {
        background-color: #00ff7f; /* Green */
        color: #fff;
    }
    100% {
        background-color: #ff7f00; /* Orange */
        color: #fff;
    }
}

/* Apply the multicolor animation to buttons */
.multicolor-btn {
    padding: 12px 20px;
    font-size: 16px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    background-color: #ff007f; /* Initial color */
    color: #fff;
    animation: multicolor 4s linear infinite; /* Animation duration and looping */
    transition: transform 0.3s ease;
}

/* Hover effect for multicolor button */
.multicolor-btn:hover {
    transform: scale(1.05);
}
/* Background Gradient Animation */
@keyframes backgroundGradient {
    0% {
        background-color: #121212;
    }
    25% {
        background-color: #1e1e1e;
    }
    50% {
        background-color: #333;
    }
    75% {
        background-color: #1e1e1e;
    }
    100% {
        background-color: #121212;
    }
}

body {
    background-color: #121212;
    color: #e0e0e0;
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    animation: backgroundGradient 10s ease-in-out infinite;
}

/* Button Pulse Animation */
@keyframes pulse {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.1);
    }
    100% {
        transform: scale(1);
    }
}

.upload-btn,
.filter-btn,
.main-filter-btn,
.remove-btn,
.multicolor-btn {
    animation: pulse 2s ease-in-out infinite;
}

/* Multicolor Button Animation */
@keyframes multicolor {
    0% {
        background-color: #ff007f; /* Pink */
        color: #fff;
    }
    25% {
        background-color: #7f00ff; /* Purple */
        color: #fff;
    }
    50% {
        background-color: #007fff; /* Blue */
        color: #fff;
    }
    75% {
        background-color: #00ff7f; /* Green */
        color: #fff;
    }
    100% {
        background-color: #ff7f00; /* Orange */
        color: #fff;
    }
}

.multicolor-btn {
    padding: 12px 20px;
    font-size: 16px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    background-color: #ff007f; /* Initial color */
    color: #fff;
    animation: multicolor 4s linear infinite, pulse 2s ease-in-out infinite; /* Added pulse animation */
    transition: transform 0.3s ease;
}

/* Hover effect for buttons */
.upload-btn:hover,
.filter-btn:hover,
.main-filter-btn:hover,
.remove-btn:hover,
.multicolor-btn:hover {
    background-color: #0056b3;
    transform: scale(1.05);
    animation-play-state: paused; /* Pause animation on hover */
}

/* Dropdown Menu Animation */
@keyframes slideDown {
    0% {
        opacity: 0;
        transform: translateY(-10px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

.dropdown-menu {
    display: none;
    position: absolute;
    right: 20px;
    top: 60px;
    background-color: #333;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    z-index: 1000;
    animation: slideDown 0.3s ease forwards;
}

.hamburger-btn:focus + .dropdown-menu,
.hamburger-btn:hover + .dropdown-menu {
    display: block;
}
/* Multicolor Animation */
@keyframes multicolor {
    0% {
        background-color: #ff007f; /* Pink */
        color: #ffffff;
    }
    20% {
        background-color: #7f00ff; /* Purple */
        color: #ffffff;
    }
    40% {
        background-color: #007fff; /* Blue */
        color: #ffffff;
    }
    60% {
        background-color: #00ff7f; /* Green */
        color: #ffffff;
    }
    80% {
        background-color: #ff7f00; /* Orange */
        color: #ffffff;
    }
    100% {
        background-color: #ff007f; /* Pink */
        color: #ffffff;
    }
}

/* Apply Multicolor Animation to the Button */
.multicolor-btn {
    padding: 12px 20px;
    font-size: 16px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    animation: multicolor 5s linear infinite; /* 5 seconds for a full loop, infinite repetition */
    transition: transform 0.3s ease;
}

/* Hover effect for multicolor button */
.multicolor-btn:hover {
    transform: scale(1.05);
}
a
{
    text-decoration:none;
    color:green;
}
    </style>
</head>
<body>
<header>
        <div class="logo">
            <img src="EduNexusBg.png" class="edunexus-logo" alt="EduNexus Logo" />
        </div>
        <h1>EduNexus</h1>
        <!-- User Info Section -->
        <div class="user-info">
            <span>Hello, <span id="user-name"><?php echo $loggedInUser; ?></span></span>
            <!-- Display the uploaded profile picture or a default icon -->
            <img src="<?php echo isset($_SESSION['profile-pic']) ? $_SESSION['profile-pic'] : 'user_icon.png'; ?>" 
                 alt="User Icon" 
                 id="user-icon" 
                 style="width:50px; height:50px; border-radius:50%;" />
        </div>

        <!-- Hamburger Button with Dropdown -->
        <button aria-label="Menu" class="hamburger-btn" id="hamburger-btn">
            <img src="hamburger.png" alt="Hamburger Icon" class="hamburger-icon" />
        </button>

        <!-- Dropdown Menu -->
        <div id="dropdown-menu" class="dropdown-menu">
            <ul>
                <li><a href="logout.php" id="logout-btn">Logout</a></li>
                <li><a href="update_image.php">Update Profile Picture</a></li>
            </ul>
        </div>
    </header>

    <!-- Display update message if available -->
    <?php if ($updateMessage): ?>
        <div class="update-message">
            <?php echo $updateMessage; ?>
        </div>
    <?php endif; ?>
    

    <!-- Upload Section -->
    <div class="upload-container">
        <form action="upload.php" method="POST" enctype="multipart/form-data">
            <label for="class">Select Class:</label>
            <select name="class" id="class">
                <option value="">Select</option>
                <option value="8">Class 8</option>
                <option value="9">Class 9</option>
                <option value="10">Class 10</option>
            </select>

            <label for="subject">Select Subject:</label>
            <select name="subject" id="subject">
                <option value="">Select</option>
                <option value="Physics">Physics</option>
                <option value="Math">Math</option>
                <option value="Chemistry">Chemistry</option>
                <option value="Biology">Biology</option>
            </select>
            <label for="file">Upload File:</label>
            <input type="file" name="file" id="file" required>

            <button type="submit">Upload</button>
        </form>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <div class="filter-container">
            <button class="filter-btn" data-filter="date">Date</button>
            <button class="filter-btn" data-filter="name">Name</button>
            <button class="filter-btn" data-filter="file-id">File ID</button>
            <button class="multicolor-btn" onclick="applyFilter()">FILTER <span>🔍</span></button>
        </div>
    </div>

    <!-- Files Table Section -->
    <table id="files-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Name</th>
                <th>File ID</th>
                <th>Class</th>
                <th>Subject</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch files from the database and display them
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "education";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT date, user, fileName, class, subject FROM files";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $filePath = 'uploads/' . htmlspecialchars($row['fileName']);
                    if (file_exists($filePath)) {
                        echo "<tr data-date='" . htmlspecialchars($row['date']) . "' data-name='" . htmlspecialchars($row['user']) . "' data-file-id='" . htmlspecialchars($row['fileName']) . "'>
                            <td>" . htmlspecialchars($row['date']) . "</td>
                            <td>" . htmlspecialchars($row['user']) . "</td>
                            
                            <td><a href='$filePath' download>" . htmlspecialchars($row['fileName']) . "</a></td>
                            <td>" . htmlspecialchars($row['class']) . "</td>
                            <td>" . htmlspecialchars($row['subject']) . "</td>
                            <td>
                                <form method='POST' action='delete_file.php' style='display:inline;'>
                                    <input type='hidden' name='fileName' value='" . htmlspecialchars($row['fileName']) . "'>
                                    <button type='submit'  class='remove-btn'>REMOVE ❌</button>
                                </form>
                            </td>
                        </tr>";
                    } else {
                        echo "<tr>
                            <td>" . htmlspecialchars($row['date']) . "</td>
                            <td>" . htmlspecialchars($row['user']) . "</td>
                            <td>File not available</td>
                            <td>" . htmlspecialchars($row['class']) . "</td>
                            <td>" . htmlspecialchars($row['subject']) . "</td>
                            <td>
                                <form method='POST' action='delete_file.php' style='display:inline;'>
                                    <input type='hidden' name='fileName' value='" . htmlspecialchars($row['fileName']) . "'>
                                    <button type='submit' class='remove-btn'>REMOVE ❌</button>
                                </form>
                            </td>
                        </tr>";
                    }
                }
            } else {
                echo "<tr><td colspan='6'>No files available</td></tr>";
            }

            $conn->close();
            ?>
        </tbody>
    </table>
    
    <script>
    // Function to apply filters
function applyFilter() {
    const filterBtns = document.querySelectorAll('.filter-btn');
    const tableRows = document.querySelectorAll('#files-table tbody tr');

    // Get the selected filter criteria and corresponding prompt message
    let selectedFilter = '';
    let promptMessage = '';

    filterBtns.forEach(btn => {
        if (btn.classList.contains('active')) {
            selectedFilter = btn.getAttribute('data-filter');
            switch (selectedFilter) {
                case 'date':
                    promptMessage = 'Enter the Date:';
                    break;
                case 'name':
                    promptMessage = 'Enter the Name:';
                    break;
                case 'file-id':
                    promptMessage = 'Enter the File Name:';
                    break;
            }
        }
    });

    if (!selectedFilter) {
        alert('Please select a filter type.');
        return;
    }

    const filterValue = prompt(promptMessage)?.toLowerCase();
    if (!filterValue) return; // Exit if no input is provided

    // Iterate through each table row and apply the filter
    tableRows.forEach(row => {
        const rowValue = row.getAttribute('data-' + selectedFilter)?.toLowerCase();
        row.style.display = rowValue && rowValue.includes(filterValue) ? '' : 'none';
    });
}

// Event listeners for filter buttons
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active')); // Remove 'active' from all buttons
        btn.classList.add('active'); // Add 'active' class to clicked button
    });
});

// Toggle dropdown menu visibility
document.getElementById('hamburger-btn').addEventListener('click', function (e) {
    e.stopPropagation(); // Stop the click from propagating to the window event listener
    const dropdown = document.getElementById('dropdown-menu');
    dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
});

// Hide the dropdown menu when clicking outside of it
window.addEventListener('click', function (event) {
    const dropdown = document.getElementById('dropdown-menu');
    if (dropdown.style.display === 'block' && !event.target.closest('#hamburger-btn')) {
        dropdown.style.display = 'none';
    }
});

// Preview the selected image
function previewImage(event) {
    const preview = document.getElementById('preview-img');
    const file = event.target.files[0];

    if (file) {
        const reader = new FileReader();
        reader.onload = function () {
            preview.src = reader.result; // Update the preview image source
        };
        reader.readAsDataURL(file); // Convert the file to a base64-encoded string
    }
}
// Preview the uploaded image directly after selection (optional)
document.querySelector('input[name="profile-pic"]').addEventListener('change', function(event) {
    const preview = document.getElementById('user-icon');
    const file = event.target.files[0];

    if (file) {
        const reader = new FileReader();
        reader.onload = function () {
            preview.src = reader.result; // Show new profile picture
        };
        reader.readAsDataURL(file);
    }
});
// Hide the dropdown menu when clicking outside of it
window.addEventListener('click', function (event) {
    const dropdown = document.getElementById('dropdown-menu');
    const hamburgerBtn = document.getElementById('hamburger-btn');
    
    // Check if the click is outside the dropdown or hamburger button
    if (dropdown.style.display === 'block' && !dropdown.contains(event.target) && !hamburgerBtn.contains(event.target)) {
        dropdown.style.display = 'none';
    }
});

</script>


<script>
    document.getElementById('logout-btn').addEventListener('click', () => {
        // Show confirmation dialog
        if (confirm('Do you really want to log out?')) {
            // Redirect to logout.php if the user confirms
            window.location.href = 'logout.php';
        }
        // If the user cancels, do nothing (no redirection)
    });
</script>
    <script>
function confirmUpdate() {
    const recordId = document.getElementById('recordId').value;
    const dataField = document.getElementById('dataField').value;
    const confirmUpdate = confirm(`Do you really want to update the record with ID ${recordId} to "${dataField}"?`);

    if (confirmUpdate) {
        document.getElementById('updateForm').submit();
    }
}
</script>
<script>
  document.getElementById('remove-btn').addEventListener('click', function(event) {
    if (!confirm("Are you sure you want to remove this?")) {
      event.preventDefault(); // Prevents the form from submitting
    }
  });
</script>
</body>
</html>
