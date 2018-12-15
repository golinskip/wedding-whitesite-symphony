<?php
namespace App\Form\Confirmator;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Invitation;
use App\Entity\Person;

class ConfirmatorForm extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('parameterValues', CollectionType::class, [
                'label' => false,
                'entry_type'    => ConfirmatorParameterForm::class,
                'entry_options'  => array(
                    'label' => false,
                ),
                'required'     => false,
                'prototype'    => false,
            ])
            ->add('people', CollectionType::class, [
                'entry_type'    => ConfirmatorPersonForm::class,
                'entry_options'  => [
                    'label' => false,
                ],
                'prototype'    => false,
                'allow_add' => false,
                'allow_delete' => false,
                'required'     => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'confirmator.form.submit'
            ])
            ;
    }
    
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Invitation::class,
        ]);
    }
}