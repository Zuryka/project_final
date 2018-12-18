<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use App\Form\ImageType;

class ArtisteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image', ImageType::class, array(
                'label' => 'user.artiste.photo',
            ))

            ->add('nomArtiste', Type\TextType::class, array(
                'label' => 'user.artistename',
                'required' => false,
            ))

            ->add('presentation', Type\TextareaType::class, array(
                'label' => 'user.presentation',
                'required' => false,
            ))

            ->add('niveau', ChoiceButtonType::class, array(
                'label' => 'user.niveau',
                'choices'  => array(
                    'amateur' => 'amateur',
                    'semi-pro' => 'semi-pro',
                    'pro' => 'pro',
                ),
                'required' => false,
                'expanded' => true,
            ))

            ->add('styles', ChoiceButtonType::class, array(
                    'label' => 'user.styles.liste',
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
                    'required' => false,
                    'multiple' => true,
                    'expanded' => true,

                ))

            ->add('instruments', ChoiceButtonType::class, array(
                'label' => 'user.instruments.liste',
                'choices' => array(
                    'guitare' => 'guitare',
                    'violon' => 'violon',
                    'batterie' => 'batterie',
                    'contrebasse' => 'contrebasse',
                    'triangle' => 'triangle',
                    'autre...' => 'autre',
                ),
                'required' => false,
                'multiple' => true,
                'expanded' => true,
            ))

            ->add('chants', ChoiceButtonType::class, array(
                'label' => 'user.chants.liste',
                'choices' => array(
                    'choeur' => 'choeur',
                    'lead' => 'lead',
                    
                ),
                'required' => false,
                'multiple' => true,
                'expanded' => true,
            ))
            //->add('formations')
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event){
            $entity = $event->getData(); // Entité envoyée au formulaire
            $form = $event->getForm(); // Récupère le formulaire

            if (!is_null($entity->getImage())) { // S'il y a une image dans mon artiste
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
            'data_class' => User::class,
        ]);
    }
}
