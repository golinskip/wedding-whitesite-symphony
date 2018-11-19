<?php
namespace App\Form\Confirmator\ParameterType;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use InvitationBundle\Entity\ParameterType\Text as TextEntity;
use App\Model\ParameterType\Text as TextModel;

class TypeTextForm implements ParameterTypeInterface {
    public function addField($form, $name, $TypeConfig) {
        $TypeClass = ($TypeConfig->getInputType() == TextModel::INPUT_TYPE_TEXTAREA) ?  TextareaType::class : TextType::class;
        
        $form->add('value', $TypeClass, [
            'label' => $name,
        ]);
    }
}