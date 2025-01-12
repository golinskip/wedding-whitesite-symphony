<?php
namespace App\Form\Admin\TypeConfig;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Model\ParameterType\EnumRecord;

class EnumRecordForm extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('name', TextType::class)
            ->add('priceModifier', NumberType::class, array(
                'required' => false,
            ))
            ->add('limit', NumberType::class, array(
                'required' => false,
            ))
            ->add('default', CheckboxType::class, array(
                'required' => false,
            ))
            ;
    }
    
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => EnumRecord::class,
        ]);
    }
}