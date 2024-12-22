<?php
class Animal {
    private ?int $id;
    private ?string $name;
    private ?string $description;
    private ?string $state; // Add state property

    public function __construct(?int $id, string $name, string $description, string $state) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->state = $state; // Initialize state
    }

    // Getter for ID
    public function getId(): ?int {
        return $this->id;
    }

    // Setter for ID
    public function setId(?int $id): void {
        $this->id = $id;
    }

    // Getter for name
    public function getName(): ?string {
        return $this->name;
    }

    // Setter for name
    public function setName(?string $name): void {
        $this->name = $name;
    }

    // Getter for description
    public function getDescription(): ?string {
        return $this->description; // Getter for description
    }

    // Setter for description
    public function setDescription(?string $description): void {
        $this->description = $description; // Setter for description
    }

    // Getter for state
    public function getState(): ?string {
        return $this->state; // Getter for state
    }

    // Setter for state
    public function setState(?string $state): void {
        $this->state = $state; // Setter for state
    }
}
?>