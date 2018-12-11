<?php

namespace App\Form;

use App\Entity\Evenement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('styles')
            ->add('presentation')
            ->add('adresse')
            ->add('codePostal')
            ->add('ville')
            ->add('latitude')
            ->add('longitude')
            ->add('numTelephone')
            ->add('tarif')
            ->add('date')
            ->add('heureDebut')
            ->add('heureFin')
            ->add('type')
            ->add('userCreateur')
            ->add('userContact')
            ->add('lieu')
            ->add('artistes')
            ->add('formations')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
