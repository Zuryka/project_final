<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArtisteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('usernameCanonical')
            ->add('email')
            ->add('emailCanonical')
            ->add('enabled')
            ->add('salt')
            ->add('password')
            ->add('lastLogin')
            ->add('confirmationToken')
            ->add('passwordRequestedAt')
            ->add('roles')
            ->add('nom')
            ->add('prenom')
            ->add('dateInscription')
            ->add('adresse')
            ->add('codePostal')
            ->add('ville')
            ->add('numTelephone')
            ->add('nomArtiste')
            ->add('presentation')
            ->add('niveau')
            ->add('styles')
            ->add('instruments')
            ->add('instrumentsComments')
            ->add('chants')
            ->add('chantsComments')
            ->add('formationsComments')
            ->add('type')
            ->add('evenements')
            ->add('formations')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
