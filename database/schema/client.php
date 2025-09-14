<?php

class Client {

    private int $id;
    private string $name;
    private string $email;
    private string $password;

    private array $cart;
    private ?string $signupDatetime;

    public function __construct(string $name, string $email, string $password, array $cart = [], ?string $signupDatetime = null) {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->cart = $cart;
        $this->signupDatetime = $signupDatetime;
    }

    public static function from($data): self {

        $id = isset($data['clientId']) ? (int) $data['clientId']: 0;
        $cart = isset($data['clientCart']) ? json_decode($data['clientCart'], true): [];
        $datetime = isset($data['clientSignupDatetime']) ? $data['clientSignupDatetime']: null;

        if (empty($data['clientName']) || empty($data['clientEmail']) || empty($data['clientPassword'])) {
            throw new Exception("Incomplete data (name, email, password) to create the Client.");
        }

        $clientObject = new self(
                $data['clientName'], 
                $data['clientEmail'], 
                $data['clientPassword'], 
                $cart,
                $datetime
            );

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

    public function getSignUpDatetime(): ?string {
        return $this->signUpDatetime;
    }

    public function setSignupDatetime(?string $signupDatetime): void {
        $this->signupDatetime = $signupDatetime;
    }
    
}
