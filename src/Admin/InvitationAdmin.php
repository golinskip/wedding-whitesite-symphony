<?php
namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Sonata\AdminBundle\Show\ShowMapper;
use App\Entity\Invitation;
use App\Form\Admin\PersonInInvitationForm;
use App\Entity\InvitationGroup;
use App\Entity\PersonGroup;

class InvitationAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
        ->with('People', ['class' => 'col-md-7'])
            ->add('people', CollectionType::class, [
                    'label' => false,
                    'entry_type'    => PersonInInvitationForm::class,
                    'entry_options'  => array(
                        'label' => false,
                    ),
                    'allow_add'    => true,
                    'allow_delete' => true,
                    'prototype'    => true,
                    'required'     => false,
            ])
        ->end()
        ->with('Invitation', ['class' => 'col-md-5'])
            ->add('name', TextType::class)
            ->add('invitationGroup', EntityType::class, [
                'class' => InvitationGroup::class,
                'choice_label' => 'name',
                'required' => false,
            ])
            ->add('phone', TextType::class, [
                'required' => false,
            ])
            ->add('email', TextType::class, [
                'required' => false,
            ])
            ->end()
            ;

    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('invitationGroup', null, [], EntityType::class, [
                'class'    => InvitationGroup::class,
                'choice_label' => 'name',
            ])
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name', null, ['route'=>['name'=>'show']])
            ->add('status', null, ['template' => 'admin/invitation/fields/table_status.html.twig'])
            ->add('code', null, ['template' => 'admin/invitation/fields/table_code.html.twig'])
            ->add('invitationGroup.name')
            ->add('_action', null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ]
            ])
            ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
			->add('name')
            ->add('status', null, ['template' => 'admin/invitation/fields/show_status.html.twig'])
			->add('invitationGroup.name')
            ->add('code', null, ['template' => 'admin/invitation/fields/show_code.html.twig'])
			->add('phone')
			->add('email')
            ->add('people', null, ['template' => 'admin/invitation/fields/show_people.html.twig'])
			;
	}

    public function prePersist($Invitation) {
        
        foreach($Invitation->getPeople() as $Person) {
            $Person->setInvitation($Invitation);
        }
    }

    public function preUpdate($Invitation) {
        foreach($Invitation->getPeople() as $Person) {
            $Person->setInvitation($Invitation);
        }
    }
}
