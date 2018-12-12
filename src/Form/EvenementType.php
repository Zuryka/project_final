<?php

namespace App\Form;

use App\Entity\Evenement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nom', Type\TextType::class, array(
            'label' => 'evenement.nom',
            'required' => true,
        ))

        // ->add('styles', Type\ChoiceType::class, array(
        //     'label' => 'evenement.styles',
        //     'choices' => array(
        //         'Rock' => 'evenement.styles.rock',
        //         'Pop' => 'evenement.styles.pop',
        //         'Indie' => 'evenement.styles.indie',
        //         'Classique' => 'evenement.styles.classique',
        //     ),
        //     'required' => true,
        // ))

        ->add('presentation', Type\TextType::class, array(
            'label' => 'evenement.presentation',
            'required' => true,
        ))

        ->add('adresse', Type\TextType::class, array(
            'label' => 'evenement.adresse',
            'required' => true,
        ))
        
        ->add('code_postal', Type\IntegerType::class, array(
            'label' => 'evenement.code_postal',
            'required' => true,
        ))
            ->add('ville', Type\TextType::class, array(
                'label' => 'evenement.ville',
                'required' => true,
            ))
            ->add('latitude', Type\NumberType::class, array(
                'label' => 'evenement.latitude',
                'required' => false,
                'scale' => 5
            ))
            ->add('longitude', Type\NumberType::class, array(
                'label' => 'evenement.longitude',
                'required' => false,
                'scale' => 5
            ))
            ->add('numTelephone', Type\IntegerType::class, array(
                'label' => 'evenement.numTelephone',
                'required' => false,
            ))
            ->add('tarif', Type\NumberType::class, array(
                'label' => 'evenement.tarif',
                'required' => true,
                'scale' => 2
            ))
            ->add('date', Type\DateType::class, array(
                'label' => 'evenement.date',
                'placeholder' => array(
                    'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
                ),
                'required' => true,
            ))
            ->add('heureDebut', Type\TimeType::class, array(
                'label' => 'evenement.heureDebut',
                'required' => true,
            ))
            ->add('heureFin', Type\TimeType::class, array(
                'label' => 'evenement.heureFin',
                'required' => true,
            ))
            ->add('type', Type\TextType::class, array(
                'label' => 'evenement.type',
                'required' => true,
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
