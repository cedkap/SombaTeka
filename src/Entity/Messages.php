<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MessagesRepository")
 */
class Messages
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Tittle;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Advert", inversedBy="messages")
     */
    private $Advert;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="messages")
     */
    private $User;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Description;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTittle(): ?string
    {
        return $this->Tittle;
    }

    public function setTittle(string $Tittle): self
    {
        $this->Tittle = $Tittle;

        return $this;
    }

    public function getAdvert(): ?Advert
    {
        return $this->Advert;
    }

    public function setAdvert(?Advert $Advert): self
    {
        $this->Advert = $Advert;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }
}
