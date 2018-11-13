<?php
namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Form\Admin\PersonInInvitationForm;
use App\Entity\Invitation;
use App\Entity\InvitationGroup;
use App\Entity\PersonGroup;

class ParameterAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', TextType::class)
            ->add('personGroup', EntityType::class, [
                'class' => PersonGroup::class,
                'choice_label' => 'name',
                'required' => false,
            ])
            ->add('invitation', EntityType::class, [
                'class' => Invitation::class,
                'choice_label' => 'name',
                'required' => true,
            ])
            ->add('editable', CheckboxType::class, [
                'required' => false,
            ])
            ;

    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('personGroup', null, [], EntityType::class, [
                'class'    => PersonGroup::class,
                'multiple' => true,
                'choice_label' => 'name',
            ])
            ->add('invitation.invitationGroup', null, [], EntityType::class, [
                'class'    => InvitationGroup::class,
                'multiple' => true,
                'choice_label' => 'name',
            ])
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('name');
    }

    public function prePersist($Invitation) {}

    public function preUpdate($Invitation) {}
}
