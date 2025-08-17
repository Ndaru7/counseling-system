<?php

require "../vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/..");
$dotenv->load();

$HOST = $_ENV["HOST"];
$DATABASE = $_ENV["DATABASE"];
$USERNAME = $_ENV["USERNAME"];
$PASSWORD = $_ENV["PASSWORD"];


try {
    $conn = new PDO("mysql:host=$HOST;dbname=$DATABASE", $USERNAME, $PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connection successfully!";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>