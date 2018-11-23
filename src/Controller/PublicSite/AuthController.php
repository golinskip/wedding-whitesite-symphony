<?php

namespace App\Controller\PublicSite;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        return $this->render('public_site/login/index.html.twig', [
            'error' => $error,
        ]);
    }
    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(AuthenticationUtils $authenticationUtils): Response {}
}
