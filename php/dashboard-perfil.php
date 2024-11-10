<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['primer_nombre']) || !isset($_SESSION['primer_apellido'])) {
    header("Location: login.php");
    exit;
}

// Conexión a la base de datos
$host = "localhost";
$dbname = "educa_biblio";
$username = "root";
$password_db = "123456789";

$conn = new mysqli($host, $username, $password_db, $dbname);
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener el número de documento del usuario de la sesión
$numero_documento = $_SESSION['numero_documento'] ?? null;

if (!$numero_documento) {
    die("Número de documento no está definido en la sesión.");
}

// Obtener los datos actuales del usuario, incluyendo el nombre del tipo de documento y el grado escolar
$sql = "SELECT usuarios.*, tipos_documento.nombre AS tipo_documento_nombre, grado_escolar.nombre_grado AS nombre_grado_escolar
        FROM usuarios
        INNER JOIN tipos_documento ON usuarios.tipo_documento_id = tipos_documento.id
        LEFT JOIN grado_escolar ON usuarios.id_grado_escolar = grado_escolar.id_grado_escolar
        WHERE usuarios.numero_documento = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $numero_documento);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();

if (!$usuario) {
    die("No se encontraron datos para el usuario con Número de Documento: " . $numero_documento);
}

// Obtener los grados escolares para el menú desplegable
$sql_grados = "SELECT id_grado_escolar, nombre_grado FROM grado_escolar";
$result_grados = $conn->query($sql_grados);
$grados = [];
while ($grado = $result_grados->fetch_assoc()) {
    $grados[] = $grado;
}

// Procesar la actualización cuando el formulario sea enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $celular = $_POST['celular'];
    $direccion = $_POST['direccion'];
    $id_grado_escolar = $_POST['id_grado_escolar'];

    $sql_update = "UPDATE usuarios SET email = ?, celular = ?, direccion = ?, id_grado_escolar = ? WHERE numero_documento = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("sssis", $email, $celular, $direccion, $id_grado_escolar, $numero_documento);
    $stmt_update->execute();

    $_SESSION['mensaje_actualizacion'] = "Perfil actualizado exitosamente.";
    $_SESSION['tipo_mensaje'] = "success";
    header("Location: dashboard-perfil.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard : Perfil</title>
    <link rel="shortcut icon" href="../img/icon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../css/dashboard.css">
</head>
<body>
<div class="dashboard-container">
    <!-- Barra lateral -->
    <aside>
        <div class="mb-4">
            <img src="../img/educabibliologo.png" alt="EducaBiblio" class="img-fluid">
        </div>
        <ul class="nav flex-column w-100">
            <li class="nav-item"><a class="nav-link" href="dashboard.php"><i class="fas fa-home me-2"></i> Inicio</a></li>
            <li class="nav-item"><a class="nav-link" href="dashboard-recursos.php"><i class="fas fa-book me-2"></i> Recursos</a></li>
            <li class="nav-item"><a class="nav-link" href="dashboard-historial.php"><i class="fas fa-history me-2"></i> Historial</a></li>
            <li class="nav-item"><a class="nav-link" href="dashboard-reservas.php"><i class="fas fa-calendar-alt me-2"></i> Reservar</a></li>
            <li class="nav-item"><a class="nav-link active" href="dashboard-perfil.php"><i class="fas fa-user me-2"></i> Perfil</a></li>
            <li class="nav-item"><a class="nav-link" href="../php/logout.php"><i class="fas fa-sign-out-alt me-2"></i> Salir</a></li>
        </ul>
    </aside>

    <!-- Contenido principal -->
    <main class="main-content">
        <header class="d-flex justify-content-between align-items-center py-3 border-bottom">
            <div>
                <h2 class="mb-0">Perfil</h2>
                <h3 class="text-muted">Disfruta la Biblioteca Escolar</h3>
            </div>
            <div class="d-flex align-items-center gap-3 user-options">
                <div class="user-info">
                      <a href="dashboard-perfil.php">
                      <i class="fas fa-user-circle"></i>
                      <span><?php echo $_SESSION['primer_nombre'] . " " . $_SESSION['primer_apellido']; ?></span>
                    </a>
                </div>
            </div>
        </header>

        <!-- Mensaje de éxito o error -->
        <?php if (isset($_SESSION['mensaje_actualizacion'])): ?>
            <div class="alert alert-<?php echo $_SESSION['tipo_mensaje']; ?> mt-4">
                <?php echo $_SESSION['mensaje_actualizacion']; unset($_SESSION['mensaje_actualizacion'], $_SESSION['tipo_mensaje']); ?>
            </div>
        <?php endif; ?>

        <!-- Formulario de actualización de perfil -->
        <div class="container mt-5">
            <form method="POST" action="">
                <!-- Nombre y Apellidos -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="primer_nombre" class="form-label">Primer Nombre</label>
                        <input type="text" class="form-control" id="primer_nombre" value="<?php echo htmlspecialchars($usuario['primer_nombre']); ?>" disabled>
                    </div>
                    <div class="col-md-6">
                        <label for="segundo_nombre" class="form-label">Segundo Nombre</label>
                        <input type="text" class="form-control" id="segundo_nombre" value="<?php echo htmlspecialchars($usuario['segundo_nombre']); ?>" disabled>
                    </div>
                </div>

                <!-- Documento y Tipo de Documento -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="tipo_documento_nombre" class="form-label">Tipo de Documento</label>
                        <input type="text" class="form-control" id="tipo_documento_nombre" value="<?php echo htmlspecialchars($usuario['tipo_documento_nombre']); ?>" disabled>
                    </div>
                    <div class="col-md-6">
                        <label for="numero_documento" class="form-label">Número de Documento</label>
                        <input type="text" class="form-control" id="numero_documento" value="<?php echo htmlspecialchars($usuario['numero_documento']); ?>" disabled>
                    </div>
                </div>

                <!-- Celular y Dirección -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="celular" class="form-label">Celular</label>
                        <input type="text" class="form-control" id="celular" name="celular" value="<?php echo htmlspecialchars($usuario['celular'] ?? ''); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo htmlspecialchars($usuario['direccion'] ?? ''); ?>" required>
                    </div>
                </div>

                <!-- Grado Escolar -->
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="id_grado_escolar" class="form-label">Grado Escolar</label>
                        <select class="form-control" id="id_grado_escolar" name="id_grado_escolar" required>
                            <option value="">Seleccione el grado</option>
                            <?php foreach ($grados as $grado): ?>
                                <option value="<?php echo $grado['id_grado_escolar']; ?>" <?php echo ($usuario['id_grado_escolar'] == $grado['id_grado_escolar']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($grado['nombre_grado']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- Email -->
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Actualizar Perfil</button>
            </form>
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
