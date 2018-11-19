<?php

namespace App\Controller\PrivateSite;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ConfirmatorController extends AbstractController
{
    /**
     * @Route("/confirmator", name="private_confirmator")
     */
    public function index()
    {
        return $this->render('private_site/confirmator/index.html.twig', [
            'controller_name' => 'ConfirmatorController',
        ]);
    }
}
