<?php

namespace App\BlockManager\Blocks\LoginForm;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\BlockManager\Blocks\LoginForm\LoginForm;

class LoginFormForm extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('button_text', TextType::class)
            ;
    }
    
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => LoginForm::class,
        ]);
    }
}
