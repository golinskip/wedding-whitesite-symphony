<?php

namespace App\Controller\PublicSite;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Form\PublicSite\LoginForm;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="public_index")
     */
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        return $this->render('public_site/index.html.twig');
    }
}
