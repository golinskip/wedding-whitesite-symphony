<?php

namespace App\Controller\PrivateSite;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Translation\TranslatorInterface;
use App\Entity\Gift;
use App\Form\Confirmator\ConfirmatorForm;
use App\Services\ConfigService;
use App\Services\Recorder;


class GiftListController extends AbstractController
{
    /**
     * @Route("/gifts", name="private_gift_list")
     */
    public function index(Request $request)
    {
        $config = $this->get('config')->getObject();
        if(!$config->gift_enabled) {
            throw $this->createNotFoundException();
        }

        $em = $this->getDoctrine()->getManager();
        $gifts = $this->getDoctrine()
            ->getRepository(Gift::class)
            ->findEnabled();

        return $this->render('private_site/gift_list/index.html.twig', [
            'gifts' => $gifts,
        ]);
    }

    /**
     * @Route("/gift/{giftId}", requirements={"giftId"="\d+"}, name="private_gift")
     */
    public function single(Request $request, $giftId)
    {
        $config = $this->get('config')->getObject();
        if(!$config->gift_enabled) {
            throw $this->createNotFoundException();
        }

        $em = $this->getDoctrine()->getManager();
        $gift = $this->getDoctrine()
            ->getRepository(Gift::class)
            ->find($giftId);

        if($gift == null || !$gift->getIsEnabled()) {
            throw $this->createNotFoundException();
        }

        return $this->render('private_site/gift_list/single.html.twig', [
            'gift' => $gift,
        ]);
    }

    /**
     * Undocumented function
     *
     * 
     * @Route("/gifts/reserve/{giftId}", requirements={"giftId"="\d+"},  name="private_gift_reserve")
     */
    public function reserve(Request $request, TranslatorInterface $translator, $giftId) {
        $config = $this->get('config')->getObject();
        if(!$config->gift_enabled) {
            throw $this->createNotFoundException();
        }

        $referer = $request->headers->get('referer');
        $Invitation = $this->getUser();

        $em = $this->getDoctrine()->getManager();
        $gift = $this->getDoctrine()
            ->getRepository(Gift::class)
            ->find($giftId);

        if($gift == null || !$gift->getIsEnabled()) {
            $this->addFlash('danger',
                $translator->trans('gift_list.messages.not_found')
            );
            return new RedirectResponse($referer);
        }

        if($gift->getInvitation() !== null) {
            if($gift->getInvitation() === $Invitation) {
                $this->addFlash('warning',
                    $translator->trans('gift_list.messages.is_yours')
                );
            } else {
                $this->addFlash('warning',
                    $translator->trans('gift_list.messages.is_reserved', [
                        '[name]' => $gift->getName(),
                    ])
                );
            }
            return new RedirectResponse($referer);
        }

        if(!$config->gift_multiple_choice) {
            $chosenGifts = $Invitation->getGifts();
            foreach($chosenGifts as $chosenGift) {
                $chosenGift->setInvitation(null);
            }
        }

        $gift->setInvitation($Invitation);
        $em->flush();

        $this->addFlash('success',
            $translator->trans('gift_list.messages.chosen', [
                '[name]' => $gift->getName(),
            ])
        );
        $this->get('app.recorder')
            ->start('gift.link')
                ->record('gift.name', $gift->getName())
            ->commit();

        return new RedirectResponse($referer);
    }


    /**
     * Undocumented function
     *
     * 
     * @Route("/gifts/unreserve/{giftId}",  name="private_gift_unreserve")
     */
    public function unreserve(Request $request, TranslatorInterface $translator, $giftId) {
        $config = $this->get('config')->getObject();
        if(!$config->gift_enabled) {
            throw $this->createNotFoundException();
        }

        $referer = $request->headers->get('referer');
        $Invitation = $this->getUser();

        $em = $this->getDoctrine()->getManager();
        $gift = $this->getDoctrine()
            ->getRepository(Gift::class)
            ->find($giftId);

        if($gift == null || !$gift->getIsEnabled()) {
            $this->addFlash('danger',
                $translator->trans('gift_list.messages.not_found')
            );
            return new RedirectResponse($referer);
        }

        if($gift->getInvitation() === null || $gift->getInvitation() !== $Invitation) {
            $this->addFlash('warning',
                $translator->trans('gift_list.messages.can_not_unchose')
            );
            return new RedirectResponse($referer);
        }

        $gift->setInvitation(null);
        $em->flush();

        $this->addFlash('warning',
            $translator->trans('gift_list.messages.unchosen', [
                '[name]' => $gift->getName(),
            ])
        );

        $this->get('app.recorder')
        ->start('gift.unlink')
            ->record('gift.name', $gift->getName())
        ->commit();
        return new RedirectResponse($referer);
    }


    public static function getSubscribedServices()
    {
        return array_merge(parent::getSubscribedServices(), [
            'config' => ConfigService::class,
            'app.recorder' => Recorder::class,
        ]);
    }
}
