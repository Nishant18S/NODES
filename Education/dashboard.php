<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.html");
    exit();
}

$loggedInUser = $_SESSION['user']; // Get the logged-in user's name

// Fetch user profile picture from database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "education";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$loggedInUserEscaped = $conn->real_escape_string($loggedInUser);
$sql = "SELECT profile_pic FROM users WHERE username = '$loggedInUserEscaped'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $profilePicPath = $row['profile_pic'];
    $_SESSION['profile-pic'] = $profilePicPath;
} else {
    $_SESSION['profile-pic'] = 'user_icon.png'; // Default image if no record found
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags, title, and stylesheets -->
</head>
<body>
    <header>
        <div class="logo">
            <img src="EduNexusBg.png" class="edunexus-logo" alt="EduNexus Logo" />
        </div>
        <h1>EduNexus</h1>
        <!-- User Info Section -->
        <div class="user-info">
            <span>Hello, <span id="user-name"><?php echo htmlspecialchars($loggedInUser); ?></span></span>
            <!-- Display the uploaded profile picture or a default icon -->
            <img src="<?php echo htmlspecialchars($_SESSION['profile-pic']); ?>" 
                 alt="Profile Picture" 
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
                <li><a href="logout.php" id="logout-link">Logout</a></li>
                <li>
                    <!-- Profile Picture Upload Form -->
                    <form action="upload_profile_pic.php" method="POST" enctype="multipart/form-data">
                        <input type="file" name="profile-pic" accept="image/*" required />
                        <button type="submit">Upload Profile Picture</button>
                    </form>
                </li>
            </ul>
        </div>
    </header>

    <!-- Rest of your HTML content -->

</body>
</html>
