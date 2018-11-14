<?php
namespace App\Form\Admin\TypeConfig;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Model\ParameterType\Number;

class NumberForm extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        
        $builder
            ->add('maxNum', NumberType::class, array(
                'required' => false,
            ))
            ->add('minNum', NumberType::class, array(
                'required' => false,
            ))
            ->add('decimals', NumberType::class, array(
                'required' => false,
            ))
            ->add('priceFactor', NumberType::class, array(
                'required' => false,
            ))
            ;
    }
    
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Number::class,
        ]);
    }
}