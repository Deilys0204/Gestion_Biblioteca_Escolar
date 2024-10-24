<?php
// Datos de conexión a la base de datos
$host = "localhost";
$dbname = "educa_biblio"; 
$username = "root"; 
$password_db = "123456789";  

// Crear la conexión
$conn = new mysqli($host, $username, $password_db, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Iniciar la sesión
session_start();

// Procesar el formulario cuando se envíe
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numero_documento = $_POST['usuario'];  // Captura el número de documento ingresado en el campo 'usuario'
    $contrasena = $_POST['contrasena'];  // Captura la contraseña

    // Consulta para verificar el número de documento
    $sql = "SELECT * FROM usuarios WHERE numero_documento = ?";  // Buscar por el campo 'numero_documento'
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $numero_documento);  // El número de documento sigue siendo capturado como 'usuario'
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si existe el usuario (número de documento)
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();  // Obtener los datos del usuario

        // Verificar la contraseña (password_verify compara la contraseña ingresada con el hash almacenado)
        if (password_verify($contrasena, $user['password'])) {
            // Guardar el nombre y apellido en la sesión
            $_SESSION['primer_nombre'] = $user['primer_nombre'];
            $_SESSION['primer_apellido'] = $user['primer_apellido'];

            // Inicio de sesión exitoso, redirigir al dashboard
            header("Location: dashboard.php");
            exit;
        } else {
            // Contraseña incorrecta
            $error_message = "Contraseña incorrecta.";
        }
    } else {
        // Número de documento no encontrado
        $error_message = "El número de documento no existe.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="shortcut icon" href="../img/icon.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    <div class="container-fluid d-flex align-items-center justify-content-center vh-100">
        <div class="row login-container w-100">
            <!-- Lado izquierdo: Imagen y título -->
            <div class="col-md-6 d-none d-md-flex flex-column align-items-center justify-content-center bg-white position-relative p-0">
                <div class="position-absolute top-0 start-0 p-4 logo-container">
                    EDUCABIBLIO
                </div>
                <img src="../img/loginimage.jpg" alt="Decorative Image" class="img-fluid w-100 h-100 object-fit-cover">
            </div>

            <!-- Lado derecho: Formulario de inicio de sesión -->
            <div class="col-md-6 d-flex flex-column justify-content-center align-items-center bg-light p-4">
                <img src="../img/logo.png" alt="Logo Institución" class="mb-4 institution-logo">
                <h1 class="welcome-text mb-4">¡Bienvenido de nuevo!</h1>

                <!-- Mensaje de error -->
                <?php if (isset($error_message)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="w-75">
                    <div class="mb-3">
                        <input type="text" name="usuario" class="form-control" placeholder="Número Documento" required value="<?php echo isset($_POST['usuario']) ? htmlspecialchars($_POST['usuario']) : ''; ?>">
                    </div>
                    <div class="mb-3 password-container">
                        <input type="password" name="contrasena" class="form-control" placeholder="Contraseña" required>
                    </div>
                    <button type="submit" class="btn btn-primary ">Iniciar Sesión</button>
                </form>

                <div class="options mt-3 text-center">
                    <a href="#"><strong>Recordar contraseña</strong></a><br>
                    <span>¿Todavía no tienes una cuenta? <a href="../php/Registro.php"><strong>Regístrate</strong></a></span>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



