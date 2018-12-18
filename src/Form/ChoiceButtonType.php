<?php 

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChoiceButtonType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'label_attr' => array(
                'class' => 'checkbox-custom',
            ),
        ));
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}