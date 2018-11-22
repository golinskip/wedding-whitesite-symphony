<?php

namespace App\Controller\PublicSite;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Form\PublicSite\LoginForm;
use App\BlockManager\Services\BlockManager;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="public_index")
     */
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        $Blocks = $this->container->get('block.manager');
        $BlockList = $Blocks->getBlockList();
        return $this->render('public_site/index.html.twig');
    }

    public static function getSubscribedServices()
    {
        return array_merge(parent::getSubscribedServices(), [
            'block.manager' => BlockManager::class,
        ]);
    }
}
