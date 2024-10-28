<?php
// Datos para conectar a la base de datos
$host = 'localhost';  
$dbname = 'educa_biblio'; 
$user = 'root'; 
$password_db = '123456789'; 

// Conectar a la base de datos usando PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password_db);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error en la conexión: " . $e->getMessage());
}

// Establece la codificación a utf8mb4
$conn->set_charset("utf8mb4");
?>