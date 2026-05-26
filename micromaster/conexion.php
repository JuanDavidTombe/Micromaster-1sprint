<?php
// conexion.php - CONEXIÓN CENTRAL A LA BASE DE DATOS MICROMASTER

$host = 'localhost';
$db   = 'micromaster_db';
$user = 'root'; 
$pass = ''; // Vacío por defecto en XAMPP
$charset = 'utf8mb4';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (\PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Error de conexión: " . $e->getMessage()]);
    exit;
}
?>
