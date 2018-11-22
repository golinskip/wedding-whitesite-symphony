<?php
namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Sonata\CoreBundle\Form\Type\ColorType;
use App\Entity\Invitation;

class PersonGroupAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
        ->add('name', TextType::class)
        ->add('color', ColorType::class, [
            'required'=> false,
        ])
        ->add('price', NumberType::class, [
            'empty_data' => 0,
        ])
        ->add('custom_order', NumberType::class, [
            'empty_data' => 0,
        ])
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('color')
            ->add('price')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('color')
            ->add('price')
            ->add('draft')
        ;
    }
}
