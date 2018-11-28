<?php

namespace App\BlockManager\Blocks\CounterHeader;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Sonata\CoreBundle\Form\Type\DateTimePickerType;
use Sonata\MediaBundle\Form\Type\MediaType;
use App\BlockManager\Blocks\CounterHeader\CounterHeader;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class CounterHeaderForm extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('title', TextType::class)
            ->add('description', CKEditorType::class)
            //->add('description', TextType::class)
            ->add('weddingDate', DateTimePickerType::class, [
                'dp_side_by_side' => true,
            ])
            ->add('isShowCounter', CheckboxType::class, [
                'required' => false,
            ])
            ;
    }
    
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => CounterHeader::class,
        ]);
    }
}