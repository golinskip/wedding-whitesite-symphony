<?php
namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Knp\Menu\ItemInterface as MenuItemInterface;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Sonata\CoreBundle\Form\Type\DateTimePickerType;
use App\Entity\Page;


class PageAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title', TextType::class)
            ->add('site', ChoiceType::class, [
                'choices'  => [
                    Page::SITE_PUBLIC, Page::SITE_PRIVATE,
                ],
            ])
            ->add('start_publish_at', DateTimePickerType::class, [
                'dp_side_by_side' => true,
                'dp_language'=>'pl',
                'format'=>'yyyy-MM-dd HH:mm:ss',
                'required' => false,
            ])
            ->add('stop_publish_at', DateTimePickerType::class, [
                'dp_side_by_side' => true,
                'dp_language'=>'pl',
                'format'=>'yyyy-MM-dd HH:mm:ss',
                'required' => false,
            ])
            ->add('position', NumberType::class)
            ->add('parent', EntityType::class, [
                'class' => Page::class,
                'choice_label' => 'title',
                'required' => false,
            ])
            ->add('is_enabled', CheckboxType::class, [
                'required' => false,
            ])
        ;

    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
            ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->add('_action', null, [
                'actions' => [
                    'edit' => [],
                    'delete' => [],
                ]
            ])
            ;
    }

    protected function configureSideMenu(MenuItemInterface $menu, $action, AdminInterface $childAdmin = null)
    {
        if (!$childAdmin && !in_array($action, ['edit', 'show'])) {
            return;
        }

        $admin = $this->isChild() ? $this->getParent() : $this;
        $id = $admin->getRequest()->get('id');

        if ($this->isGranted('EDIT')) {
            $menu->addChild('Edit Page', [
                'uri' => $admin->generateUrl('edit', ['id' => $id])
            ]);
        }

        if ($this->isGranted('LIST')) {
            $menu->addChild('Manage Blocks', [
                'uri' => $admin->generateUrl('admin.page_block.list', ['id' => $id])
            ]);
        }
    }
}
