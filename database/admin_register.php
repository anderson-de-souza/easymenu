<?php

require_once __DIR__ . '/database.php';
require_once __DIR__ . '/schema/admin.php';

class AdminRegister {

    private static ?PDO $pdo = null;

    public static function getPDO(): ?PDO {

        if (!self::$pdo) {

            self::$pdo = Database::getPDO();

            $sql = "
                CREATE TABLE IF NOT EXISTS Admin (
                    admin_id INT AUTO_INCREMENT PRIMARY KEY,
                    admin_name VARCHAR(64) NOT NULL,
                    admin_email VARCHAR(128) NOT NULL UNIQUE,
                    admin_password VARCHAR(255) NOT NULL,
                    admin_created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
                );
            ";

            self::$pdo->exec($sql);

        }

        return self::$pdo;

    }

    public static function insert(Admin $admin) {

        $stmt = self::getPDO()->query("SELECT COUNT(*) as total FROM Admin");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row['total'] > 0) {
            throw new Exception("There is already a registered admin. It is not possible to create another one.");
        }

        $stmt = self::getPDO()->prepare("
            INSERT INTO Admin (admin_name, admin_email, admin_password)
            VALUES (:name, :email, :password)
        ");

        $stmt->execute([
            ':name' => $admin->getName(),
            ':email' => $admin->getEmail(),
            ':password' => password_hash($admin->getPassword(), PASSWORD_BCRYPT)
        ]);

        return self::getPDO()->lastInsertId();

    }

    public static function update(Admin $admin) {

        $stmt = self::getPDO()->prepare("
            UPDATE Admin
            SET admin_name = :name, admin_email = :email, admin_password = :password
            WHERE admin_id = :id
        ");

        return $stmt->execute([
            ':name' => $admin->getName(),
            ':email' => $admin->getEmail(),
            ':password' => password_hash($admin->getPassword(), PASSWORD_BCRYPT),
            ':id' => $admin->getId()
        ]);

    }

    public static function getAdmin(): ?Admin {

        $stmt = self::getPDO()->query("SELECT * FROM Admin LIMIT 1");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        $admin = new Admin(
            $row['admin_name'],
            $row['admin_email'],
            $row['admin_password'],
            $row['admin_created_at']
        );

        $admin->setId((int) $row['admin_id']);
        return $admin;

    }

    public static function delete() {
        return self::getPDO()->exec("DELETE FROM Admin");
    }

}
