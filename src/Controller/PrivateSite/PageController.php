<?php

namespace App\Controller\PrivateSite;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpKernel\Exception\HttpNotFoundException;
use App\BlockManager\Services\BlockService;
use App\BlockManager\Base\BlockModelInterface;
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


        $BlockService = $this->container->get('block.service');
        $BlockService->setAttr('env', 'private');
        $BlockProvider = $BlockService->getBlockProvider();

        foreach($Page->getPageBlocks() as $pageBlock) {
            if($pageBlock->getShowable()) {
                $blockObj = $pageBlock->getConfig();
                if($blockObj instanceof BlockModelInterface) {
                    $BlockProvider->pushBlock($pageBlock->getType(), $blockObj);
                }
            }
        }

        return $this->render('private_site/page/index.html.twig', [
            'page' => $Page,
            'blockProvider' => $BlockProvider
        ]);
    }

    public static function getSubscribedServices()
    {
        return array_merge(parent::getSubscribedServices(), [
            'block.service' => BlockService::class,
        ]);
    }
}
