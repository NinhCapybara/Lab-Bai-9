<?php
$DB_HOST = getenv('DB_HOST') ?: 'db';
$DB_USER = getenv('DB_USER') ?: 'appuser';
$DB_PASS = getenv('DB_PASS') ?: 'apppass';
$DB_NAME = getenv('DB_NAME') ?: 'feedback';

$conn = @new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

if ($conn->connect_error) {
    sleep(2);
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
}

if ($conn->connect_error) {
    die("Loi ket noi co so du lieu: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
