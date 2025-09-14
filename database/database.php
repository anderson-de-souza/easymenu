<?php

require_once __DIR__ . '/database_access.php';

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

                if (!is_dir(__DIR__ . '/error/pdo')) {
                    mkdir(__DIR__ . '/error/pdo');
                }
                
                $datetime = date('Y-m-d') . '_at_' . date('H-i-s');
                $fileName = "error_pdo_$datetime.txt";
                $file = fopen(__DIR__ . "/error/pdo/$fileName", "w");

                if ($file) {
                    fwrite($file, $e->getMessage());
                    fclose($file);
                }

            }

        }

        return self::$pdo;

    }

}