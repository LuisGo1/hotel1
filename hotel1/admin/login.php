<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    <div class="login-container">
        <div class="login-image">
            <img src="./imagenes/logo.jpg" alt="User Icon">
        </div>
        <div class="login-form">
            <h2>Member Login</h2>
            <form id="loginForm">
                <div class="input-group">
                    <label for="email">
                        <span class="icon">📧</span>
                        <input type="email" id="email" placeholder="Email" required>
                        <span class="error-message" id="emailError">!</span>
                    </label>
                </div>
                <div class="input-group">
                    <label for="password">
                        <span class="icon">🔒</span>
                        <input type="password" id="password" placeholder="Password" required>
                        <span class="error-message" id="passwordError">!</span>
                    </label>
                </div>
                <button type="submit" class="login-button">LOGIN</button>
            </form>
           
        </div>
    </div>
    <script src="../js/login.js"></script>
</body>
</html>
