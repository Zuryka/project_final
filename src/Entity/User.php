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
    private $date_inscription;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $code_postal;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $num_telephone;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $nom_artiste;

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
    private $instruments_comments;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $chants = [];

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $chants_comments;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $formations_comments;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Evenement", mappedBy="artistes")
     */
    private $evenements;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Formation", inversedBy="users")
     */
    private $formations;

    public function __construct()
    {
        parent::__construct();
        $this->evenements = new ArrayCollection();
        $this->formations = new ArrayCollection();
    }

    /**
     * Get the value of type
     *
     * @return  null|string
     */ 
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @param  null|string  $type
     *
     * @return  self
     */ 
    public function setType($type)
    {
        $this->type = $type;

        return $this;
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
        return $this->date_inscription;
    }

    public function setDateInscription(\DateTimeInterface $date_inscription): self
    {
        $this->date_inscription = $date_inscription;

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

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;

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

    public function getNomArtiste(): ?string
    {
        return $this->nom_artiste;
    }

    public function setNomArtiste(?string $nom_artiste): self
    {
        $this->nom_artiste = $nom_artiste;

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
        return $this->instruments_comments;
    }

    public function setInstrumentsComments(?string $instruments_comments): self
    {
        $this->instruments_comments = $instruments_comments;

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
        return $this->chants_comments;
    }

    public function setChantsComments(?string $chants_comments): self
    {
        $this->chants_comments = $chants_comments;

        return $this;
    }

    public function getFormationsComments(): ?string
    {
        return $this->formations_comments;
    }

    public function setFormationsComments(?string $formations_comments): self
    {
        $this->formations_comments = $formations_comments;

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
}