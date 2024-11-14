<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="css/login.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.9.2/semantic.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.semanticui.css">

    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.4/dist/sweetalert2.min.css" rel="stylesheet">
</head>
<body>
    <div class="login-container">
        <div class="login-image">
            <img src="admin/imagenes/logo.jpg" alt="User Icon">
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
                <a href="validacion/login_val.php">
            </form>
           
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.9.2/semantic.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.semanticui.js"></script>
    <script src="js/login.js"></script>
</body>
</html>
