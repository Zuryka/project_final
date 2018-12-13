<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EvenementRepository")
 */
class Evenement
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
     * @ORM\Column(type="array")
     */
    private $styles;

    /**
     * @ORM\Column(type="text")
     */
    private $presentation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $codePostal; // code_postal

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
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
    private $numTelephone;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $tarif;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="time")
     */
    private $heureDebut;

    /**
     * @ORM\Column(type="time")
     */
    private $heureFin;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userCreateur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $userContact;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Lieu")
     */
    private $lieu;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="evenements")
     */
    private $artistes;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Formation", inversedBy="evenements")
     */
    private $formations;

    /**
     * @var ?\Doctrine\Common\Collections\ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Entity\Media", cascade={"all"}, mappedBy="evenement")
     */
    private $medias;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Image", cascade={"all"}, orphanRemoval=true)
     * @var ?\App\Entity\Image
     */
    private $image;

    /**
     * @var bool
     */
    private $deleteImage;

    public function __construct()
    {
        $this->artistes = new ArrayCollection();
        $this->formations = new ArrayCollection();
        $this->deleteImage = false;
    }

    //============= Mutateur ==========================

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

    public function getStyles(): ?array
    {
        return $this->styles;
    }

    public function setStyles(array $styles): self
    {
        $this->styles = $styles;

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

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(?string $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
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
        return $this->numTelephone;
    }

    public function setNumTelephone(?string $numTelephone): self
    {
        $this->numTelephone = $numTelephone;

        return $this;
    }

    public function getTarif(): ?float
    {
        return $this->tarif;
    }

    public function setTarif(?float $tarif): self
    {
        $this->tarif = $tarif;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getHeureDebut(): ?\DateTimeInterface
    {
        return $this->heureDebut;
    }

    public function setHeureDebut(\DateTimeInterface $heureDebut): self
    {
        $this->heureDebut = $heureDebut;

        return $this;
    }

    public function getHeureFin(): ?\DateTimeInterface
    {
        return $this->heureFin;
    }

    public function setHeureFin(\DateTimeInterface $heureFin): self
    {
        $this->heureFin = $heureFin;

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

    public function getIdUserCreateur(): ?User
    {
        return $this->userCreateur;
    }

    public function setIdUserCreateur(?User $userCreateur): self
    {
        $this->userCreateur = $userCreateur;

        return $this;
    }

    public function getUserContact(): ?User
    {
        return $this->userContact;
    }

    public function setUserContact(?User $userContact): self
    {
        $this->userContact = $userContact;

        return $this;
    }

    public function getLieu(): ?Lieu
    {
        return $this->lieu;
    }

    public function setLieu(?Lieu $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getArtistes(): Collection
    {
        return $this->artistes;
    }

    public function addArtiste(User $artiste): self
    {
        if (!$this->artistes->contains($artiste)) {
            $this->artistes[] = $artiste;
        }

        return $this;
    }

    public function removeArtiste(User $artiste): self
    {
        if ($this->artistes->contains($artiste)) {
            $this->artistes->removeElement($artiste);
        }

        return $this;
    }

    /**
     * @return Collection|Formation[]
     */
    public function getFormations(): Collection
    {
        return $this->formations;
    }

    public function addFormation(Formation $formation): self
    {
        if (!$this->formations->contains($formation)) {
            $this->formations[] = $formation;
        }

        return $this;
    }

    public function removeFormation(Formation $formation): self
    {
        if ($this->formations->contains($formation)) {
            $this->formations->removeElement($formation);
        }

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
    
    /**
     * Get the value of image
     *
     * @return  ?\App\Entity\Image
     */ 
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set the value of image
     *
     * @param  ?\App\Entity\Image  $image
     *
     * @return  self
     */ 
    public function setImage(?\App\Entity\Image $image)
    {
        if ($image instanceof Image && !is_null($image->getFile())){ // Test si une image est envoyéee
            $this->image = $image;
        }

        return $this;
    }

    /**
     * Get the value of deleteImage
     *
     * @return  bool
     */ 
    public function getDeleteImage()
    {
        return $this->deleteImage;
    }

    /**
     * Set the value of deleteImage
     *
     * @param  bool  $deleteImage
     *
     * @return  self
     */ 
    public function setDeleteImage(bool $deleteImage)
    {
        $this->deleteImage = $deleteImage;
        if ($deleteImage){
            $this->image = null;
        }

        return $this;
    }
}
