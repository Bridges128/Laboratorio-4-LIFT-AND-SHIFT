<?php
$host = getenv('DB_HOST') ?: 'db-mysql';
$dbname = getenv('DB_NAME') ?: 'db_proyecto_mvc';
$username = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASSWORD') ?: 'clave_secreta_nube';

try {
    $conexion = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log('Error de conexión a la base de datos: ' . $e->getMessage());
    http_response_code(503);
    exit('No fue posible conectar con la base de datos. Verifica que el servicio esté disponible.');
}
