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

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cod_libro = $_POST['cod_libro'];

    // Verificar si el libro tiene copias disponibles
    $sql_check = "SELECT cantidad_disponible FROM libro WHERE cod_libro = ? AND cantidad_disponible > 0";
    $stmt = $conn->prepare($sql_check);
    $stmt->bind_param("i", $cod_libro);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Reducir la cantidad disponible
        $sql_update = "UPDATE libro SET cantidad_disponible = cantidad_disponible - 1 WHERE cod_libro = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("i", $cod_libro);
        $stmt_update->execute();

        // Verificar si el libro se agotó
        $sql_check_stock = "SELECT cantidad_disponible FROM libro WHERE cod_libro = ?";
        $stmt_check_stock = $conn->prepare($sql_check_stock);
        $stmt_check_stock->bind_param("i", $cod_libro);
        $stmt_check_stock->execute();
        $stock = $stmt_check_stock->get_result()->fetch_assoc()['cantidad_disponible'];

        if ($stock == 0) {
            // Marcar el libro como agotado
            $sql_out_of_stock = "UPDATE libro SET estado_libro = 0 WHERE cod_libro = ?";
            $stmt_out_of_stock = $conn->prepare($sql_out_of_stock);
            $stmt_out_of_stock->bind_param("i", $cod_libro);
            $stmt_out_of_stock->execute();
        }

        $_SESSION['mensaje_reserva'] = "Libro reservado con éxito.";
        $_SESSION['tipo_mensaje'] = "success";
    } else {
        $_SESSION['mensaje_reserva'] = "El libro está agotado.";
        $_SESSION['tipo_mensaje'] = "error";
    }

    header("Location: dashboard-reservas.php");
    exit;
}
?>
