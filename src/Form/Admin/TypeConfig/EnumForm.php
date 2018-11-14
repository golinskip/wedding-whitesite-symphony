<?php
namespace App\Form\Admin\TypeConfig;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
//use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Form\Type\CollectionType;
use App\Model\ParameterType\Enum;

class EnumForm extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $layoutList = [];
        foreach(Enum::$layoutList as $layout) {
            $layoutList[$layout] = $layout;
        }
        $builder
            ->add('showDisabled', CheckboxType::class, array(
                'required' => false,
            ))
            ->add('multichoice', CheckboxType::class, array(
                'required' => false,
            ))
            ->add('showLimits', CheckboxType::class, array(
                'required' => false,
            ))
            ->add('layout', ChoiceType::class, [
                'choices' => $layoutList,
            ])
           ->add('enumRecord', CollectionType::class, [

                'entry_type'    => EnumRecordForm::class,
                'entry_options'  => array( 'label' => false,    ),
                'allow_add'    => true,
                'allow_delete' => true,
                'prototype'    => true,
                'required'     => false,
           ])
            ;
    }
    
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Enum::class,
        ]);
    }
}