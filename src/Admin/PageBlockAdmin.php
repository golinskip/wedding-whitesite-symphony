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
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Sonata\CoreBundle\Form\Type\DateTimePickerType;
use App\BlockManager\Services\BlockService;


class PageBlockAdmin extends AbstractAdmin
{
    /*
    * @var blockService
    */
    protected $blockService;

    protected $datagridValues = [
        '_sort_order' => 'ASC',
        '_sort_by' => 'position',
    ];

    protected function configureFormFields(FormMapper $formMapper)
    {
        $blockList = $this->blockService->getBlockList();
        
        $formMapper
            ->add('title', TextType::class)
        ;

        $pageBlock = $this->getSubject();
    
        if (!$pageBlock || null === $pageBlock->getId()) {
            $formMapper
                ->add('type', ChoiceType::class, [
                    'choices'  => $blockList,
                ])
            ;
        } else {
            $type = $pageBlock->getType();
            $formMapper
                ->add('type', ChoiceType::class, [
                    'choices'  => $blockList,
                    'disabled' => true,
                ])
                ->add('is_enabled')
            ;
            $blockService = $this->blockService->getManager($type);
            if($pageBlock->getConfig() === null) {
                $pageBlock->setConfig($blockService->createObject());
            }

            $formClass = $blockService->getFormClass();
            $formMapper->add('config', $formClass, [
                'label' => false,
            ]);
        }
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
            ->add('type')
            ->add('is_enabled', null, [
                'editable' => true
            ])
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
        if ($this->isChild()) {
            return;
        }
        $collection->clear();
    }
    
    /**
    * @param string $code
    * @param string $class
    * @param string $baseControllerName
    * @param BlockService $blockService
    */
   public function __construct($code, $class, $baseControllerName, BlockService $blockService)
   {
       $this->blockService = $blockService;
       return parent::__construct($code, $class, $baseControllerName);
   }
}
