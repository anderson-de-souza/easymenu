<?php

class Client {

    private int $id;
    private string $name;
    private string $email;
    private string $password;

    private array $cart;
    private string $signUpDatetime;

    public function __construct(string $name, string $email, string $password, array $cart = [], ?string $signUpDatetime = null) {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->cart = $cart;
        $this->signUpDatetime = $signUpDatetime ?? date('Y-m-d H:i:s');
    }

    public static function fromPost(): self {
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            throw new Exception("Error: The request must be a POST.");
        }

        $id = isset($_POST['clientId']) ? (int) $_POST['clientId']: 0;
        $name = $_POST['clientName'] ?? '';
        $email = $_POST['clientEmail'] ?? '';
        $password = $_POST['clientPassword'] ?? '';
        $cart = isset($_POST['clientCart']) ? json_decode($_POST['clientCart'], true): [];
        $signUpDatetime = $_POST['clientSignUpDatetime'] ?? null;

        if (empty($name) || empty($email) || empty($password)) {
            throw new Exception("Incomplete data (name, email, password) to create the Client.");
        }

        $clientObject = new self($name, $email, $password, $cart, $signUpDatetime);
        $clientObject->setId($id);

        return $clientObject;
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

    public function getCart(): array {
        return $this->cart;
    }

    public function setCart(array $cart): void {
        $this->cart = $cart;
    }

    public function getSignUpDatetime(): string {
        return $this->signUpDatetime;
    }

    public function setSignUpDatetime(string $signUpDatetime): void {
        $this->signUpDatetime = $signUpDatetime;
    }
    
}
