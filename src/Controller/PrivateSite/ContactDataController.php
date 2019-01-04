<?php

namespace App\Controller\PrivateSite;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Translation\TranslatorInterface;
use App\Form\ContactDataForm;
use App\Services\Recorder;

class ContactDataController extends AbstractController {
    
    /**
     * @Route("/contact_data", name="private_contact_data")
     */
    public function indexAction(Request $request, TranslatorInterface $translator) {
        $em = $this->getDoctrine()->getManager();
        
        $Invitation = $this->getUser();
        
        $form = $this->createForm(ContactDataForm::class, $Invitation);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($Invitation);
            $em->flush();
            
            $Recorder = $this->get('app.recorder')->start('invitation.update')
                ->record('invitation.phone', $Invitation->getPhone())
                ->record('invitation.email', $Invitation->getEmail())
            ->commit();
            
            $request->getSession()
                ->getFlashBag()
                ->add('success', $translator->trans('contact_data.messages.success'))
            ;
        
            return $this->redirectToRoute('private_contact_data');
        }
        
        return $this->render('private_site/contact_data/index.html.twig', array(
            'Invitation' => $Invitation,
            'form' => $form->createView(),
        ));
    }

    public static function getSubscribedServices()
    {
        return array_merge(parent::getSubscribedServices(), [
            'app.recorder' => Recorder::class,
        ]);
    }

}
