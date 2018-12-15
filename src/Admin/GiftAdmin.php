<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Sonata\AdminBundle\Form\Type\ModelListType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Route\RouteCollection;

final class GiftAdmin extends AbstractAdmin
{
    protected $datagridValues = [
        '_sort_order' => 'ASC',
        '_sort_by' => 'position',
    ];

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
			->add('name')
			;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
			->add('name')
            ->add('is_enabled', null,[
                'editable' => true
            ])
			->add('reserved_at')
            ->add('created_at')
            ->add('_action', null, [
                'actions' => [
                    'edit' => [],
                    'delete' => [],
                    'move' => [
                        'template' => '@PixSortableBehavior/Default/_sort.html.twig'
                    ],
                ]
            ])
            ;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('move', $this->getRouterIdParameter().'/move/{position}');
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
			->add('name', TextType::class)
			->add('is_enabled', CheckboxType::class, [
                'required' => false,
            ])
			->add('short_description', TextareaType::class, [
                'required' => false,
            ])
			->add('description', CKEditorType::class, [
                'required' => false,
            ])
			->add('image', ModelListType::class, [
				'required' => false,
			])
			->add('link', TextType::class, [
                'required' => false,
            ])
			;
    }
}
