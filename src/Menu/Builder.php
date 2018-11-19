<?php 
 
namespace App\Menu; 
 
use Knp\Menu\FactoryInterface; 
use Symfony\Component\HttpFoundation\RequestStack; 
 
class Builder 
{ 
    private $factory; 
 
    /** 
     * @param FactoryInterface $factory 
     */ 
    public function __construct(FactoryInterface $factory) 
    { 
        $this->factory = $factory; 
    } 
 
    public function MyMenu(RequestStack $requestStack) 
    { 
        $menu = $this->factory->createItem('root'); 
        
        $menu->addChild('Confirmator', [
            'route' => 'private_confirmator',
        ]);

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