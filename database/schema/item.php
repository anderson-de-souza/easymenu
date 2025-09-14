<?php

class Item {
    
    private int $id;
    private string $name;
    private string $description;
    private float $price;
    private string $imageUrl;

    public function __construct(string $name, string $description, float $price, string $imageUrl) {
        $this->name        = $name;
        $this->description = $description;
        $this->price       = $price;
        $this->imageUrl    = $imageUrl;
    }

    public static function fromPost(): self {
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            throw new Exception("Error: The request must be a POST.");
        }
        
        $id = isset($_POST['itemId']) ? (int) $_POST['itemId']: 0;
        $name = $_POST['itemName'] ?? '';
        $description = $_POST['itemDescription'] ?? '';
        $price = isset($_POST['itemPrice']) ? (float) $_POST['itemPrice']: 0.0;
        $imageUrl = $_POST['itemImageUrl'] ?? '';

        if (empty($name) || empty($description) || empty($imageUrl)) {
            throw new Exception("Incomplete data (name, description, imageUrl) to create the Item.");
        }

        $itemObject = new self($name, $description, $price, $imageUrl);
        $itemObject->setId($id);
        
        return $itemObject;
        
    }
    
    public function getId(): int {
        return $this->id;
    }
    
    public function setId($id): void {
        $this->id = $id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function setDescription(string $description): void {
        $this->description = $description;
    }

    public function getPrice(): float {
        return $this->price;
    }

    public function setPrice(float $price): void {
        $this->price = $price;
    }

    public function getImageUrl(): string {
        return $this->imageUrl;
    }

    public function setImageUrl(string $imageUrl): void {
        $this->imageUrl = $imageUrl;
    }
    
}