<?php
class Publication {
    private ?int $postId=null;
    private string $lien;
    private string $title;
    private string $image;
    private string $content;
    private string $creationDate;

    public function __construct($Id=null , $title,  $lien,$content, $creationDate) {
        $this->postId = $Id;
        $this->title = $title;
        $this->lien = $lien;
        $this->content = $content;
        $this->creationDate = $creationDate;
    }
 
    public function getPostId() {
        return $this->postId;
    }

    public function getLink() {
        return $this->lien;
    }

    public function getTitle() {
        return $this->title;
    }

   
    public function getContent() {
        return $this->content;
    }

    public function getCreationDate() {
        return $this->creationDate;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

  

    public function setContent($content) {
        $this->content = $content;
    }

   
}
?>