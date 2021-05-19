<?php

namespace App\Entity;

use App\Repository\TodoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TodoRepository::class)
 */
class Todo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="text")
     */
    private $title;
    /**
     * @ORM\Column(type="text")
     */
    private $body;
    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isDone;

    //Getters & setters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(){
        return $this-> title;
    }
    public function setTitle($title){
        $this-> title = $title;
    }
    public function getIsDone(){
        return $this-> isDone;
    }
    public function setIsDone($isDone){
        $this-> isDone = $isDone;
    }
    public function getBody(){
        return $this-> body;
    }
    public function setBody($body){
        $this-> body = $body;
    }
}
