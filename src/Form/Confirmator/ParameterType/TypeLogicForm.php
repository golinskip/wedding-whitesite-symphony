<?php
namespace App\Form\Confirmator\ParameterType;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Model\ParameterType\Logic as LogicModel;

class TypeLogicForm implements ParameterTypeInterface {

    public function addField($form, $name, $TypeConfig) {
        switch ($TypeConfig->getLayout()) {
            case LogicModel::LAYOUT_BUTTON:
                $this->buildChoice($form, $name, $TypeConfig, true);
                break;
            case LogicModel::LAYOUT_RADIOBUTTON:
                $this->buildChoice($form, $name, $TypeConfig, true);
                break;
            case LogicModel::LAYOUT_DROPDOWN:
                $this->buildChoice($form, $name, $TypeConfig, false);
                break;
        }
    }

    private function buildChoice($form, $name, $TypeConfig, $expanded) {
        $form->add('value', ChoiceType::class, [
            'label' => $name,
            'choices' => [
                'confirmator.yes' => LogicModel::VALUE_TRUE,
                'confirmator.no' => LogicModel::VALUE_FALSE,
            ],
            'multiple' => false,
            'expanded' => $expanded,
        ]);
    }

}
