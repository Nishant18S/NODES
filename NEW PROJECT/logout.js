// Function to handle the logout process
function handleLogout() {
    // Perform any necessary cleanup here (e.g., clearing session data)
    
    // Redirect to the login page
    window.location.href = 'login.html';
}

// Attach the logout handler to the button
document.getElementById('user-logout').addEventListener('click', handleLogout);
