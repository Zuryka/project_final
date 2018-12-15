<?php

namespace App\Form;

use App\Entity\Lieu;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use App\Form\ImageType;


class LieuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ->add('photoIdent', MediaType::class, array(
            //     'label' => 'lieu.photo',
            //     'mapped' => false,
            // ))

            ->add('image', ImageType::class, array(
                'label' => 'lieu.photo',
            ))

            ->add('nom', Type\TextType::class, array(
                'label' => 'lieu.nom',
                'required' => true,
            ))

            ->add('type', Type\ChoiceType::class, array(
                'label' => 'lieu.type',
                'choices' => array(
                    'Bar' => 'Bar',
                    'Maison de la Jeunesse et de la Culture' => 'MJC',
                    'Plein air' => 'Plein air',
                    'Salle des fêtes' => 'Salle des fêtes',
                ),
                'required' => true,
            ))

            ->add('presentation', Type\TextareaType::class, array(
                'label' => 'lieu.presentation',
                'required' => true,
            ))

            ->add('adresse', Type\TextType::class, array(
                'label' => 'lieu.adresse',
                'required' => true,
            ))
            
            ->add('code_postal', Type\IntegerType::class, array(
                'label' => 'lieu.code_postal',
                'required' => true,
            ))
            
            ->add('ville', Type\TextType::class, array(
                'label' => 'lieu.ville',
                'required' => true,
            ))
            
            ->add('latitude', Type\NumberType::class, array(
                'label' => 'lieu.latitude',
                'required' => false,
                'scale' => 5
            ))
            
            ->add('longitude', Type\NumberType::class, array(
                'label' => 'lieu.longitude',
                'required' => false,
                'scale' => 5
            ))
            
            ->add('num_telephone', Type\TelType::class, array(
                'label' => 'lieu.num_telephone',
                'required' => false,
            ))
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event){
            $entity = $event->getData(); // Entité envoyée au formulaire
            $form = $event->getForm(); // Récupère le formulaire

            if (!is_null($entity->getImage())) { // S'il y a une image dans mon lieu
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
            'data_class' => Lieu::class,
        ]);
    }
}