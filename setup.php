<?php
if (!file_exists(__DIR__.'/config/server.php')) {
    die('No se encontró config/server.php');
}
require_once __DIR__.'/config/server.php';

$dsn = "mysql:host=".DB_SERVER.";port=".DB_PORT.";dbname=".DB_NAME;
$options = [PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false];

try {
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("Error de conexión: " . $e->getMessage());
}

$sql = file_get_contents(__DIR__.'/DB/ventas.sql');

// Separar en sentencias individuales
$pdo->exec("SET FOREIGN_KEY_CHECKS=0");
$sentencias = array_filter(array_map('trim', explode(';', $sql)));

$ok = 0;
$errores = [];
foreach ($sentencias as $s) {
    if (empty($s) || str_starts_with($s, '--') || str_starts_with($s, '/*')) continue;
    try {
        $pdo->exec($s);
        $ok++;
    } catch (Exception $e) {
        $errores[] = $e->getMessage();
    }
}
$pdo->exec("SET FOREIGN_KEY_CHECKS=1");

echo "<h2>Importación completada</h2>";
echo "<p>Sentencias ejecutadas: <strong>$ok</strong></p>";
if ($errores) {
    echo "<p>Advertencias:</p><ul>";
    foreach ($errores as $e) echo "<li>$e</li>";
    echo "</ul>";
}
echo "<p style='color:red'><strong>¡ELIMINA este archivo setup.php del servidor!</strong></p>";
