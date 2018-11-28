<?php

namespace App\BlockManager\Blocks\GoogleMaps;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Sonata\CoreBundle\Form\Type\DateTimePickerType;
use Sonata\MediaBundle\Form\Type\MediaType;
use App\BlockManager\Blocks\GoogleMaps\GoogleMaps;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class GoogleMapsForm extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('code', TextareaType::class)
            ->add('description', CKEditorType::class)
            ->add('layout', ChoiceType::class, [
                'choices' => GoogleMaps::getLayouts(),
            ])
            ;
    }
    
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => GoogleMaps::class,
        ]);
    }
}