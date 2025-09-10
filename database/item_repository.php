<?php
    
require_once __DIR__ . '/connect_to_database.php';
require_once __DIR__ . '/item.php';

$sql = "
    CREATE TABLE IF NOT EXISTS Item (
        item_id INT AUTO_INCREMENT PRIMARY KEY,
        item_name VARCHAR(64) NOT NULL,
        item_description VARCHAR(255),
        item_price DECIMAL(10,2) NOT NULL,
        item_image_url VARCHAR(255) NOT NULL
    );
";

try {
    $pdo->exec($sql);
} catch (PDOException $e) {
    echo "PDO Error: " . $e->getMessage();
}


function insertItem(Item $item) {
    
    global $pdo;
    
    $stmt = $pdo->prepare("
        INSERT INTO Item (item_name, item_description, item_price, item_image_url)
        VALUES (:name, :description, :price, :imageUrl)
    ");
    
    $stmt->execute([
        ':name' => $item->getName(),
        ':description' => $item->getDescription(),
        ':price' => $item->getPrice(),
        ':imageUrl' => $item->getImageUrl(),
    ]);
    
    return $pdo->lastInsertId();
    
}

function updateItem(Item $item) {
    
    global $pdo;
    
    $stmt = $pdo->prepare("
        UPDATE Item
        SET item_name = :name, item_description = :description, item_price = :price, item_image_url = :imageUrl
        WHERE item_id = :id
    ");
    
    return $stmt->execute([
        ':name' => $item->getName(),
        ':description' => $item->getDescription(),
        ':price' => $item->getPrice(),
        ':imageUrl' => $item->getImageUrl(),
        ':id' => $id
    ]);
    
}

function deleteItem(int $id) {
    
    global $pdo;
    
    $stmt = $pdo->prepare("DELETE FROM Item WHERE id = :id");
    return $stmt->execute([':id' => $id]);
    
}

function getAllItems(): array {
    
    global $pdo;
    
    $stmt = $pdo->query("SELECT * FROM Item");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $items = [];
    
    foreach ($rows as $row) {
        
        $rowItem = new Item(
            $row['item_name'],
            $row['item_description'],
            (float) $row['item_price'],
            $row['item_image_url']
        );
        $rowItem->setId((int) $row['item_id']);
        
        $items[] = $rowItem;
        
    }
    
    return $items;
    
}