<?php

namespace App\Form;

use App\Entity\Lieu;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type;

class LieuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', Type\TextType::class, array(
                'label' => 'lieu.nom',
                'required' => true,
            ))

            ->add('type', Type\ChoiceType::class, array(
                'label' => 'lieu.type',
                'choices' => array(
                    'Bar' => 'lieu.type.bar',
                    'Maison de la Jeunesse et de la Culture' => 'lieu.type.mjc',
                    'Plein air' => 'lieu.type.plein_air',
                    'Salle des fêtes' => 'lieu.type.salle_des_fetes',
                ),
                'required' => true,
            ))

            ->add('presentation', Type\TextType::class, array(
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
            
            ->add('num_telephone', Type\IntegerType::class, array(
                'label' => 'lieu.num_telephone',
                'required' => false,
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Lieu::class,
        ]);
    }
}