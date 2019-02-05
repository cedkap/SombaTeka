<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RegionRepository")
 */
class Region
{
    public function __toString()
    {
        /*utilisé */
        return $this->getName();
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $Datecreate;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="Region")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Advert", mappedBy="Region")
     */
    private $adverts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="Region")
     */
    private $Region;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->adverts = new ArrayCollection();
        $this->Region = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getDatecreate(): ?\DateTimeInterface
    {
        return $this->Datecreate;
    }

    public function setDatecreate(\DateTimeInterface $Datecreate): self
    {
        $this->Datecreate = $Datecreate;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setRegion($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getRegion() === $this) {
                $user->setRegion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Advert[]
     */
    public function getAdverts(): Collection
    {
        return $this->adverts;
    }

    public function addAdvert(Advert $advert): self
    {
        if (!$this->adverts->contains($advert)) {
            $this->adverts[] = $advert;
            $advert->setRegion($this);
        }

        return $this;
    }

    public function removeAdvert(Advert $advert): self
    {
        if ($this->adverts->contains($advert)) {
            $this->adverts->removeElement($advert);
            // set the owning side to null (unless already changed)
            if ($advert->getRegion() === $this) {
                $advert->setRegion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getRegion(): Collection
    {
        return $this->Region;
    }

    public function addRegion(User $region): self
    {
        if (!$this->Region->contains($region)) {
            $this->Region[] = $region;
            $region->setRegion($this);
        }

        return $this;
    }

    public function removeRegion(User $region): self
    {
        if ($this->Region->contains($region)) {
            $this->Region->removeElement($region);
            // set the owning side to null (unless already changed)
            if ($region->getRegion() === $this) {
                $region->setRegion(null);
            }
        }

        return $this;
    }
}
