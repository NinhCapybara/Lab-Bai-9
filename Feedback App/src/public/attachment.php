<?php
require __DIR__ . '/../includes/auth.php';
require_login();

define('BASE_DIR', '/var/www/html/files/');

$doc = $_GET['doc'] ?? '';

if ($doc === '') {
    http_response_code(400);
    exit;
}

$path = BASE_DIR . $doc;

if (!file_exists($path) || is_dir($path)) {
    http_response_code(404);
    exit;
}

header('Content-Type: text/plain; charset=utf-8');
header('Content-Disposition: inline; filename="' . basename($path) . '"');
echo file_get_contents($path);
exit;
