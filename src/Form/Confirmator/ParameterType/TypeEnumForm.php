<?php
namespace App\Form\Confirmator\ParameterType;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Model\ParameterType\Enum as EnumModel;

class TypeEnumForm implements ParameterTypeInterface {
    public function addField($form, $name, $TypeConfig) {
        $choices = [];
        foreach($TypeConfig->getEnumRecord() as $EnumRecord) {
            $choices[$EnumRecord->getName()] = $EnumRecord->getName();
        }
        
        $expanded = ($TypeConfig->getLayout() == EnumModel::LAYOUT_DROPDOWN)?false:true;
        $multiple = $TypeConfig->getMultichoice();
        
        $form->add('value', ChoiceType::class, [
            'label' => $name,
            'choices' => $choices,
            'multiple' => $multiple,
            'expanded' => $expanded,
        ]);
    }
}