<?php

namespace App\Controller\PrivateSite;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpNotFoundException;
use App\BlockManager\Services\BlockService;
use App\BlockManager\Base\BlockModelInterface;
use Symfony\Component\Translation\TranslatorInterface;
use App\Entity\Page;
use App\Services\ConfigService;

class DashboardController extends AbstractController
{
    /**
     * @Route("/", name="private_index")
     */
    public function index(Request $request, TranslatorInterface $translator)
    {
        $em = $this->getDoctrine()->getManager();
        $config = $this->get('config')->getObject();
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
        if($invitation->getEmail() === null && $invitation->getPhone() === null && $config->get_contact_data) {
            $msg =  $translator->trans('contact_data.update').' <a href="'.$this->generateUrl('private_contact_data').'">'.$translator->trans('contact_data.update_link').'</a>';
            $request->getSession()
                ->getFlashBag()
                ->add('warning', $msg)
            ;
        }

        return $this->render('private_site/dashboard/index.html.twig', [
            'page' => $homePage,
            'blockProvider' => $BlockProvider,
            'invitation' => $invitation,
        ]);
    }

    public static function getSubscribedServices()
    {
        return array_merge(parent::getSubscribedServices(), [
            'config' => ConfigService::class,
            'block.service' => BlockService::class,
        ]);
    }
}
