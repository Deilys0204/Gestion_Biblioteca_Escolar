<?php
// Iniciar sesión
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['primer_nombre']) || !isset($_SESSION['primer_apellido'])) {
    // Redirigir al login si no ha iniciado sesión
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

// Manejar solicitudes AJAX para cargar libros según el filtro
if (isset($_GET['filter']) && isset($_GET['page']) && isset($_GET['itemsPerPage'])) {
    $filter = $_GET['filter'];
    $page = (int)$_GET['page'];
    $itemsPerPage = (int)$_GET['itemsPerPage'];
    $offset = ($page - 1) * $itemsPerPage;

    $query = "SELECT nombre_libro AS name, genero, paginas, ano_editorial, 'ruta_de_imagen.jpg' AS image, 'Descripción del libro...' AS description FROM libro";

    if ($filter === 'disponibles') {
        $query .= " WHERE estado_libro = 1";
    } elseif ($filter === 'mas_buscados') {
        $query .= " ORDER BY busquedas DESC";
    } else {
        $query .= " ORDER BY RAND()"; // Recomendados aleatoriamente
    }

    $query .= " LIMIT :itemsPerPage OFFSET :offset";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':itemsPerPage', $itemsPerPage, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Para saber si hay más páginas
    $hasMore = count($books) === $itemsPerPage;

    echo json_encode(['books' => $books, 'hasMore' => $hasMore]);
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
                <a class="nav-link" href="dashboard.php"><i class="fas fa-home me-2"></i> Inicio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="dashboard-recursos.php"><i class="fas fa-book me-2"></i> Recursos</a>
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
                <div class="icon-container">
                    <i class="fas fa-search"></i>
                </div>
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

        <!-- Sección de filtros de libros -->
        <section class="text-center my-4">
            <button id="btnRecomendados" class="btn btn-primary me-2">Recomendados</button>
        </section>

        <!-- Contenedor de la galería de libros -->
        <div class="container bg-light rounded py-4">
            <div id="book-gallery" class="row row-cols-2 row-cols-md-5 g-4">
                <!-- Libros se cargarán dinámicamente aquí -->
            </div>

            <!-- Modal -->
            <div class="modal fade" id="bookModal" tabindex="-1" aria-labelledby="bookModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="bookModalLabel">Información del libro</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Aquí se mostrará la información del libro -->
                            <img id="bookModalImg" class="img-fluid rounded mb-3" src="" alt="Libro">
                            <p id="bookModalInfo"></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary" id="reserveBtn" onclick="location.href='dashboard-reservas.php'">Ir a Reservas</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Paginador -->
            <div class="d-flex justify-content-center my-4">
                <button id="previous-btn" class="btn btn-outline-primary me-2">Anterior</button>
                <button id="next-btn" class="btn btn-primary">Siguiente</button>
            </div>
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="../js/iniciodashboard.js"></script>
</body>
</html>
