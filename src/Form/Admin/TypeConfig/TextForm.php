<?php
namespace App\Form\Admin\TypeConfig;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Model\ParameterType\Text;

class TextForm extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $inputTypes = [];
        foreach(Text::$inputTypeList as $inputType) {
            $inputTypes[$inputType] = $inputType;
        }
    
        $builder
            ->add('nullable', CheckboxType::class, [
                'required' => false,
            ])
            ->add('inputType', ChoiceType::class, [
                'choices' => $inputTypes,
            ])
            ->add('maxLength', NumberType::class, [
                'required' => false,
            ])
            ;
    }
    
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Text::class,
        ]);
    }
}