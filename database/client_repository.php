<?php

require_once __DIR__ . '/connect_to_database.php';
require_once __DIR__ . '/schema/client.php';

$sql = "
    CREATE TABLE IF NOT EXISTS Client (
        client_id INT AUTO_INCREMENT PRIMARY KEY,
        client_name VARCHAR(64) NOT NULL,
        client_email VARCHAR(128) NOT NULL UNIQUE,
        client_password VARCHAR(255) NOT NULL,
        client_cart TEXT,
        client_sign_up_datetime DATETIME NOT NULL,
        client_logged TINYINT(1) CHECK (client_logged IN (0, 1)) DEFAULT 1 NOT NULL
    );
";

try {
    $pdo->exec($sql);
} catch (PDOException $e) {
    echo "PDO Error: " . $e->getMessage();
}

function insertClient(Client $client) {

    global $pdo;

    $stmt = $pdo->prepare("
        INSERT INTO Client (client_name, client_email, client_password, client_cart, client_sign_up_datetime)
        VALUES (:name, :email, :password, :cart, :signUpDatetime)
    ");

    $stmt->execute([
        ':name' => $client->getName(),
        ':email' => $client->getEmail(),
        ':password' => password_hash($client->getPassword(), PASSWORD_BCRYPT),
        ':cart' => json_encode($client->getCart()),
        ':signUpDatetime' => $client->getSignUpDatetime()
    ]);

    return $pdo->lastInsertId();

}

function updateClient(Client $client) {

    global $pdo;

    $stmt = $pdo->prepare("
        UPDATE Client
        SET client_name = :name, client_email = :email, client_password = :password, client_cart = :cart, client_sign_up_datetime = :signUpDatetime
        WHERE client_id = :id
    ");

    return $stmt->execute([
        ':name' => $client->getName(),
        ':email' => $client->getEmail(),
        ':password' => password_hash($client->getPassword(), PASSWORD_BCRYPT),
        ':cart' => json_encode($client->getCart()),
        ':signUpDatetime' => $client->getSignUpDatetime(),
        ':id' => $client->getId()
    ]);

}


function deleteClient(int $id) {

    global $pdo;

    $stmt = $pdo->prepare("DELETE FROM Client WHERE client_id = :id");
    return $stmt->execute([':id' => $id]);

}

function getAllClients(): array {

    global $pdo;

    $stmt = $pdo->query("SELECT * FROM Client");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $clients = [];

    foreach ($rows as $row) {
        $client = new Client(
            $row['client_name'],
            $row['client_email'],
            $row['client_password'],
            json_decode($row['client_cart'], true),
            $row['client_sign_up_datetime']
        );
        $client->setId((int)$row['client_id']);
        $clients[] = $client;
    }

    return $clients;

}

function getClientById(int $id): ?Client {

    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM Client WHERE client_id = :id");
    $stmt->execute([':id' => $id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) return null;

    $client = new Client(
        $row['client_name'],
        $row['client_email'],
        $row['client_password'],
        json_decode($row['client_cart'], true),
        $row['client_sign_up_datetime']
    );

    $client->setId((int)$row['client_id']);

    return $client;

}

function getClientByEmailPassword(string $email, string $password): ?Client {

    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM Client WHERE client_email = :email AND client_password = :clientPassword");
    $stmt->execute([':email' => $email, ':clientPassword' => $password]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) return null;

    $client = new Client(
        $row['client_name'],
        $row['client_email'],
        $row['client_password'],
        json_decode($row['client_cart'], true),
        $row['client_sign_up_datetime']
    );

    $client->setId((int)$row['client_id']);

    return $client;

}

function logClient($clientId, int $state) {
    
    global $pdo;

    $stmt = $pdo->prepare("
        UPDATE Client
        SET client_logged = :state
        WHERE client_id = :id
    ");

    return $stmt->execute([
        ':state' => $state,
        ':id' => $clientId
    ]);

}