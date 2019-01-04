<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Invitation;

class ContactDataForm extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('phone', TextType::class, [
                'label' => 'contact_data.phone',
                'attr' => [
                    'placeholder' => 'contact_data.phone',
                ],
                'required' => false,
            ])
            ->add('email', TextType::class, [
                'label' => 'contact_data.email',
                'attr' => [
                    'placeholder' => 'contact_data.email',
                ],
                'required' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'contact_data.submit'
            ])
            ;
    }
    
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Invitation::class,
        ]);
    }
}