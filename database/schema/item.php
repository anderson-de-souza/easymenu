<?php

class Item {
    
    private int $id;
    private string $name;
    private string $description;
    private float $price;
    private int $quantity;
    private string $imageName;

    public function __construct(string $name, string $description, float $price, int $quantity = 0, string $imageName = "") {
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->imageName = $imageName;
    }

    public static function from($data): self {
        
        $id = isset($data['itemId']) ? (int) $data['itemId']: 0;
        $price = isset($data['itemPrice']) ? (float) $data['itemPrice']: 0.0;
        $quantity = isset($data['itemQuantity']) ? (int) $data['itemQuantity']: 0;

        if (empty($data['itemName']) || empty($data['itemDescription'])) {
            throw new Exception("Incomplete data (name, description) to create the Item.");
        }

        $itemObject = new self($data['itemName'], $data['itemDescription'], $price, $quantity);
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

    public function getQuantity(): int {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void {
        $this->quantity = $quantity;
    }

    public function getImageName(): string {
        return $this->imageName;
    }

    public function setImageName(string $imageName): void {
        $this->imageName = $imageName;
    }
    
}