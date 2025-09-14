<?php

class Admin {

    private int $id;
    private string $name;
    private string $email;
    private string $password;
    private ?string $createdAt;

    public function __construct(string $name, string $email, string $password, ?string $createdAt = null) {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->createdAt = $createdAt;
    }

    public static function from($data): self {
        
        $id = isset($data['adminId']) ? (int) $data['adminId']: 0;
        $createdAt = isset($data['adminCreatedAt']) ? $data['adminCreatedAt']: null;

        if (empty($data['adminName']) || empty($data['adminEmail']) || empty($data['adminPassword'])) {
            throw new Exception("Incomplete data (name, email, password) to create the Admin.");
        }

        $adminObject = new self($data['adminName'], $data['adminEmail'], $data['adminPassword'], $createdAt);
        $adminObject->setId($id);

        return $adminObject;
    }

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function setPassword(string $password): void {
        $this->password = $password;
    }

    public function getCreatedAt(): ?string {
        return $this->createdAt;
    }

    public function setCreatedAt(?string $createdAt): void {
        $this->createdAt = $createdAt;
    }
    
}
