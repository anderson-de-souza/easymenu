<?php

class Database {

    private static ?PDO $pdo = null;

    public static function getPDO(): ?PDO {

        if (!self::$pdo) {

            $host = "127.0.0.1";
            $dbname = "easymenu";
            $username = "root";
            $password = "@devFullstack2026";

            try {
        
                self::$pdo = new PDO("mysql:host=$host;charset=utf8", $username, $password);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
                self::$pdo->exec($sql);
                
                self::$pdo->exec("USE $dbname");

            } catch (PDOException $e) {
            }

        }

        return self::$pdo;

    }

}