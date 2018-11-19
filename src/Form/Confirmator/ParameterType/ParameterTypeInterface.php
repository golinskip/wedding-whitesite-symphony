<?php 
namespace App\Form\Confirmator\ParameterType;

interface ParameterTypeInterface {
    public function addField($form, $name, $TypeConfig);
}