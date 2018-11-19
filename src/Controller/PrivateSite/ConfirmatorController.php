<?php

namespace App\Controller\PrivateSite;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Invitation;
use App\Entity\Parameter;
use App\Entity\ParameterValue;
use App\Form\Confirmator\ConfirmatorForm;

class ConfirmatorController extends AbstractController
{
    /**
     * @Route("/confirmator", name="private_confirmator")
     */
    public function index(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $Invitation = $this->getUser();

        // Add not existed paramters
        $Parameters = $this->getDoctrine()
            ->getRepository(Parameter::class)
            ->findAll();
        foreach($Invitation->getPeople() as $Person) {
            $parameterIdList = [];
            foreach($Person->getParameterValues() as $ParameterValues) {
                $parameterIdList[] = $ParameterValues->getParameter()->getId();
            }
            foreach($Parameters as $Parameter) {
                if(in_array($Parameter->getId(), $parameterIdList)) {
                    continue;
                }
                $ParameterValue = new ParameterValue;
                $ParameterValue->setParameter($Parameter);
                $ParameterValue->setPerson($Person);
                $ParameterValue->setValue('');
                $Person->addParameterValue($ParameterValue);
            }
        }
        
        $form = $this->createForm(ConfirmatorForm::class, $Invitation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // @todo - Obsługa
            $Invitation = $form->getData();
            //$Invitation->updateStatus();
            
            $em->persist($Invitation);
            $em->flush();
            
            return $this->redirectToRoute('private_confirmator');
        }

        return $this->render('private_site/confirmator/index.html.twig', [
            'controller_name' => 'ConfirmatorController',
            'form' => $form->createView(),
        ]);
    }
}
