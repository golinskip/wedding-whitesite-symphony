<?php

namespace App\BlockManager\Blocks\NewsBlock;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use App\BlockManager\Blocks\NewsBlock\NewsBlock;

class NewsBlockForm extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('layout', ChoiceType::class, [
                'choices' => [
                    'First big, other small'    => NewsBlock::LAYOUT_FIRST_BIG,
                    'Two columns'               => NewsBlock::LAYOUT_TWO_COLUMNS,
                    'All big'                   => NewsBlock::LAYOUT_ALL_BIG,
                ]
            ])
            ->add('limit', NumberType::class)
            ->add('text_read_more', TextType::class)
            ->add('text_more_news', TextType::class)
            ->add('text_no_news', TextType::class)
            ->add('show_more_news', CheckboxType::class, [
                'required' => false,
            ])
            ->add('show_date', CheckboxType::class, [
                'required' => false,
            ])
            ->add('show_author', CheckboxType::class, [
                'required' => false,
            ])
            ;
    }
    
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => NewsBlock::class,
        ]);
    }
}
