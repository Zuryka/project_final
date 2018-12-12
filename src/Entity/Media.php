<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MediaRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Media
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lien;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $categorie;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Formation")
     */
    private $formation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Lieu")
     */
    private $lieu;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Evenement", inversedBy="medias")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $evenement;

    /**
     * @var UploadedFile
     * @Assert\Image(
     * maxSize = "2M"
     * )
     */
    private $file;

    /**
     * @var ?string
     * Chemin de l'ancien fichier
     */
    private $oldPath;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getLien(): ?string
    {
        return $this->lien;
    }

    public function setLien(string $lien): self
    {
        $this->lien = $lien;

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

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(?string $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getFormation(): ?Formation
    {
        return $this->formation;
    }

    public function setFormation(?Formation $formation): self
    {
        $this->formation = $formation;

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

    public function getEvenement(): ?Evenement
    {
        return $this->evenement;
    }

    public function setEvenement(?Evenement $evenement): self
    {
        $this->evenement = $evenement;

        return $this;
    }

    /**
     * Get maxSize = "2M"
     *
     * @return  UploadedFile
     */ 
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set maxSize = "2M"
     *
     * @param  UploadedFile  $file  maxSize = "2M"
     *
     * @return  self
     */ 
    public function setFile(UploadedFile $file)
    {
        // Sauvegarde le chemin de l'ancien fichier pour le supprimer lors de l'upload du nouveau
        $this->oldPath = $this->path; 
        // Modifie cette valeur pour activer la modif Doctrine
        $this->path = ''; 
        
        $this->file = $file;

        return $this;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function generatePath()
    {
        if ($this->file instanceof UploadedFile){
            // Génére le chemin du fichier à uploader
            $this->path = uniqid('img_') . '.' . $this->file->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (is_file($this->getPublicRootDirImg() . $this->oldPath)) {
            unlink($this->getPublicRootDirImg() . $this->oldPath);
        }

        if ($this->file instanceof UploadedFile){
            $this->file->move(
                $this->getPublicRootDirImg(), // Vers le dossier public/uploads
                $this->path
            );
        }
    }

    public function getPublicRootDirImgImg()
    {
        return __DIR__ . '/../../public/uploads/img/';
    }

    /**
     * @ORM\PreRemove()
     */
    public function remove()
    {
        // Test si le fichier existe
        if (is_file($this->getPublicRootDirImg() . $this->path)) {
            unlink($this->getPublicRootDirImg() . $this->path);
        }
    }
}
