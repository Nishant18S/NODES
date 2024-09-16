const form = document.querySelector("form");
form.addEventListener("submit", function(e) {
    e.preventDefault();
    const username = document.querySelector("#input-text").value;
    const password = document.querySelector("#input-password").value;

    if (authentication(username, password)) {
        window.location.href = "home.html";
    } else {
        alert("Invalid Details");
    }
});

// Function for checking username and password
function authentication(username, password) {
    return username === "simon" && password === "pass";
}
if (username === "" && password === "") {
            alert("Please enter valid data!");
        } else if (username === "") {
            alert("Please enter your Username!");
        } else if (password === "") {
            alert("Please enter your Password!");
        }


// document.getElementById("submit").addEventListener("click", async function (event) {
//     event.preventDefault(); // Prevent the default form submission

//     const username = document.getElementById("input-text").value.trim();
//     const password = document.getElementById("input-password").value.trim();

//     if (username === "" && password === "") {
//         alert("Please enter valid data!");
//     } else if (username === "") {
//         alert("Please enter your Username!");
//     } else if (password === "") {
//         alert("Please enter your Password!");
//     } else {
//         // Mock fetch function to simulate fetching data from a database
//         try {
//             const response = await fetch('/api/login', {
//                 method: 'POST',
//                 headers: {
//                     'Content-Type': 'application/json',
//                 },
//                 body: JSON.stringify({ username, password }),
//             });

//             const result = await response.json();

//             if (result.success) {
//                 // Redirect to home page if login is successful
//                 window.location.href = 'home.html';
//             } else {
//                 alert(result.message || 'Login failed!');
//             }
//         } catch (error) {
//             console.error('Error:', error);
//             alert('An error occurred during login. Please try again.');
//         }
//     }
// });
