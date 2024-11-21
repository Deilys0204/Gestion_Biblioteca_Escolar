<?php 
// Configuración para mostrar errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Datos de conexión a la base de datos
$host = "localhost";
$dbname = "educa_biblio";
$username = "root";
$password_db = "123456789";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password_db);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error en la conexión: " . $e->getMessage());
}

// Obtener el nombre completo del usuario de la sesión
$usuario_creacion = isset($_SESSION['primer_nombre'], $_SESSION['primer_apellido']) 
                    ? $_SESSION['primer_nombre'] . " " . $_SESSION['primer_apellido'] 
                    : null;

if ($usuario_creacion) {
    // Consultar el historial de reservas del usuario basado en el nombre de creación
    $sql = "SELECT nombre_libro, fecha_reserva, fecha_devolucion, usuario_creacion
            FROM reservas
            WHERE usuario_creacion = :usuario_creacion ORDER BY fecha_reserva desc"; 

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['usuario_creacion' => $usuario_creacion]);
        $historial = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error en la consulta: " . $e->getMessage();  // Mensaje para capturar errores en la consulta
    }
} else {
    $historial = [];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard : Historial</title>
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
                <a class="nav-link" href="dashboard.php"><i class="fas fa-home me-2"></i> Inicio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="dashboard-recursos.php"><i class="fas fa-book me-2"></i> Recursos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="dashboard-historial.php"><i class="fas fa-history me-2"></i> Historial</a>
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
                <h2 class="mb-0">Historial</h2>
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

        <!-- Tabla de historial de reservas -->
        <div class="container mt-5">
            <h3 class="mb-4 text-center">Historial de Reservas</h3>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Título del Libro</th>
                            <th scope="col">Fecha de Reserva</th>
                            <th scope="col">Fecha de Devolución</th>
                            <th scope="col">Usuario Creación</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($historial)): ?>
                            <?php foreach ($historial as $registro): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($registro['nombre_libro']); ?></td>
                                    <td><?php echo htmlspecialchars($registro['fecha_reserva']); ?></td>
                                    <td><?php echo htmlspecialchars($registro['fecha_devolucion'] ?? 'Pendiente'); ?></td>
                                    <td><?php echo htmlspecialchars($registro['usuario_creacion']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">No se encontraron registros de reserva.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
