<?php

namespace App\Controller\PublicSite;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpKernel\Exception\HttpNotFoundException;
use App\Form\PublicSite\LoginForm;
use App\BlockManager\Services\BlockService;
use App\Entity\Page;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="public_index")
     */
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        $em = $this->getDoctrine()->getManager();
        $homePage = $this->getDoctrine()
            ->getRepository(Page::class)
            ->findPublicRoot();
        if($homePage === null) {
            throw new HttpNotFoundException('Home site not found');
        }

        $blockProvider = $homePage->createBlockProvider();

        return $this->render('public_site/index/index.html.twig', [
            'page' => $homePage,
            'blockProvider' => $blockProvider
        ]);
    }

    public static function getSubscribedServices()
    {
        return array_merge(parent::getSubscribedServices(), [
            'block.service' => BlockService::class,
        ]);
    }
}
