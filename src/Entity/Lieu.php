<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LieuRepository")
 */
class Lieu
{
    use MediaContainerTrait;
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
     * @ORM\Column(type="string", length=50)
     */
    private $type;

    /**
     * @ORM\Column(type="text")
     */
    private $presentation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $code_postal;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $ville;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $latitude;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $longitude;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $num_telephone;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_createur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $user_contact;

    /**
     * @var ?\Doctrine\Common\Collections\ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Entity\Media", mappedBy="evenement")
     */
    private $medias;

    
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

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(string $presentation): self
    {
        $this->presentation = $presentation;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->code_postal;
    }

    public function setCodePostal(string $code_postal): self
    {
        $this->code_postal = $code_postal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getNumTelephone(): ?string
    {
        return $this->num_telephone;
    }

    public function setNumTelephone(?string $num_telephone): self
    {
        $this->num_telephone = $num_telephone;

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

    /**
     * Get the value of medias
     *
     * @return  ?\Doctrine\Common\Collections\ArrayCollection
     */ 
    public function getMedias()
    {
        return $this->medias;
    }

    /**
     * Set the value of medias
     *
     * @param  ?\Doctrine\Common\Collections\ArrayCollection  $medias
     *
     * @return  self
     */ 
    public function setMedias(?\Doctrine\Common\Collections\ArrayCollection $medias)
    {
        $this->medias = $medias;

        return $this;
    }
}
