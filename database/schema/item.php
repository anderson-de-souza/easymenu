<?php

class Item {
    
    private int $id;
    private string $name;
    private string $description;
    private float $price;
    private string $imageUrl;

    public function __construct(string $name, string $description, float $price, string $imageUrl) {
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->imageUrl = $imageUrl;
    }

    public static function from($data): self {
        
        $id = isset($data['itemId']) ? (int) $data['itemId']: 0;
        $price = isset($data['itemPrice']) ? (float) $data['itemPrice']: 0.0;

        if (empty($data['itemName']) || empty($data['itemDescription']) || empty($data['itemImageUrl'])) {
            throw new Exception("Incomplete data (name, description, imageUrl) to create the Item.");
        }

        $itemObject = new self($data['itemName'], $data['itemDescription'], $price, $data['itemImageUrl']);
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