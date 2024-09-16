document.addEventListener('DOMContentLoaded', function() {
document.getElementById("submit").addEventListener("click", function (event) {
  const username = document.getElementById("input-text").value.trim();
  const password = document.getElementById("input-password").value.trim();

  if (username === "" && password === "") {
      event.preventDefault();
      alert("Please enter valid data!");
  } else if (username === "") {
      event.preventDefault();
      alert("Please enter your Username!");
  } else if (password === "") {
      event.preventDefault();
      alert("Please enter your Password!");
  }
});
});