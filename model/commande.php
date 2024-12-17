<?php

class Commande
{
    private ?int $id_commande = null;        // ID_Commande (clé primaire)
    private ?int $id_produit = null;         // ID_Produit (clé étrangère)
    private ?int $quantite_commande = null;  // Quantite_Commande
    private ?string $date_commande = null;   // Date_Commande

    // Constructeur pour initialiser les propriétés
    public function __construct($id_produit, $quantite_commande, $date_commande)
    {
        $this->id_produit = $id_produit;
        $this->quantite_commande = $quantite_commande;
        $this->date_commande = $date_commande;
    }

    // Getter et Setter pour id_commande
    public function getIdCommande()
    {
        return $this->id_commande;
    }

    public function setIdCommande($id_commande)
    {
        $this->id_commande = $id_commande;
        return $this;
    }

    // Getter et Setter pour id_produit
    public function getIdProduit()
    {
        return $this->id_produit;
    }

    public function setIdProduit($id_produit)
    {
        $this->id_produit = $id_produit;
        return $this;
    }

    // Getter et Setter pour quantite_commande
    public function getQuantiteCommande()
    {
        return $this->quantite_commande;
    }

    public function setQuantiteCommande($quantite_commande)
    {
        $this->quantite_commande = $quantite_commande;
        return $this;
    }

    // Getter et Setter pour date_commande
    public function getDateCommande()
    {
        return $this->date_commande;
    }

    public function setDateCommande($date_commande)
    {
        $this->date_commande = $date_commande;
        return $this;
    }
}
