<?php

require_once 'database_access.php';
    
$pdo = null;

try {
        
    $pdo = new PDO("mysql:host=$host;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
    $pdo->exec($sql);
    
    $pdo->exec("USE $dbname");
        
} catch (PDOException $e) {
    echo "<pre>" . $e->getMessage() . "</pre>";
}