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

// Procesar la edición del perfil si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editar_perfil'])) {
    $primer_nombre = $_POST['primer_nombre'];
    $segundo_nombre = $_POST['segundo_nombre'];
    $primer_apellido = $_POST['primer_apellido'];
    $segundo_apellido = $_POST['segundo_apellido'];

    // Procesar la foto de perfil si se ha subido
    if (!empty($_FILES['foto_perfil']['name'])) {
        $foto_perfil = 'uploads/' . basename($_FILES['foto_perfil']['name']);
        move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $foto_perfil);

        // Actualizar los datos del usuario junto con la foto
        $sql = "UPDATE usuarios SET primer_nombre='$primer_nombre', segundo_nombre='$segundo_nombre', primer_apellido='$primer_apellido', segundo_apellido='$segundo_apellido', foto_perfil='$foto_perfil' WHERE numero_documento='{$_SESSION['numero_documento']}'";
    } else {
        // Actualizar los datos del usuario sin la foto
        $sql = "UPDATE usuarios SET primer_nombre='$primer_nombre', segundo_nombre='$segundo_nombre', primer_apellido='$primer_apellido', segundo_apellido='$segundo_apellido' WHERE numero_documento='{$_SESSION['numero_documento']}'";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Perfil actualizado correctamente.";
        $_SESSION['primer_nombre'] = $primer_nombre;
        $_SESSION['primer_apellido'] = $primer_apellido;
    } else {
        echo "Error al actualizar el perfil: " . $conn->error;
    }
}

// Mostrar el perfil del usuario después de iniciar sesión
$sql = "SELECT primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, email, foto_perfil FROM usuarios WHERE numero_documento = '{$_SESSION['numero_documento']}'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "No se encontró la información del usuario.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">Perfil de Usuario</h2>

    <form action="perfil.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="primer_nombre" class="form-label">Primer nombre</label>
            <input type="text" class="form-control" id="primer_nombre" name="primer_nombre" value="<?php echo htmlspecialchars($row['primer_nombre']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="segundo_nombre" class="form-label">Segundo nombre</label>
            <input type="text" class="form-control" id="segundo_nombre" name="segundo_nombre" value="<?php echo htmlspecialchars($row['segundo_nombre']); ?>">
        </div>
        <div class="mb-3">
            <label for="primer_apellido" class="form-label">Primer apellido</label>
            <input type="text" class="form-control" id="primer_apellido" name="primer_apellido" value="<?php echo htmlspecialchars($row['primer_apellido']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="segundo_apellido" class="form-label">Segundo apellido</label>
            <input type="text" class="form-control" id="segundo_apellido" name="segundo_apellido" value="<?php echo htmlspecialchars($row['segundo_apellido']); ?>">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="foto_perfil" class="form-label">Foto de perfil</label>
            <input type="file" class="form-control" id="foto_perfil" name="foto_perfil" accept="image/*">
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary" name="editar_perfil">Guardar cambios</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
