<?php
require_once 'env_loader.php';

// Load the .env file from the current directory
loadEnv(__DIR__ . '/.env');

$con = mysqli_connect(
    $_ENV['DB_HOST'],
    $_ENV['DB_USER'],
    $_ENV['DB_PASS'],
    $_ENV['DB_NAME']
);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>