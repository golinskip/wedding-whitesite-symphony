<?php
namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Form\Admin\PersonInInvitationForm;
use App\Entity\Parameter;

class ParameterAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $paramFormList = [];
        foreach(Parameter::$typeList as $paramName => $class) {
            $paramFormList[$paramName] = $paramName;
        }

        $formMapper
        ->add('name', TextType::class)
        ->add('description', TextType::class, [
            'required' => false,
        ])
        ->add('visible', CheckboxType::class, [
            'required' => false,
        ])
        ->add('all_person', CheckboxType::class, [
            'required' => false,
        ])
        ;

        $parameter = $this->getSubject();

        if (!$parameter || null === $parameter->getId()) {
            $formMapper->add('type', ChoiceType::class, [
                'choices'  => $paramFormList,
            ]);
        } else {
            $formMapper->add('type', ChoiceType::class, [
                'choices'  => $paramFormList,
                'disabled' => true,
            ]);
            $type = $parameter->getType();
            $formClass = "App\\Form\\Admin\\TypeConfig\\".substr(strrchr(Parameter::$typeList[$type], "\\"), 1)."Form";
            $formMapper->add('config', $formClass, [
                'label' => false,
            ]);
        }


    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('type')
        ;
    }

    public function prePersist($Invitation) {}

    public function preUpdate($Invitation) {}
}
