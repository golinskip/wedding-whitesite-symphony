<?php
namespace App\Form\Admin\TypeConfig;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Model\ParameterType\Logic;

class LogicForm extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $layoutList = [];
        foreach(Logic::$layoutList as $layout) {
            $layoutList[$layout] = $layout;
        }
        
        $builder
            ->add('default', ChoiceType::class, [
                'choices'  => [
                    Logic::VALUE_TRUE => Logic::VALUE_TRUE,
                    Logic::VALUE_FALSE => Logic::VALUE_FALSE,
                ]
            ])
            ->add('truePrice', NumberType::class)
            ->add('falsePrice', NumberType::class)
            ->add('layout', ChoiceType::class, [
                'choices' => $layoutList,
            ])
            ;
    }
    
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Logic::class,
        ]);
    }
}