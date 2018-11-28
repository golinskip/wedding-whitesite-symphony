<?php

namespace App\Controller\PrivateSite;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\HttpNotFoundException;
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

        $blockProvider = $homePage->createBlockProvider();

        return $this->render('private_site/dashboard/index.html.twig', [
            'page' => $homePage,
            'blockProvider' => $blockProvider
        ]);
    }
}
