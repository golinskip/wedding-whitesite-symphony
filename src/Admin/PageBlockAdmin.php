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
use App\BlockManager\Services\BlockManager;


class PageBlockAdmin extends AbstractAdmin
{
    /*
    * @var BlockManager
    */
    protected $blockManager;

    protected $datagridValues = [
        '_sort_order' => 'ASC',
        '_sort_by' => 'position',
    ];

    protected function configureFormFields(FormMapper $formMapper)
    {
        $blockList = $this->blockManager->getBlockList();
        $formMapper
            ->add('title', TextType::class)
            ->add('type', ChoiceType::class, [
                'choices'  => $blockList,
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
    * @param BlockManager $blockManager
    */
   public function __construct($code, $class, $baseControllerName, $blockListService, BlockManager $blockManager)
   {
       $this->blockManager = $blockManager;
       return parent::__construct($code, $class, $baseControllerName);
   }
}
