<?php

namespace App\BlockManager\Blocks\LoginForm;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\BlockManager\Blocks\LoginForm\LoginForm;

class LoginFormForm extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('title_text', TextType::class, [
                'required' => false,
            ])
            ->add('placeholder', TextType::class, [
                'required' => false,
            ])
            ->add('button_text', TextType::class, [
                'required' => false,
            ])
            ->add('help_text', TextType::class, [
                'required' => false,
            ])
            ->add('width', ChoiceType::class, [
                'choices' => [
                    '100%' => '100%',
                    '80%' => '80%',
                    '60%' => '60%',
                    '50%' => '50%',
                    '40%' => '40%',
                ]
            ])
            ->add('style', ChoiceType::class, [
                'choices' => [
                    'inline' => LoginForm::STYLE_LINE,
                    'two blocks' => LoginForm::STYLE_TWO_BLOCKS,
                ]
            ])
            ;
    }
    
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => LoginForm::class,
        ]);
    }
}
