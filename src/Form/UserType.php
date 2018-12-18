<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type;
use App\Form\ChoiceButtonType;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', Type\TextType::class, array(
                'label' => 'user.username',
                'required' => false,
            ))
            ->add('email', Type\EmailType::class, [
                'label' => 'user.email'

            ])
            ->add('plainpassword', Type\PasswordType::class, array(
                'label' => 'user.password',
                'required' => false,
                
            ))   
            ->add('nom', Type\TextType::class, array(
                'label' => 'user.name',
                'required' => false,
            ))
            ->add('prenom', Type\TextType::class, array(
                'label' => 'user.userlastname',
                'required' => false,
            ))
            ->add('adresse', Type\TextType::class, array(
                'label' => 'user.adresse',
                'required' => false,
            ))
            ->add('codePostal', Type\NumberType::class, array(
                'label' => 'user.codepostal',
                'required' => false,
            ))
            ->add('ville', Type\TextType::class, array(
                'label' => 'user.ville',
                'required' => false,
            ))
            ->add('numTelephone', Type\TelType::class, array(
                'label' => 'user.numtelephone',
                'required' => false,
            ))
            ->add('niveau', Type\ChoiceType::class, array(
                'label' => 'user.niveau',
                'choices'  => array(
                    'Amateur' => 'user_amateur',
                    'Semi-pro' => 'user_semi-pro',
                    'Pro' => 'user_pro',
                ),
                'required' => true,
            ))
            ->add('type', ChoiceButtonType::class, array(
                'label' => 'registration.type',
                'choices'  => array(
                    'artiste' => 'user_artiste',
                    'organisateur_evenement' => 'user_event',
                    'gerant_local' => 'user_local',
                ),
                'required' => true,
                'multiple' => true,
                'expanded' => true,
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
