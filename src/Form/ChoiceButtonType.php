<?php 

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChoiceButtonType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'label_attr' => array(
                'class' => 'radio-custom',
            ),
        ));
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        if( isset($options['multiple']) && isset($options['expanded']) && $options['expanded']){
            $view->vars['label_attr']['class'] .= ($options['multiple']? 'checkbox-custom' : 'radio-custom');
        }
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}