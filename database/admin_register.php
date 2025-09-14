<?php

require_once __DIR__ . '/connect_to_database.php';
require_once __DIR__ . '/schema/admin.php';

$sql = "
    CREATE TABLE IF NOT EXISTS Admin (
        admin_id INT AUTO_INCREMENT PRIMARY KEY,
        admin_name VARCHAR(64) NOT NULL,
        admin_email VARCHAR(128) NOT NULL UNIQUE,
        admin_password VARCHAR(255) NOT NULL,
        admin_created_at DATETIME NOT NULL
    );
";

try {
    $pdo->exec($sql);
} catch (PDOException $e) {
    echo "PDO Error: " . $e->getMessage();
}

function insertAdmin(Admin $admin) {

    global $pdo;

    $stmt = $pdo->query("SELECT COUNT(*) as total FROM Admin");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row['total'] > 0) {
        throw new Exception("Já existe um administrador cadastrado. Não é possível criar outro.");
    }

    $stmt = $pdo->prepare("
        INSERT INTO Admin (admin_name, admin_email, admin_password, admin_created_at)
        VALUES (:name, :email, :password, :createdAt)
    ");

    $stmt->execute([
        ':name' => $admin->getName(),
        ':email' => $admin->getEmail(),
        ':password' => password_hash($admin->getPassword(), PASSWORD_BCRYPT), // melhor salvar hasheado
        ':createdAt' => $admin->getCreatedAt()
    ]);

    return $pdo->lastInsertId();

}

function updateAdmin(Admin $admin) {

    global $pdo;

    $stmt = $pdo->prepare("
        UPDATE Admin
        SET admin_name = :name, admin_email = :email, admin_password = :password, admin_created_at = :createdAt
        WHERE admin_id = :id
    ");

    return $stmt->execute([
        ':name' => $admin->getName(),
        ':email' => $admin->getEmail(),
        ':password' => password_hash($admin->getPassword(), PASSWORD_BCRYPT),
        ':createdAt' => $admin->getCreatedAt(),
        ':id' => $admin->getId()
    ]);

}

function getAdmin(): ?Admin {

    global $pdo;

    $stmt = $pdo->query("SELECT * FROM Admin LIMIT 1");
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

    $admin->setId((int)$row['admin_id']);
    return $admin;

}

function deleteAdmin() {
    global $pdo;
    return $pdo->exec("DELETE FROM Admin");
}
