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

        $this->cleanUpParameterValues($Invitation);
        
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

    protected function cleanUpParameterValues($Invitation) {
        $em = $this->getDoctrine()->getEntityManager();

        // Parameters for people
        $ParametersForPerson = $this->getDoctrine()
            ->getRepository(Parameter::class)
            ->findForPerson();
        $paramValueList = [];
        foreach($Invitation->getPeople() as $Person) {
            foreach($Person->getParameterValues() as $ParameterValue) {
                $paramValueList[$Person->getId()] = $paramValueList[$Person->getId()] ?? [];
                $paramValueList[$Person->getId()][$ParameterValue->getParameter()->getId()] = $ParameterValue;
            }
            foreach($ParametersForPerson as $Parameter) {
                if(isset($paramValueList[$Person->getId()][$Parameter->getId()])) {
                    unset($paramValueList[$Person->getId()][$Parameter->getId()]);
                    continue;
                }
                $ParameterValue = new ParameterValue;
                $ParameterValue ->setParameter($Parameter)
                                ->setPerson($Person)
                                ->setValue('');
                $Person->addParameterValue($ParameterValue);
            }
        }

        // Remove unused values
        foreach($paramValueList as $personId => $ParamsList) {
            foreach($ParamsList as $ParameterValue) {
                $em->remove($ParameterValue);
            }
        }
        $em->flush();

        $paramValueList = [];
        // Parameters for invitation
        $ParametersForInvitation = $this->getDoctrine()
            ->getRepository(Parameter::class)
            ->findForInvitation();
        foreach($Invitation->getParameterValues() as $ParameterValue) {
            $paramValueList[$ParameterValue->getParameter()->getId()] = $ParameterValue;
        }
        foreach($ParametersForInvitation as $Parameter) {
            if(isset($paramValueList[$Parameter->getId()])) {
                unset($paramValueList[$Parameter->getId()]);
                continue;
            }
            $ParameterValue = new ParameterValue;
            $ParameterValue ->setParameter($Parameter)
                            ->setInvitation($Invitation)
                            ->setValue('');
            $Invitation->addParameterValue($ParameterValue);
        }

        // Remove unused values
        foreach($paramValueList as $ParameterValue) {
            $em->remove($ParameterValue);
        }
        $em->flush();
    }
}
