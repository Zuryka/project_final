<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FormationRepository")
 */
class Formation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $localisation;

    /**
     * @ORM\Column(type="text")
     */
    private $presentation;

    /**
     * @ORM\Column(type="array")
     */
    private $styles = [];

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $niveau;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Evenement", mappedBy="formations")
     */
    private $evenements;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="formations")
     */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_createur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_contact;

    public function __construct()
    {
        $this->evenements = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    public function setLocalisation(string $localisation): self
    {
        $this->localisation = $localisation;

        return $this;
    }

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(string $presentation): self
    {
        $this->presentation = $presentation;

        return $this;
    }

    public function getStyles(): ?array
    {
        return $this->styles;
    }

    public function setStyles(array $styles): self
    {
        $this->styles = $styles;

        return $this;
    }

    public function getNiveau(): ?string
    {
        return $this->niveau;
    }

    public function setNiveau(?string $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    /**
     * @return Collection|Evenement[]
     */
    public function getEvenements(): Collection
    {
        return $this->evenements;
    }

    public function addEvenement(Evenement $evenement): self
    {
        if (!$this->evenements->contains($evenement)) {
            $this->evenements[] = $evenement;
            $evenement->addFormation($this);
        }

        return $this;
    }

    public function removeEvenement(Evenement $evenement): self
    {
        if ($this->evenements->contains($evenement)) {
            $this->evenements->removeElement($evenement);
            $evenement->removeFormation($this);
        }

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
            $user->addFormation($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $user->removeFormation($this);
        }

        return $this;
    }

    public function getUserCreateur(): ?User
    {
        return $this->user_createur;
    }

    public function setUserCreateur(?User $user_createur): self
    {
        $this->user_createur = $user_createur;

        return $this;
    }

    public function getUserContact(): ?User
    {
        return $this->user_contact;
    }

    public function setUserContact(?User $user_contact): self
    {
        $this->user_contact = $user_contact;

        return $this;
    }

}
