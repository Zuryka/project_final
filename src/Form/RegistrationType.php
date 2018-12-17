<?php 

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type;

class RegistrationType extends AbstractType 
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', Type\ChoiceType::class, array(
                'label' => 'registration.type',
                'choices'  => array(
                    'artiste' => 'user_artiste',
                    'organisateur_evenement' => 'user_event',
                    'gerant_local' => 'user_local',
                ),
                'required' => true,
                'multiple' => true,
            ))
            ->add('nom', Type\TextType::class, array(
                'label' => 'registration.name',
                'required' => true,
            ))
            ->add('prenom', Type\TextType::class, array(
                'label' => 'registration.lastname',
                'required' => true,
            ))          
        ;
    }

    /**
     * Définit le formulaire parent
     */
    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }
}