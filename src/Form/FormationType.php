<?php

namespace App\Form;

use App\Entity\Formation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use App\Form\ImageType;

class FormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image', ImageType::class, array(
                'label' => 'formation.photo',
            ))

            ->add('nom', Type\TextType::class, array(
                'label' => 'formation.nom',
                'required' => true,
            ))

            ->add('type', Type\ChoiceType::class, array(
                'label' => 'formation.type',
                'choices' => array(
                    'Band music' => 'Band music',
                    'Bandas' => 'Bandas',
                    'Batterie Fanfare' => 'Batterie Fanfare',
                    'Big band' => 'Big band',
                    'Brass band' => 'Brass band',
                    'Charanga' => 'Charanga',
                    'Chœur' => 'Chœur',
                    'Chorale' => 'Chorale',
                    'Conjunto' => 'Conjunto',
                    'Fanfare' => 'Fanfare',
                    'Harmonie-Fanfare' => 'Harmonie-Fanfare',
                    'Jazz band' => 'Jazz band',
                    'Orchestres' => 'Orchestres',
                    'Pipe band' => 'Pipe band',
                    'Autre ...' => 'Autre',
                ),
                'required' => true,
            ))

            ->add('localisation', Type\TextType::class, array(
                'label' => 'formation.localisation',
                'required' => true,
            ))
            
            ->add('presentation', Type\TextareaType::class, array(
                'label' => 'formation.presentation',
                'required' => true,
            ))

            ->add('styles', Type\ChoiceType::class, array(
                'label' => 'formation.styles',
                'choices' => array(
                    'Blues' => 'Blues',
                    'Classique' => 'Classique',
                    'Country' => 'Country',
                    'Electro' => 'Electro',
                    'Folk & Acoustic' => 'Folk & Acoustic',
                    'Funk' => 'Funk',
                    'Hip-hop' => 'Hip-hop',
                    'Indie' => 'Indie',
                    'K-Pop/J-Pop' => 'K-Pop/J-Pop',
                    'Latino' => 'Latino',
                    'Metal' => 'Metal',
                    'Pop' => 'Pop',
                    'Punk' => 'Punk',
                    'Reggae/Dancehall' => 'Reggae/Dancehall',
                    'RnB' => 'RnB',
                    'Rock' => 'Rock',
                    'Soul' => 'Soul',
                    'Autre...' => 'Autre',
                ),
                'required' => true,
                'multiple' => true,
            ))

            ->add('niveau', Type\ChoiceType::class, array(
                'label' => 'formation.niveau',
                'choices' => array(
                    'Professionnel' => 'Professionnel',
                    'Semi-professionnel' => 'Semi-professionnel',
                    'Amateur' => 'Amateur',
                ),
                'required' => false,
            ))
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event){
            $entity = $event->getData(); // Entité envoyée au formulaire
            $form = $event->getForm(); // Récupère le formulaire

            if (!is_null($entity->getImage())) { // S'il y a une image dans mon article
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
            'data_class' => Formation::class,
        ]);
    }
}
