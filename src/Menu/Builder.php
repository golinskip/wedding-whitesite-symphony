<?php 
 
namespace App\Menu; 
 
use Knp\Menu\FactoryInterface; 
use Symfony\Component\HttpFoundation\RequestStack; 
use Doctrine\ORM\EntityManager;
use App\Entity\Page;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
 
class Builder 
{ 
    private $factory; 

    protected $em;

    protected $router;

    /** 
     * @param FactoryInterface $factory 
     */ 
    public function __construct(FactoryInterface $factory, EntityManager $em, UrlGeneratorInterface  $router) 
    { 
        $this->factory = $factory; 
        $this->em = $em;
        $this->router = $router;
    }

    public function PublicMenu(RequestStack $requestStack) 
    {
        $menu = $this->factory->createItem('root');

        $Pages = $this->em->getRepository(Page::class)->findPublicEnabled();
        foreach($Pages as $Page) {
            $currentRoute = $this->router->generate("public_page", [
                'slug' => $Page->getUrlName(),
            ]);
            if($Page->getIsInMenu()) {
                $menu->addChild($Page->getTitle(), [
                    'uri' => $currentRoute,
                ]);
            }
            foreach($Page->getPageBlocks() as $PageBlock) {
                if($PageBlock->getIsInMenu() && $PageBlock->getShowable()) {
                    $menu->addChild($PageBlock->getTitle(), [
                        'uri' => $currentRoute.'#'.$PageBlock->getUrlName(),
                    ]);
                }
            }
        }

        $this->bootstrapify($menu);
 
        return $menu; 
    } 
 
    public function PrivateMenu(RequestStack $requestStack) 
    { 
        $menu = $this->factory->createItem('root'); 
        
        $menu->addChild('Confirmator', [
            'route' => 'private_confirmator',
        ]);

        $Pages = $this->em->getRepository(Page::class)->findPrivateEnabled();
        foreach($Pages as $Page) {
            $currentRoute = $this->router->generate("private_page", [
                'slug' => $Page->getUrlName(),
            ]);
            if($Page->getIsInMenu()) {
                $menu->addChild($Page->getTitle(), [
                    'uri' => $currentRoute,
                ]);
            }
            foreach($Page->getPageBlocks() as $PageBlock) {
                if($PageBlock->getIsInMenu() && $PageBlock->getShowable()) {
                    $menu->addChild($PageBlock->getTitle(), [
                        'uri' => $currentRoute.'#'.$PageBlock->getUrlName(),
                    ]);
                }
            }
        }

		$menu->addChild('Logout', [
            'route' => 'app_logout',
        ]);

        $this->bootstrapify($menu);
 
        return $menu; 
    } 


    protected function bootstrapify(&$menu) {
        foreach ($menu as $child) {
            $child->setLinkAttribute('class', 'nav-link')
                ->setAttribute('class', 'nav-item');
        }
        $menu->setChildrenAttribute('class', 'navbar-nav mr-auto');
    }
}