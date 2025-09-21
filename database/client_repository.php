<?php

require_once __DIR__ . '/database.php';
require_once __DIR__ . '/schema/client.php';

class ClientRepository {

    private static ?PDO $pdo = null;

    public static function getPDO(): ?PDO {

        if (!self::$pdo) {

            self::$pdo = Database::getPDO();

            $sql = "
                CREATE TABLE IF NOT EXISTS Client (
                    client_id INT AUTO_INCREMENT PRIMARY KEY,
                    client_name VARCHAR(64) NOT NULL,
                    client_email VARCHAR(128) NOT NULL UNIQUE,
                    client_password VARCHAR(255) NOT NULL,
                    client_cart TEXT,
                    client_signup_datetime DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
                    client_logged TINYINT(1) CHECK (client_logged IN (0, 1)) DEFAULT 1 NOT NULL
                );
            ";

            self::$pdo->exec($sql);

        }

        return self::$pdo;

    }

    public static function insert(Client $client) {

        $stmt = self::getPDO()->prepare("
            INSERT INTO Client (client_name, client_email, client_password, client_cart)
            VALUES (:name, :email, :password, :cart)
        ");

        $stmt->execute([
            ':name' => $client->getName(),
            ':email' => $client->getEmail(),
            ':password' => password_hash($client->getPassword(), PASSWORD_BCRYPT),
            ':cart' => json_encode($client->getCart())
        ]);

        return self::getPDO()->lastInsertId();

    }

    public static function update(Client $client) {

        $stmt = self::getPDO()->prepare("
            UPDATE Client
            SET client_name = :name, client_email = :email, client_password = :password, client_cart = :cart
            WHERE client_id = :id
        ");

        return $stmt->execute([
            ':name' => $client->getName(),
            ':email' => $client->getEmail(),
            ':password' => password_hash($client->getPassword(), PASSWORD_BCRYPT),
            ':cart' => json_encode($client->getCart()),
            ':id' => $client->getId()
        ]);

    }

    public static function deleteClient(int $id) {
        
        $stmt = self::getPDO()->prepare("DELETE FROM Client WHERE client_id = :id");
        return $stmt->execute([':id' => $id]);

    }

    public static function getAllClients(): array {

        $stmt = self::getPDO()->query("SELECT * FROM Client");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $clients = [];

        foreach ($rows as $row) {
            $client = new Client(
                $row['client_name'],
                $row['client_email'],
                $row['client_password'],
                json_decode($row['client_cart'], true),
                $row['client_signup_datetime']
            );
            $client->setId((int)$row['client_id']);
            $clients[] = $client;
        }

        return $clients;

    }

    public static function getClientById(int $id): ?Client {

        $stmt = self::getPDO()->prepare("SELECT * FROM Client WHERE client_id = :id AND client_logged = 1");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) return null;

        $client = new Client(
            $row['client_name'],
            $row['client_email'],
            $row['client_password'],
            json_decode($row['client_cart'], true),
            $row['client_signup_datetime']
        );

        $client->setId((int)$row['client_id']);

        return $client;

    }

    public static function validate(string $email, string $password): ?Client {

        $stmt = self::getPDO()->prepare("SELECT * FROM Client WHERE client_email = :email AND client_password = :clientPassword");
        $stmt->execute([
            ':email' => $email, 
            ':clientPassword' => password_hash($client->getPassword(), PASSWORD_BCRYPT)
        ]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) return null;

        $client = new Client(
            $row['client_name'],
            $row['client_email'],
            $row['client_password'],
            json_decode($row['client_cart'], true),
            $row['client_signup_datetime']
        );

        $client->setId((int)$row['client_id']);

        return $client;

    }

    public static function logClient($clientId, int $state) {

        $stmt = self::getPDO()->prepare("
            UPDATE Client
            SET client_logged = :state
            WHERE client_id = :id
        ");

        return $stmt->execute([
            ':state' => $state,
            ':id' => $clientId
        ]);

    }

}
