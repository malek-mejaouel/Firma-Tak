<?php
class Produit {
    private ?int $idProduct = null;        // Product ID
    private string $productName;           // Product name
    private int $quantity;                 // Product quantity
    private float $unitPrice;              // Unit price of the product

    // Constructor with the product attributes
    public function __construct($idProduct = null, $productName, $quantity, $unitPrice) {
        $this->idProduct = $idProduct;
        $this->productName = $productName;
        $this->quantity = $quantity;
        $this->unitPrice = $unitPrice;
    }

    // Getters
    public function getIdProduct() {
        return $this->idProduct;
    }

    public function getName() {
        return $this->productName;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function getPrice() {
        return $this->unitPrice;
    }

    // Setters
    public function setName($productName) {
        $this->productName = $productName;
    }

    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }

    public function setPrice($unitPrice) {
        $this->unitPrice = $unitPrice;
    }

    public function setIdProduct($idProduct) {
        $this->idProduct = $idProduct;
    }
}
?>
