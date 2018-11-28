<?php

namespace App\Controller\PrivateSite;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpKernel\Exception\HttpNotFoundException;
use App\BlockManager\Services\BlockService;
use App\Entity\Page;

class PageController extends AbstractController
{
    /**
     * @Route("/page/{slug}", name="private_page")
     */
    public function index($slug): Response
    {
        $em = $this->getDoctrine()->getManager();
        $Page = $this->getDoctrine()
            ->getRepository(Page::class)
            ->findOneBySlugAndPrivacy($slug, false);
        if($Page === null) {
            throw new HttpNotFoundException('Site not found');
        }

        $blockProvider = $Page->createBlockProvider();

        return $this->render('private_site/page/index.html.twig', [
            'page' => $Page,
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
