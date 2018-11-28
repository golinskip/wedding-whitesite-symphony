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

    protected $datagridValues = [
        '_sort_order' => 'ASC',
        '_sort_by' => 'position',
    ];

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title', TextType::class)
            /*->add('parent', EntityType::class, [
                'class' => Page::class,
                'choice_label' => 'title',
                'required' => false,
            ])*/
            ->add('is_enabled', CheckboxType::class, [
                'required' => false,
            ])
            ->add('is_public', CheckboxType::class, [
                'required' => false,
            ])
            ->add('is_in_menu', CheckboxType::class, [
                'required' => false,
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
            ->add('is_root', CheckboxType::class, [
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
            ->addIdentifier('titleExt')
            ->add('is_enabled', null, [
                'editable' => true
            ])
            ->add('is_in_menu', null, [
                'editable' => true
            ])
            ->add('is_public', null)
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

    protected function configureSideMenu(MenuItemInterface $menu, $action, AdminInterface $childAdmin = null)
    {
        if (!$childAdmin && !in_array($action, ['edit', 'show'])) {
            return;
        }

        $admin = $this->isChild() ? $this->getParent() : $this;
        $id = $admin->getRequest()->get('id');

        if ($this->isGranted('LIST')) {
            $menu->addChild('Manage Blocks', [
                'uri' => $admin->generateUrl('admin.page_block.list', ['id' => $id])
            ]);
        }

        if ($this->isGranted('EDIT')) {
            $menu->addChild('Configure Page', [
                'uri' => $admin->generateUrl('edit', ['id' => $id])
            ]);
        }
    }
}
