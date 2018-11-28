<?php

namespace App\BlockManager\Blocks\TextBlock;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\BlockManager\Blocks\TextBlock\TextBlock;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class TextBlockForm extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('content', CKEditorType::class)
            ;
    }
    
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => TextBlock::class,
        ]);
    }
}