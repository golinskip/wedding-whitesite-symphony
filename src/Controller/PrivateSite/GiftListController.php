<?php

namespace App\Controller\PrivateSite;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Gift;
use App\Form\Confirmator\ConfirmatorForm;

class GiftListController extends AbstractController
{
    /**
     * @Route("/gifts", name="private_gift_list")
     */
    public function index(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $gifts = $this->getDoctrine()
            ->getRepository(Gift::class)
            ->findEnabled();

        return $this->render('private_site/gift_list/index.html.twig', [
            'gifts' => $gifts,
            //'form' => $form->createView(),
        ]);
    }
}
