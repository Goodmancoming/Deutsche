<?php
// db.php - Database connection
$host = 'localhost';
$dbname = 'german_learning';
$username = 'root';
$password = 'The_4nsamble'; // Your XAMPP password, usually empty

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}