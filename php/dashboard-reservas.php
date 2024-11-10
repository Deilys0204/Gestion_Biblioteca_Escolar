<?php
// Configuración para mostrar errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password_db);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error en la conexión: " . $e->getMessage());
}

// Procesar reserva si se envía el formulario desde el modal
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cod_libro'], $_POST['nombre_libro'], $_POST['fecha_devolucion'])) {
    $cod_libro = $_POST['cod_libro'];
    $nombre_libro = $_POST['nombre_libro'];
    $fecha_reserva = date('Y-m-d');
    $fecha_devolucion = $_POST['fecha_devolucion'];
    $usuario_id = $_SESSION['id'];
    $usuario_creacion = $_SESSION['primer_nombre'] . " " . $_SESSION['primer_apellido'];

    $sql = "INSERT INTO reservas (nombre_libro, fecha_reserva, fecha_devolucion, usuario_creacion, usuario_id, codigo_libro) 
            VALUES (:nombre_libro, :fecha_reserva, :fecha_devolucion, :usuario_creacion, :usuario_id, :codigo_libro)";
    
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([
        ':nombre_libro' => $nombre_libro,
        ':fecha_reserva' => $fecha_reserva,
        ':fecha_devolucion' => $fecha_devolucion,
        ':usuario_creacion' => $usuario_creacion,
        ':usuario_id' => $usuario_id,
        ':codigo_libro' => $cod_libro
    ])) {
        $_SESSION['mensaje_reserva'] = "Reserva realizada con éxito.";
        $_SESSION['tipo_mensaje'] = "success";
    } else {
        $_SESSION['mensaje_reserva'] = "Error al realizar la reserva.";
        $_SESSION['tipo_mensaje'] = "danger";
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Configuración de la paginación
$limite = 5;
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($pagina_actual - 1) * $limite;

// Obtener el total de libros disponibles para calcular el número total de páginas
$sql_total = "SELECT COUNT(*) as total FROM libro WHERE estado_libro = 1";
$result_total = $pdo->query($sql_total);
$total_libros = $result_total->fetch(PDO::FETCH_ASSOC)['total'];
$total_paginas = ceil($total_libros / $limite);

// Obtener la lista de libros disponibles con límite de paginación
$sql = "SELECT cod_libro, nombre_libro, genero, cantidad_disponible FROM libro WHERE estado_libro = 1 LIMIT :limite OFFSET :offset";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$libros = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard : Reservas</title>
    <link rel="shortcut icon" href="../img/icon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../css/dashboard.css">
    <style>
        /* Ocultar el campo de búsqueda al cargar la página */
        #search-container {
            display: none; /* Inicialmente oculto */
        }
    </style>
