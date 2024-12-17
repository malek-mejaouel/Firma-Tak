<?php

class commentaire
{
    private ?int $id_post = null;
    private ?string $contenu = null;
    private ?string $date = null;
    private ?int $id_c = null;
    private ?string $emoji = null;


    public function __construct($contenu, $date, $id_post, $emoji = null)
    {
        $this->contenu = $contenu;
        $this->date = $date;
        $this->id_post= $id_post;
        $this->emoji = $emoji;
    }

    
    public function getId()
    {
        return $this->id_post;
    }

    
    public function getcontenu()
    {
        return $this->contenu;
    }

    
    public function setcontenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    
    public function getDate()
    {
        return $this->date;
    }

    
    public function setDate($date)
    {
        $this->date= $date;

        return $this;
    }


    public function getIDcommentaire()
    {
        return $this->id_c;
    }

    
    public function setIDcommentaire($id_c)
    {
        $this->id_c = $id_c;

        return $this;
    }

    public function getEmoji()
    {
        return $this->emoji;
    }

    public function setEmoji($emoji)
    {
        $this->emoji = $emoji;
    }
}