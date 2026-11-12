<?php
require __DIR__ . '/../includes/auth.php';
require_login();

$file = $_GET['file'] ?? '';

$targetPath = __DIR__ . '/../report/' . $file;

if (!is_file($targetPath)) {
    http_response_code(404);
    exit;
}

$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mimeType = finfo_file($finfo, $targetPath);
finfo_close($finfo);

header('Content-Type: ' . $mimeType);
header('Content-Disposition: inline; filename="' . basename($targetPath) . '"');
header('Cache-Control: private, no-store');

echo file_get_contents($targetPath);
exit;