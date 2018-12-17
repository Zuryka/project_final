<?php 

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    const TYPE_GERANT_SALLE = 'user_local';
    const TYPE_ARTISTE = 'user_artiste';
    const TYPE_ORGANISTEUR_EVENEMENT = 'user_evenement';

    use MediaContainerTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $prenom;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateInscription;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $codePostal;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $numTelephone;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $nomArtiste;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $presentation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $niveau;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $styles = [];

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $instruments = [];

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $instrumentsComments;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $chants = [];

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $chantsComments;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $formationsComments;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Evenement", mappedBy="artistes")
     * @var string
     */
    private $evenements;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Formation", inversedBy="users")
     */
    private $formations;

    /**
     * @ORM\Column(type="array")
     */
    private $type = [];

    /**
     * @var ?\Doctrine\Common\Collections\ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Entity\Media", cascade={"all"}, mappedBy="user")
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
        parent::__construct();
        $this->evenements = new ArrayCollection();
        $this->formations = new ArrayCollection();
        $this->dateInscription = new \Datetime;
        $this->deleteImage = false;
    }


    //================== Mutateur ============================

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->dateInscription;
    }

    public function setDateInscription(\DateTimeInterface $dateInscription): self
    {
        $this->dateInscription = $dateInscription;

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

    public function setCodePostal(string $codePostal): self
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

    public function getNumTelephone(): ?string
    {
        return $this->numTelephone;
    }

    public function setNumTelephone(?string $numTelephone): self
    {
        $this->numTelephone = $numTelephone;

        return $this;
    }

    public function getNomArtiste(): ?string
    {
        return $this->nomArtiste;
    }

    public function setNomArtiste(?string $nomArtiste): self
    {
        $this->nomArtiste = $nomArtiste;

        return $this;
    }

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(?string $presentation): self
    {
        $this->presentation = $presentation;

        return $this;
    }

    public function getNiveau(): ?string
    {
        return $this->niveau;
    }

    public function setNiveau(string $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    public function getStyles(): ?array
    {
        return $this->styles;
    }

    public function setStyles(?array $styles): self
    {
        $this->styles = $styles;

        return $this;
    }

    public function getInstruments(): ?array
    {
        return $this->instruments;
    }

    public function setInstruments(?array $instruments): self
    {
        $this->instruments = $instruments;

        return $this;
    }

    public function getInstrumentsComments(): ?string
    {
        return $this->instrumentsComments;
    }

    public function setInstrumentsComments(?string $instrumentsComments): self
    {
        $this->instrumentsComments = $instrumentsComments;

        return $this;
    }

    public function getChants(): ?array
    {
        return $this->chants;
    }

    public function setChants(?array $chants): self
    {
        $this->chants = $chants;

        return $this;
    }

    public function getChantsComments(): ?string
    {
        return $this->chantsComments;
    }

    public function setChantsComments(?string $chantsComments): self
    {
        $this->chantsComments = $chantsComments;

        return $this;
    }

    public function getFormationsComments(): ?string
    {
        return $this->formationsComments;
    }

    public function setFormationsComments(?string $formationsComments): self
    {
        $this->formationsComments = $formationsComments;

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
            $evenement->addArtiste($this);
        }

        return $this;
    }

    public function removeEvenement(Evenement $evenement): self
    {
        if ($this->evenements->contains($evenement)) {
            $this->evenements->removeElement($evenement);
            $evenement->removeArtiste($this);
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

    public function getType(): ?array
    {
        return $this->type;
    }

    public function setType(array $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function setPlainPassword($password)
    {
        if (!empty($password)) {
            $this->plainPassword = $password;
        }
        
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