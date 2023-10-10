<?php

$host  ="localhost";
$dbName  ="devmastery";
$user ="root";
$password  ="";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbName;charset=utf8mb4", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
