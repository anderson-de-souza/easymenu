<?php

require_once __DIR__ . '/database.php';
require_once __DIR__ . '/schema/item.php';

class ItemRepository {

    private static ?PDO $pdo = null;

    public static function getPDO(): ?PDO {

        if (!self::$pdo) {

            self::$pdo = Database::getPDO();

            $sql = "
                CREATE TABLE IF NOT EXISTS Item (
                    item_id INT AUTO_INCREMENT PRIMARY KEY,
                    item_name VARCHAR(64) NOT NULL,
                    item_description VARCHAR(255),
                    item_price DECIMAL(10,2) NOT NULL,
                    item_quantity INT DEFAULT 1 NOT NULL,
                    item_image_name VARCHAR(255) DEFAULT \"img_0.png\" NOT NULL,
                    item_created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
                );
            ";

            self::$pdo->exec($sql);

        }

        return self::$pdo;

    }

    public static function insert(Item $item) {
    
        $stmt = self::getPDO()->prepare("
            INSERT INTO Item (item_name, item_description, item_price, item_quantity, item_image_name)
            VALUES (:name, :description, :price, :itemQuantity, :imageName)
        ");
        
        $stmt->execute([
            ':name' => $item->getName(),
            ':description' => $item->getDescription(),
            ':price' => $item->getPrice(),
            ':itemQuantity' => $item->getQuantity(),
            ':imageName' => $item->getImageName(),
        ]);
        
        return self::$pdo->lastInsertId();
        
    }

    public static function update(Item $item) {
    
        $stmt = self::getPDO()->prepare("
            UPDATE Item
            SET item_name = :name, item_description = :description, item_price = :price, item_quantity = :itemQuantity, item_image_name = :imageName
            WHERE item_id = :id
        ");
        
        return $stmt->execute([
            ':name' => $item->getName(),
            ':description' => $item->getDescription(),
            ':price' => $item->getPrice(),
            ':itemQuantity' => $item->getQuantity(),
            ':imageName' => $item->getImageName(),
            ':id' => $item->getId()
        ]);
        
    }

    public static function delete(int $id) {
        $stmt = self::getPDO()->prepare("DELETE FROM Item WHERE item_id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public static function getAllItems(): array {
    
        $stmt = self::getPDO()->query("SELECT * FROM Item");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $items = [];
        
        foreach ($rows as $row) {
            
            $rowItem = new Item(
                $row['item_name'],
                $row['item_description'],
                (float) $row['item_price'],
                (int) $row['item_quantity'],
                $row['item_image_name']
            );
            $rowItem->setId((int) $row['item_id']);
            
            $items[] = $rowItem;
            
        }
        
        return $items;
        
    }

}
