<?php
class Plant {
    private ?int $ido;           // ID of the plant
    private ?string $namep;      // Name of the plant
    private ?string $descriptionp; // Description of the plant
    private ?string $statep;     // State of the plant (e.g., Active, Inactive)

    // Constructor to initialize the plant object
    public function __construct(?int $ido, string $namep, string $descriptionp, string $statep) {
        $this->ido = $ido;
        $this->namep = $namep;
        $this->descriptionp = $descriptionp;
        $this->statep = $statep; // Initialize state
    }

    // Getter for ID (ido)
    public function getIdo(): ?int {
        return $this->ido;
    }

    // Setter for ID (ido)
    public function setIdo(?int $ido): void {
        $this->ido = $ido;
    }

    // Getter for name (namep)
    public function getNamep(): ?string {
        return $this->namep;
    }

    // Setter for name (namep)
    public function setNamep(?string $namep): void {
        $this->namep = $namep;
    }

    // Getter for description (descriptionp)
    public function getDescriptionp(): ?string {
        return $this->descriptionp;
    }

    // Setter for description (descriptionp)
    public function setDescriptionp(?string $descriptionp): void {
        $this->descriptionp = $descriptionp;
    }

    // Getter for state (statep)
    public function getStatep(): ?string {
        return $this->statep;
    }

    // Setter for state (statep)
    public function setStatep(?string $statep): void {
        $this->statep = $statep;
    }
}
?>