</head>
<body>
<div class="dashboard-container">
    <!-- Barra lateral de navegación -->
    <aside>
        <div class="mb-4">
            <img src="../img/educabibliologo.png" alt="EducaBiblio" class="img-fluid">
        </div>
        <ul class="nav flex-column w-100">
            <li class="nav-item"><a class="nav-link" href="dashboard.php"><i class="fas fa-home me-2"></i> Inicio</a></li>
            <li class="nav-item"><a class="nav-link" href="dashboard-recursos.php"><i class="fas fa-book me-2"></i> Recursos</a></li>
            <li class="nav-item"><a class="nav-link" href="dashboard-historial.php"><i class="fas fa-history me-2"></i> Historial</a></li>
            <li class="nav-item"><a class="nav-link active" href="dashboard-reservas.php"><i class="fas fa-calendar-alt me-2"></i> Reservar</a></li>
            <li class="nav-item"><a class="nav-link" href="dashboard-perfil.php"><i class="fas fa-user me-2"></i> Perfil</a></li>
            <li class="nav-item"><a class="nav-link" href="../php/logout.php"><i class="fas fa-sign-out-alt me-2"></i> Salir</a></li>
        </ul>
    </aside>

    <!-- Contenido principal -->
    <main class="main-content">
        <header class="d-flex justify-content-between align-items-center py-3 border-bottom">
            <div>
                <h2 class="mb-0">Reservar</h2>
                <h3 class="text-muted">Disfruta la Biblioteca Escolar</h3>
            </div>
            <div class="d-flex align-items-center gap-3 user-options">
                <!-- Icono de búsqueda -->
                <div class="icon-container">
                    <i id="search-icon" class="fas fa-search" style="cursor: pointer;"></i>
                </div>
                
                <!-- Contenedor de búsqueda, inicialmente oculto -->
                <div id="search-container" class="my-3">
                    <input type="text" id="search-input" class="form-control" placeholder="Buscar en reservas...">
                </div>
                
                <div class="user-info">
                    <a href="dashboard-perfil.php">
                        <i class="fas fa-user-circle"></i>
                        <span><?php echo $_SESSION['primer_nombre'] . " " . $_SESSION['primer_apellido']; ?></span>
                    </a>
                </div>
            </div>
        </header>

        <!-- Mensaje de éxito o error si se realizó una reserva -->
        <?php if (isset($_SESSION['mensaje_reserva'])): ?>
            <div class="alert alert-<?php echo $_SESSION['tipo_mensaje']; ?> mt-4">
                <?php echo $_SESSION['mensaje_reserva']; unset($_SESSION['mensaje_reserva'], $_SESSION['tipo_mensaje']); ?>
            </div>
        <?php endif; ?>

        <!-- Tabla de reservas para mostrar los libros disponibles -->
        <div class="container mt-5">
            <h4 class="mb-4">Lista de Libros Disponibles para Reservar</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nombre del Libro</th>
                        <th>Género</th>
                        <th>Cantidad Disponible</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($libros): ?>
                        <?php foreach ($libros as $libro): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($libro['nombre_libro']); ?></td>
                                <td><?php echo htmlspecialchars($libro['genero']); ?></td>
                                <td><?php echo htmlspecialchars($libro['cantidad_disponible']); ?></td>
                                <td>
                                    <?php if ($libro['cantidad_disponible'] > 0): ?>
                                        <button class="btn btn-success" onclick="openReserveModal('<?php echo $libro['cod_libro']; ?>', '<?php echo addslashes($libro['nombre_libro']); ?>')">Reservar</button>
                                    <?php else: ?>
                                        <button class="btn btn-danger" disabled>Agotado</button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">No hay libros disponibles para reservar.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- Botones de paginación -->
            <div class="d-flex justify-content-between mt-4">
                <?php if ($pagina_actual > 1): ?>
                    <a href="?pagina=<?php echo $pagina_actual - 1; ?>" class="btn btn-primary">Anterior</a>
                <?php else: ?>
                    <span class="btn btn-outline-secondary disabled">Anterior</span>
                <?php endif; ?>

                <?php if ($pagina_actual < $total_paginas): ?>
                    <a href="?pagina=<?php echo $pagina_actual + 1; ?>" class="btn btn-primary">Siguiente</a>
                <?php else: ?>
                    <span class="btn btn-outline-secondary disabled">Siguiente</span>
                <?php endif; ?>
            </div>
        </div>

        <!-- Modal para reservar libro -->
        <div class="modal fade" id="reserveModal" tabindex="-1" aria-labelledby="reserveModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST">
                        <div class="modal-header">
                            <h5 class="modal-title" id="reserveModalLabel">Reservar Libro</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="cod_libro" id="cod_libro">
                            <div class="mb-3">
                                <label for="nombre_libro" class="form-label">Nombre del Libro</label>
                                <input type="text" class="form-control" id="nombre_libro" name="nombre_libro" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="fecha_reserva" class="form-label">Fecha de Reserva</label>
                                <input type="text" class="form-control" value="<?php echo date('Y-m-d'); ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="fecha_devolucion" class="form-label">Fecha de Devolución</label>
                                <input type="date" class="form-control" name="fecha_devolucion" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-success">Confirmar Reserva</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function openReserveModal(cod_libro, nombre_libro) {
        document.getElementById('cod_libro').value = cod_libro;
        document.getElementById('nombre_libro').value = nombre_libro;
        var reserveModal = new bootstrap.Modal(document.getElementById('reserveModal'));
        reserveModal.show();
    }

    // Función para alternar la visibilidad del contenedor de búsqueda al hacer clic en el icono de búsqueda
    document.getElementById("search-icon").addEventListener("click", function() {
        var searchContainer = document.getElementById("search-container");
        
        // Si el contenedor de búsqueda está oculto, mostrarlo
        if (searchContainer.style.display === "none" || searchContainer.style.display === "") {
            searchContainer.style.display = "block"; // Muestra el campo de búsqueda
            document.getElementById("search-input").focus(); // Enfoca automáticamente en el campo de búsqueda
        } else {
            searchContainer.style.display = "none"; // Oculta el campo de búsqueda si ya estaba visible
        }
    });

    // Filtrar las filas de la tabla a medida que el usuario escribe en el campo de búsqueda
    document.getElementById("search-input").addEventListener("input", function() {
        var filter = this.value.toLowerCase();
        var rows = document.querySelectorAll("tbody tr");
        
        rows.forEach(function(row) {
            var text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? "" : "none";
        });
    });
</script>
</body>
</html>
