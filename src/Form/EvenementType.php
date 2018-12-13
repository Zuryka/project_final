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

        ->add('styles', Type\ChoiceType::class, array(
            'label' => 'evenement.styles',
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

        ->add('presentation', Type\TextareaType::class, array(
            'label' => 'evenement.presentation',
            'required' => true,
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
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                ),
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
            ->add('type', Type\ChoiceType::class, array(
                'label' => 'evenement.type',
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
