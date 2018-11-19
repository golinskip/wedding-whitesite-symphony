<?php
namespace App\Form\Confirmator\ParameterType;

use Symfony\Component\Form\Extension\Core\Type\TextType;

class TypeNumberForm implements ParameterTypeInterface {
    public function addField($form, $name, $TypeConfig) {
        $form->add('value', TextType::class, [
            'label' => $name,
        ]);
    }
}