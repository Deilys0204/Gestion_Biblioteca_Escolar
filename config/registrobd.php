<?php
session_start(); // Iniciar sesión

require_once 'conexion.php';

// Obtener los tipos de documento desde la base de datos
$query = "SELECT id, nombre FROM tipos_documento";
$stmt = $pdo->prepare($query);
$stmt->execute();
$tipos_documento = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Inicializar variables para almacenar errores y éxito
$errores = [];
$exito = "";

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Capturar los datos del formulario
    $primer_nombre = $_POST['primer-nombre'];
    $segundo_nombre = $_POST['segundo-nombre'];
    $primer_apellido = $_POST['primer-apellido'];
    $segundo_apellido = $_POST['segundo-apellido'];
    $tipo_documento_id = $_POST['tipo-documento'];
    $numero_documento = $_POST['numero-documento'];
    $email = $_POST['email'];
    $contrasena = $_POST['password'];

    // Validación básica de los datos
    if (empty($primer_nombre) || empty($primer_apellido) || empty($numero_documento) || empty($email) || empty($contrasena)) {
        $errores[] = "Todos los campos marcados con * son obligatorios.";
    } 
    
    // Validar que los nombres y apellidos solo contengan letras
    if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/", $primer_nombre)) {
        $errores[] = "El primer nombre solo puede contener letras.";
    }
    if (!empty($segundo_nombre) && !preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/", $segundo_nombre)) {
        $errores[] = "El segundo nombre solo puede contener letras.";
    }
    if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/", $primer_apellido)) {
        $errores[] = "El primer apellido solo puede contener letras.";
    }
    if (!empty($segundo_apellido) && !preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/", $segundo_apellido)) {
        $errores[] = "El segundo apellido solo puede contener letras.";
    }

    // Validar que el número de documento solo contenga números
    if (!preg_match("/^[0-9]+$/", $numero_documento)) {
        $errores[] = "El número de documento solo puede contener números.";
    }

    // Validar el formato del correo electrónico
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El email no es válido.";
    }

    // Si no hay errores, proceder con el registro
    if (empty($errores)) {
        // Hash de la contraseña
        $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);

        // Insertar los datos en la base de datos
        try {
            $stmt = $pdo->prepare("INSERT INTO usuarios (primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, tipo_documento_id, numero_documento, email, password) 
                                   VALUES (:primer_nombre, :segundo_nombre, :primer_apellido, :segundo_apellido, :tipo_documento_id, :numero_documento, :email, :password)");
            $stmt->execute([
                ':primer_nombre' => $primer_nombre,
                ':segundo_nombre' => $segundo_nombre,
                ':primer_apellido' => $primer_apellido,
                ':segundo_apellido' => $segundo_apellido,
                ':tipo_documento_id' => $tipo_documento_id,
                ':numero_documento' => $numero_documento,
                ':email' => $email,
                ':password' => $contrasena_hash,
            ]);
            $_SESSION['exito'] = "Registro exitoso. ¡Bienvenido!";
            header("Location: ../php/registro.php");
            exit();
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) { // Código de error para entradas duplicadas
                $errores[] = "El correo o el número de documento ya están registrados.";
            } else {
                $errores[] = "Error al registrar: " . $e->getMessage();
            }
        }
    }
}
?>
