<?php

namespace App\Controller\PrivateSite;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/", name="private_index")
     */
    public function index()
    {
        return $this->render('private_site/dashboard/index.html.twig', [
            'controller_name' => 'PrivateSite\IndexController',
        ]);
    }
}
