document.getElementById("loginForm").addEventListener("submit", function(event) {
    event.preventDefault(); 

    let email = document.getElementById("email");
    let password = document.getElementById("password");
    let emailError = document.getElementById("emailError");
    let passwordError = document.getElementById("passwordError");

    let isValid = true;

    if (email.value.trim() === "") {
        emailError.style.display = "inline";
        isValid = false;
    } else {
        emailError.style.display = "none";
    }

    if (password.value.trim() === "") {
        passwordError.style.display = "inline";
        isValid = false;
    } else {
        passwordError.style.display = "none";
    }

    if (isValid) {
        let formData = new FormData();
        formData.append("correo", email.value);
        formData.append("password", password.value);

        fetch('validacion/login_val.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            if (data.includes("Error: Usuario o Contraseña Son Incorrectas")) {
                Swal.fire({
                    title: 'Error',
                    text: 'Usuario o contraseña incorrectos.',
                    icon: 'error',
                });
            } else {
                
                window.location.href = data;
            }
        })
        .catch(error => {
            Swal.fire({
                title: 'Error',
                text: 'Hubo un problema al procesar la solicitud.',
                icon: 'error',
            });
        });
    }
});
