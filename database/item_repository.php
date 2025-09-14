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
                    item_image_url VARCHAR(255) NOT NULL
                );
            ";

            try {

                self::$pdo->exec($sql);

            } catch (PDOException $e) {

                if (!is_dir(__DIR__ . '/error/pdo')) {
                    mkdir(__DIR__ . '/error/pdo', 0777, true);
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

    public static function insert(Item $item) {
    
        $stmt = self::getPDO()->prepare("
            INSERT INTO Item (item_name, item_description, item_price, item_image_url)
            VALUES (:name, :description, :price, :imageUrl)
        ");
        
        $stmt->execute([
            ':name' => $item->getName(),
            ':description' => $item->getDescription(),
            ':price' => $item->getPrice(),
            ':imageUrl' => $item->getImageUrl(),
        ]);
        
        return self::$pdo->lastInsertId();
        
    }

    public static function update(Item $item) {
    
        $stmt = self::getPDO()->prepare("
            UPDATE Item
            SET item_name = :name, item_description = :description, item_price = :price, item_image_url = :imageUrl
            WHERE item_id = :id
        ");
        
        return $stmt->execute([
            ':name' => $item->getName(),
            ':description' => $item->getDescription(),
            ':price' => $item->getPrice(),
            ':imageUrl' => $item->getImageUrl(),
            ':id' => $item->getId()
        ]);
        
    }

    public static function delete(int $id) {
        $stmt = self::getPDO()->prepare("DELETE FROM Item WHERE id = :id");
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
                $row['item_image_url']
            );
            $rowItem->setId((int) $row['item_id']);
            
            $items[] = $rowItem;
            
        }
        
        return $items;
        
    }

}
