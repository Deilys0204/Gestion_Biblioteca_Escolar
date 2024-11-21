<?php
// Iniciar sesión
session_start();


// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['primer_nombre']) || !isset($_SESSION['primer_apellido'])) {
    // Redirigir al login si no ha iniciado sesión
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EducaBiblio : Dashboard</title>
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
            <li class="nav-item">
                <a class="nav-link active" href="dashboard.php"><i class="fas fa-home me-2"></i> Inicio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="dashboard-recursos.php"><i class="fas fa-book me-2"></i> Recursos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="dashboard-historial.php"><i class="fas fa-history me-2"></i> Historial</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="dashboard-reservas.php"><i class="fas fa-calendar-alt me-2"></i> Reservar</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="dashboard-perfil.php"><i class="fas fa-user me-2"></i> Perfil</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../php/logout.php"><i class="fas fa-sign-out-alt me-2"></i> Salir</a>
            </li>
        </ul>
    </aside>

    <!-- Contenido principal -->
    <main class="main-content">
        <header class="d-flex justify-content-between align-items-center py-3 border-bottom">
            <div>
                <h2 class="mb-0">Welcome Back, <?php echo $_SESSION['primer_nombre'] . " " . $_SESSION['primer_apellido']; ?></h2>
                <h3 class="text-muted">Disfruta la Biblioteca Escolar</h3>
            </div>
            <div class="d-flex align-items-center gap-3 user-options">
                <!-- Campo de búsqueda oculto -->
                <div id="search-container" class="d-none my-3">
                <input type="text" id="search-input" class="form-control" placeholder="Buscar libros...">
                </div>
                <div id="no-results" class="alert alert-warning d-none" role="alert">
                 No se encontraron resultados relacionados con tu búsqueda.
                </div>
                <div class="user-info">
                    <a href="dashboard-perfil.php">
                      <i class="fas fa-user-circle"></i>
                      <span><?php echo $_SESSION['primer_nombre'] . " " . $_SESSION['primer_apellido']; ?></span>
                    </a>
                </div>
            </div>
        </header>

        <!-- Imagen centrada en el contenido principal -->
        <div class="d-flex justify-content-center align-items-center my-5">
            <img src="../img/fachadamerced.png" alt="Imagen Principal" class="img-fluid rounded shadow" style="max-width: 80%;">
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
