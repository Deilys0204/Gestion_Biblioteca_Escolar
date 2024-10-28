<?php 
// Iniciar sesión
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

// Establece la codificación a utf8mb4
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Configuración de paginación
$limite = 5;
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($pagina_actual - 1) * $limite;

// Obtener el número total de libros disponibles
$sql_total = "SELECT COUNT(*) as total FROM libro WHERE estado_libro = 1";
$result_total = $conn->query($sql_total);
$total_libros = $result_total->fetch_assoc()['total'];

// Calcular el número total de páginas
$total_paginas = ceil($total_libros / $limite);

// Obtener la lista de libros disponibles junto con el autor y género
$sql = "SELECT 
            libro.cod_libro, 
            libro.nombre_libro, 
            libro.genero, 
            autor.pnombre_autor,
            autor.snombre_autor,
            autor.papellido_autor, 
            autor.sapellido_autor,
            libro.cantidad_disponible 
        FROM libro 
        JOIN autor ON libro.autor = autor.id_autor 
        WHERE libro.estado_libro = 1
        LIMIT $limite OFFSET $offset";

$result = $conn->query($sql);
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
                <a class="nav-link" href="dashboard-historial.php"><i class="fas fa-history me-2"></i> Historial</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="dashboard-reservas.php"><i class="fas fa-calendar-alt me-2"></i> Reservar</a>
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
                <h2 class="mb-0">Reservar</h2>
                <h3 class="text-muted">Disfruta la Biblioteca Escolar</h3>
            </div>
            <!-- Barra de búsqueda -->
            <div class="d-flex align-items-center gap-3 user-options">
                <input type="text" id="searchInput" class="form-control d-none" placeholder="Buscar libro..." onkeyup="searchBook()">
                <div class="icon-container" onclick="toggleSearch()">
                    <i class="fas fa-search"></i>
                </div>
                <div class="user-info">
                    <a href="editar_perfil.php">
                      <i class="fas fa-user-circle"></i>
                      <span><?php echo $_SESSION['primer_nombre'] . " " . $_SESSION['primer_apellido']; ?></span>
                    </a>
                </div>
            </div>
             <!-- Mensaje de advertencia de "No hay resultados" -->
        <div id="noResultsMessage" class="alert alert-warning mt-3 d-none">No hay resultados para la búsqueda.</div>
        </header>

        <!-- Modal para reservar libro -->
        <div class="modal fade" id="reserveModal" tabindex="-1" aria-labelledby="reserveModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reserveModalLabel">Reservar Libro</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="reserveForm" action="procesar_reserva.php" method="POST">
                        <div class="modal-body">
                            <input type="hidden" name="usuario_id" value="<?php echo $_SESSION['usuario_id']; ?>">
                            <input type="hidden" name="cod_libro" id="cod_libro">

                            <div class="mb-3">
                                <label for="nombre_libro" class="form-label">Nombre del Libro</label>
                                <input type="text" class="form-control" id="nombre_libro" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="fecha_reserva" class="form-label">Fecha de Reserva</label>
                                <input type="text" class="form-control" id="fecha_reserva" value="<?php echo date('Y-m-d'); ?>" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="fecha_devolucion" class="form-label">Fecha de Devolución</label>
                                <input type="date" class="form-control" name="fecha_devolucion" id="fecha_devolucion" required>
                                <small class="form-text text-muted">El libro debe devolverse en un máximo de 5 días hábiles.</small>
                            </div>

                            <div class="mb-3">
                                <label for="usuario_creacion" class="form-label">Usuario que crea la reserva</label>
                                <input type="text" class="form-control" id="usuario_creacion" name="usuario_creacion" value="<?php echo $_SESSION['primer_nombre'] . ' ' . $_SESSION['primer_apellido']; ?>" readonly>
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

        <!-- Tabla de libros con acciones -->
        <div class="container mt-5">
            <h4 class="mb-4">Lista de Libros Disponibles</h4>
            <table class="table table-bordered" id="booksTable">
                <thead>
                    <tr>
                        <th>Nombre del Libro</th>
                        <th>Autor</th>
                        <th>Género</th>
                        <th>Cantidad Disponible</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['nombre_libro']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['pnombre_autor'] . " " . $row['snombre_autor'] . " " . $row['papellido_autor'] . " " . $row['sapellido_autor']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['genero']) . "</td>";

                            if ($row['cantidad_disponible'] > 0) {
                                echo "<td>" . htmlspecialchars($row['cantidad_disponible']) . "</td>";
                                echo "<td>
                                        <button type='button' class='btn btn-success' onclick='openReserveModal(" . $row['cod_libro'] . ", \"" . addslashes($row['nombre_libro']) . "\")'>
                                            Reservar
                                        </button>
                                      </td>";
                            } else {
                                echo "<td><span class='text-danger'>Agotado</span></td>";
                                echo "<td>
                                        <button type='button' class='btn btn-danger' disabled>Agotado</button>
                                      </td>";
                            }

                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='text-center'>No hay libros disponibles</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
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
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="../js/reserva_libro.js"></script>
</script>
</body>
</html>
