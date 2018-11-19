<?php
namespace App\Form\Confirmator;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use App\Entity\ParameterValue;

class ConfirmatorParameterForm extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                $ParameterValue = $event->getData();
                $Parameter = $ParameterValue->getParameter();
                $form = $event->getForm();
                $ParameterTypeFieldClass = "App\\Form\\Confirmator\\ParameterType\\Type".ucfirst($Parameter->getType())."Form";
                $ParameterTypeField = new $ParameterTypeFieldClass;
                $ParameterType = $Parameter->getConfig();
                if($ParameterValue->getValue() === null) {
                    $ParameterValue->setValue($ParameterType->getDefault());
                }
                $ParameterTypeField->addField($form, $Parameter->getName(), $ParameterType);
            })
            ;
    }
    
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => ParameterValue::class,
        ]);
    }
}