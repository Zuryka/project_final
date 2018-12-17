<?php

namespace App\Form;

use App\Entity\Evenement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use App\Form\ImageType;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        
        $builder
        ->add('nom', Type\TextType::class, array(
            'label' => 'evenement.nom',
            'required' => true,
        ))
        ->add('image', ImageType::class, array(
            'label' => 'evenement.photo',
        ))
        ->add('type', Type\ChoiceType::class, array(
            'label' => 'evenement.type',
            'placeholder' => 'Choisissez le type d\'événement...',
            'choices' => array(
                'Bal' => 'Bal',
                'Concert' => 'Concert',
                'Festival' => 'Festival',
                'Jam Session' => 'Jam Session',
                'Karaoke' => 'Karaoke',
                'Récital' => 'Recital',
                'Répétition' => 'Répétition',
                'Show Case' => 'Show Case',
                'Autre ...' => 'Autre',
            ),
            'required' => true,
        ))
        ->add('styles', Type\ChoiceType::class, array(
            'label' => 'evenement.styles',
            'choices' => array(
                'Blues' => 'Blues',
                'Chanson française' => 'Chanson française',
                'Chorale' => 'Chorale',
                'Classique' => 'Classique',
                'Country' => 'Country',
                'Electro' => 'Electro',
                'Folk & Acoustic' => 'Folk & Acoustic',
                'Funk' => 'Funk',
                'Hip-hop' => 'Hip-hop',
                'Indie' => 'Indie',
                'Jazz' => 'Jazz',
                'K-Pop/J-Pop' => 'K-Pop/J-Pop',
                'Latino' => 'Latino',
                'Metal' => 'Metal',
                'Pop' => 'Pop',
                'Punk' => 'Punk',
                'Rap' => 'Rap',
                'Reggae' => 'Reggae',
                'RnB' => 'RnB',
                'Rock' => 'Rock',
                'Soul' => 'Soul',
                'Autre...' => 'Autre',
            ),
            'required' => true,
            'multiple' => true,
        ))
        ->add('presentation', Type\TextareaType::class, array(
            'label' => 'evenement.presentation',
            'required' => true,
        ))
        ->add('nom_lieu', Type\TextType::class, array(
            'label' => 'evenement.lieu',
            'required' => false,
        ))
        ->add('adresse', Type\TextType::class, array(
            'label' => 'evenement.adresse',
            'required' => false,
        ))
        ->add('code_postal', Type\IntegerType::class, array(
            'label' => 'evenement.code_postal',
            'required' => false,
        ))
        ->add('ville', Type\TextType::class, array(
            'label' => 'evenement.ville',
            'required' => true,
        ))
        ->add('numTelephone', Type\TelType::class, array(
            'label' => 'evenement.numTelephone',
            'required' => false,
        ))
        ->add('tarif', Type\MoneyType::class, array(
            'label' => 'evenement.tarif',
            'required' => false,
            'scale' => 2
        ))
        ->add('date', Type\DateType::class, array(
            'label' => 'evenement.date',
            'placeholder' => array(
                'year' => 'Année',
                'month' => 'Mois',
                'day' => 'Jour',
            ),
            // 'years' => $years,
            'required' => true,
        ))
        ->add('heureDebut', Type\TimeType::class, array(
            'label' => 'evenement.heureDebut',
            'required' => true,
        ))
        ->add('heureFin', Type\TimeType::class, array(
            'label' => 'evenement.heureFin',
            'required' => false,
        ))
        ;
        
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event){
            $entity = $event->getData(); // Entité envoyée au formulaire
            $form = $event->getForm(); // Récupère le formulaire

            if (!is_null($entity->getImage())) { // S'il y a une image dans mon évènement
                // Ajout du champ "deleteImage" seulement s'il y a une image
                $form->add('deleteImage', Type\CheckboxType::class, array(
                    'label' => 'image.delete',
                    'required' => false, // Désactive le required
                ));
            }

        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
