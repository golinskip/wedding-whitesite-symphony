<?php

namespace App\Controller\PrivateSite;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\HttpNotFoundException;
use App\BlockManager\Services\BlockService;
use App\BlockManager\Base\BlockModelInterface;
use App\Entity\Page;

class DashboardController extends AbstractController
{
    /**
     * @Route("/", name="private_index")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $homePage = $this->getDoctrine()
            ->getRepository(Page::class)
            ->findPrivateRoot();
        if($homePage === null) {
            throw new HttpNotFoundException('Home site not found');
        }

        $BlockService = $this->container->get('block.service');
        $BlockService->setAttr('env', 'private');
        $BlockProvider = $BlockService->getBlockProvider();

        foreach($homePage->getPageBlocks() as $pageBlock) {
            if($pageBlock->getShowable()) {
                $blockObj = $pageBlock->getConfig();
                if($blockObj instanceof BlockModelInterface) {
                    $BlockProvider->pushBlock($pageBlock->getType(), $blockObj);
                }
            }
        }

        $invitation = $this->getUser();

        return $this->render('private_site/dashboard/index.html.twig', [
            'page' => $homePage,
            'blockProvider' => $BlockProvider,
            'invitation' => $invitation,
        ]);
    }

    public static function getSubscribedServices()
    {
        return array_merge(parent::getSubscribedServices(), [
            'block.service' => BlockService::class,
        ]);
    }
}
