document.addEventListener("DOMContentLoaded", () => {
    const changeUsernameBtn = document.getElementById("change-username-btn");
    const changePasswordBtn = document.getElementById("change-password-btn");
    const changePhotoBtn = document.getElementById("change-photo-btn");

    const usernameForm = document.getElementById("username-form");
    const passwordForm = document.getElementById("password-form");
    const photoForm = document.getElementById("photo-form");

    const usernameDisplay = document.getElementById("username-display");
    const profilePicture = document.getElementById("profile-picture");

    const returnHomeBtn = document.getElementById("return-home-btn");

    changeUsernameBtn.addEventListener("click", () => {
        setActiveForm(usernameForm, changeUsernameBtn);
    });

    changePhotoBtn.addEventListener("click", () => {
        setActiveForm(photoForm, changePhotoBtn);
    });

    changePasswordBtn.addEventListener("click", () => {
        setActiveForm(passwordForm, changePasswordBtn);
    });

    // Function to set active form and button
    function setActiveForm(form, button) {
        [usernameForm, passwordForm, photoForm].forEach(f => f.classList.remove("active"));
        [changeUsernameBtn, changePasswordBtn, changePhotoBtn].forEach(b => b.classList.remove("active"));
        
        form.classList.add("active");
        button.classList.add("active");
    }

    // Update username
    usernameForm.addEventListener("submit", (e) => {
        e.preventDefault();
        const newUsername = document.getElementById("new-username").value.trim();
        if (newUsername) {
            usernameDisplay.textContent = newUsername;
            // Save to localStorage (or send to server)
            localStorage.setItem("username", newUsername);
            alert("Username changed successfully!");
        }
    });

    // Update profile picture
    photoForm.addEventListener("submit", (e) => {
        e.preventDefault();
        const newPhoto = document.getElementById("new-photo").files[0];
        if (newPhoto) {
            const reader = new FileReader();
            reader.onload = function(e) {
                profilePicture.src = e.target.result;
                alert("Profile photo updated successfully!");
            };
            reader.readAsDataURL(newPhoto);
        }
    });

    // Return to home
    returnHomeBtn.addEventListener("click", () => {
        window.location.href = "home.html";
    });

    // Load saved username from localStorage
    const savedUsername = localStorage.getItem("username");
    if (savedUsername) {
        usernameDisplay.textContent = savedUsername;
    }
});
