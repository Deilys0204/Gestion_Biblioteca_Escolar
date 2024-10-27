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

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Configuración de paginación
$limite = 5; // Cantidad de libros por página
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1; // Página actual, por defecto 1
$offset = ($pagina_actual - 1) * $limite; // Calcula el desplazamiento para la consulta

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
        LIMIT $limite OFFSET $offset"; // Limitar el resultado y aplicar el offset

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
            <div class="d-flex align-items-center gap-3 user-options">
                <div class="icon-container">
                    <i class="fas fa-bell"></i>
                </div>
                <div class="icon-container">
                    <i class="fas fa-search"></i>
                </div>
                <div class="user-info">
                    <a href="editar_perfil.php">
                      <i class="fas fa-user-circle"></i>
                      <span><?php echo $_SESSION['primer_nombre'] . " " . $_SESSION['primer_apellido']; ?></span>
                    </a>
                </div>
            </div>
        </header>

        <!-- Mostrar mensajes de éxito o error -->
        <?php
        if (isset($_SESSION['mensaje_reserva'])) {
            $mensaje = $_SESSION['mensaje_reserva'];
            $tipo_mensaje = $_SESSION['tipo_mensaje'];
            unset($_SESSION['mensaje_reserva']);
            unset($_SESSION['tipo_mensaje']);
            echo "<div class='alert alert-$tipo_mensaje text-center'>$mensaje</div>";
        }
        ?>

        <!-- Tabla de libros con acciones -->
        <div class="container mt-5">
            <h4 class="mb-4">Lista de Libros Disponibles</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nombre del Libro</th>
                        <th>Autor</th>
                        <th>Género</th> <!-- Nueva columna para el género -->
                        <th>Cantidad Disponible</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['nombre_libro'] . "</td>";
                            echo "<td>" . $row['pnombre_autor'] . " " . $row['snombre_autor'] . " " . $row['papellido_autor'] . " " . $row['sapellido_autor'] . "</td>";
                            echo "<td>" . $row['genero'] . "</td>"; // Mostrar el género
                            echo "<td>" . $row['cantidad_disponible'] . "</td>";
                            echo "<td>
                                    <button class='btn btn-info' onclick='verLibro(" . $row['cod_libro'] . ")'>
                                        <i class='fas fa-eye'></i> Ver
                                    </button>
                                    <form action='procesar_reserva.php' method='POST' class='d-inline'>
                                        <input type='hidden' name='cod_libro' value='" . $row['cod_libro'] . "'>
                                        <button type='submit' class='btn btn-success ml-2'>
                                            <i class='fas fa-check'></i> Reservar
                                        </button>
                                    </form>
                                  </td>";
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
                <a href="?pagina=<?php echo $pagina_actual - 1; ?>" class="btn btn-outline-primary">Anterior</a>
            <?php else: ?>
                <span class="btn btn-outline-secondary disabled">Anterior</span>
            <?php endif; ?>

            <?php if ($pagina_actual < $total_paginas): ?>
                <a href="?pagina=<?php echo $pagina_actual + 1; ?>" class="btn btn-outline-primary">Siguiente</a>
            <?php else: ?>
                <span class="btn btn-outline-secondary disabled">Siguiente</span>
            <?php endif; ?>
        </div>

        <!-- Modal para mostrar información detallada del libro -->
        <div class="modal fade" id="bookModal" tabindex="-1" aria-labelledby="bookModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="bookModalLabel">Información del Libro</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="book-info">
                        <!-- Aquí se cargará la información del libro -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="../js/verLibro.js"></script>
</body>
</html>
