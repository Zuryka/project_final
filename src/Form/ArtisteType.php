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

            ->add('niveau', Type\ChoiceType::class, array(
                'label' => 'user.niveau',
                'choices'  => array(
                    'amateur' => 'user_amateur',
                    'semi-pro' => 'user_semi-pro',
                    'pro' => 'user_pro',
                ),
                'required' => false,
            ))

            ->add('styles', Type\ChoiceType::class, array(
                    'label' => 'user.styles.liste',
                    'choices' => array(
                        'Rock' => 'user.styles.rock',
                        'Pop' => 'user.styles.pop',
                        'Indie' => 'user.styles.indie',
                        'Classique' => 'user.styles.classique',
                        'autres' => 'user.styles.autres'
                    ),
                    'required' => false,
                    'multiple' => true,
                ))

            ->add('instruments', Type\ChoiceType::class, array(
                'label' => 'user.instruments.liste',
                'choices' => array(
                    'guitare' => 'user.instruments.guitare',
                    'violon' => 'user.instruments.violon',
                    'batterie' => 'user.instruments.batterie',
                    'contrebasse' => 'user.instruments.contrebasse',
                    'triangle' => 'user.instruments.triangle',
                    'autre' => 'user.instruments.autre',
                ),
                'required' => false,
                'multiple' => true,
            ))

            ->add('chants', Type\ChoiceType::class, array(
                'label' => 'user.chants.liste',
                'choices' => array(
                    'choeur' => 'user.chants.choeur',
                    'lead' => 'user.chants.lead',
                    
                ),
                'required' => false,
                'multiple' => true,
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
