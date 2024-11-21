<?php
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

// Procesar la búsqueda
if (isset($_GET['q'])) {
    $query = "%" . $_GET['q'] . "%";

    $sql = "SELECT cod_libro, nombre_libro, genero, cantidad_disponible 
            FROM libro 
            WHERE estado_libro = 1 AND (nombre_libro LIKE :query OR genero LIKE :query)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':query', $query, PDO::PARAM_STR);
    $stmt->execute();

    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($resultados);
    exit;
}
?>
