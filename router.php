<?php
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Servir archivos estáticos directamente (CSS, JS, imágenes, fuentes)
if ($uri !== '/' && is_file(__DIR__ . $uri)) {
    return false;
}

// Pasar la ruta como parámetro 'views' igual que hacía el .htaccess
if ($uri !== '/' && $uri !== '/index.php') {
    $path = trim($uri, '/');
    if (!empty($path)) {
        $_GET['views'] = $path;
    }
}

require_once __DIR__ . '/index.php';
