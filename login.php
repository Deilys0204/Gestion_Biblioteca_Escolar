<?php
session_start(); // Start a session to manage user login status

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection (replace with your actual credentials)
    $servername = "your_servername";
    $username = "your_username";
    $password = "your_password";
    $dbname = "your_dbname";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get user input and sanitize it to prevent SQL injection
    $username = $conn->real_escape_string($_POST['usuario']);
    $password = $conn->real_escape_string($_POST['contrasena']);

    // Hash the password for security (use a strong hashing algorithm like bcrypt or argon2)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Query the database to check if the user exists
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Verify the password
        if (password_verify($password, $row['password'])) {
            // Successful login
            $_SESSION['username'] = $username; // Store username in session
            header("Location: dashboard.php"); // Redirect to dashboard or protected page
            exit();
        } else {
            $error_message = "Invalid username or password.";
        }
    } else {
        $error_message = "Invalid username or password.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="container">
        <div class="left-side">
            <div class="logo-container">
                <img src="img/educabibliologo.png" alt="Logo Educabiblio" class="educa-logo">
            </div>
            <img src="img/loginimage.png" alt="Decorative Image" class="decorative-image">
        </div>
        <div class="right-side">
            <img src="img/lamercedlogo.png" alt="Logo Institucion" class="institution-logo">
            <h1 class="welcome-text">¡Bienvenido de nuevo!</h1>

            <?php if (isset($error_message)): ?>
                <div class="error-message"><?php echo $error_message; ?></div>
            <?php endif; ?>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <input type="text" name="usuario" placeholder="Usuario" required value="<?php echo isset($_POST['usuario']) ? htmlspecialchars($_POST['usuario']) : ''; ?>">
                <div class="password-container">
                    <input type="password" name="contrasena" placeholder="Contraseña" required>
                    <span class="eye-icon">&#128065;</span> 
                </div>
                <button type="submit">Iniciar sesión</button>
            </form>
            <div class="options">
                <a href="#">Recordar contraseña</a><br>
                <span>¿Todavía no tienes una cuenta? <a href="#">Regístrate</a></span>
            </div>
        </div>
    </div>

</body>
</html>