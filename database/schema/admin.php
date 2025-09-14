<?php

class Admin {

    private int $id;
    private string $name;
    private string $email;
    private string $password;
    private string $createdAt;

    public function __construct(string $name, string $email, string $password, ?string $createdAt = null) {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->createdAt = $createdAt ?? date('Y-m-d H:i:s');
    }

    public static function fromPost(): self {
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            throw new Exception("Error: The request must be a POST.");
        }

        $id = isset($_POST['adminId']) ? (int) $_POST['adminId']: 0;
        $name = $_POST['adminName'] ?? '';
        $email = $_POST['adminEmail'] ?? '';
        $password = $_POST['adminPassword'] ?? '';
        $createdAt = $_POST['adminCreatedAt'] ?? null;

        if (empty($name) || empty($email) || empty($password)) {
            throw new Exception("Incomplete data (name, email, password) to create the Admin.");
        }

        $adminObject = new self($name, $email, $password, $createdAt);
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

    public function getCreatedAt(): string {
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt): void {
        $this->createdAt = $createdAt;
    }
    
}
