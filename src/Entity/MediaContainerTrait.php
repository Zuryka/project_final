<?php 

namespace App\Entity;

use Doctrine\DBAL\Types\Type;


trait MediaContainerTrait
{
    public function getMediaWithPhotoIdent(): ?Media
    {
        foreach ($this->medias as $media) {
            if ($media->getType() == "IMG" && $media->getCategorie() == "PHOTO_IDENT") {
                 return($media);
            }
        }
        return null;
    }
}