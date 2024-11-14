document.getElementById("loginForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent form submission

    let email = document.getElementById("email");
    let password = document.getElementById("password");
    let emailError = document.getElementById("emailError");
    let passwordError = document.getElementById("passwordError");

    let isValid = true;

    // Check email field
    if (email.value.trim() === "") {
        emailError.style.display = "inline";
        isValid = false;
    } else {
        emailError.style.display = "none";
    }

    // Check password field
    if (password.value.trim() === "") {
        passwordError.style.display = "inline";
        isValid = false;
    } else {
        passwordError.style.display = "none";
    }

    // If both fields are valid, submit the form (or handle login)
    if (isValid) {
        alert("Login successful!");
        // Here you can add the logic for actual login
    }
});
