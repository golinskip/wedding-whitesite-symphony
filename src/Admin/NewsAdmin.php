<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Form\Type\DateTimePickerType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Sonata\AdminBundle\Form\Type\ModelListType;
use App\Entity\News;

final class NewsAdmin extends AbstractAdmin
{

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
            ->add('lead')
            ->add('content')
            ->add('is_enabled')
            ->add('visibility')
            ->add('start_publish_at')
            ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->add('lead')
            ->add('is_enabled', null,[
                'editable' => true
			])
            ->add('visibility')
            ->add('start_publish_at')
            ->add('author')
            ->add('_action', null, [
                'actions' => [
                    'edit' => [],
                    'delete' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
        ->with('Content', ['class' => 'col-md-7'])
            ->add('title', TextType::class)
            ->add('lead', TextareaType::class)
            ->add('content', CKEditorType::class)
            ->add('author', TextType::class, [
                'required' => false,
            ])
        ->end()
        ->with('Setup', ['class' => 'col-md-5'])
            ->add('is_enabled', CheckboxType::class, [
				'required' => false,
			])
            ->add('visibility', ChoiceType::class, [
                'choices' => [
                    'all' => News::VISIBILITY_ALL,
                    'private' => News::VISIBILITY_PRIVATE,
                    'public' => News::VISIBILITY_PUBLIC,
                ]
			])
			->add('image', ModelListType::class, [
				'required' => false,
			])
            ->add('start_publish_at', DateTimePickerType::class, [
				'data' => new \DateTime(),
            ])
            ->add('stop_publish_at', DateTimePickerType::class, [
                'required' => false,
            ])
        ->end()
            ;
    }
}
