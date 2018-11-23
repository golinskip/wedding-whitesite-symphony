<?php

namespace App\EventListener;

use Doctrine\Common\EventSubscriber;
// for Doctrine < 2.4: use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Events;
use App\Entity\Page;

class PageDataGuard implements EventSubscriber
{

    public function getSubscribedEvents()
    {
        return array(
            Events::postPersist,
            Events::postUpdate,
        );
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->index($args);
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $this->index($args);
    }

    public function index(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        $entityManager = $args->getObjectManager();
        if ($entity instanceof Page) {
            $this->preventRoot($entity, $entityManager, false);
            $this->preventRoot($entity, $entityManager, true);
        }
    }

    protected function preventRoot($page, $entityManager, $isPublic) {
        
        $RootPagesRepository = $entityManager
            ->getRepository(Page::class)
        ;
        if($isPublic) {
            $RootPages = $RootPagesRepository->findPublicRoots();
        } else {
            $RootPages = $RootPagesRepository->findPrivateRoots();
        }
        
        switch(count($RootPages)) {
            case 1: return true;
            case 0:
                $page->setIsRoot(1, $isPublic);
                break;
            default:
                if($page->getIsRoot($isPublic)) {
                    foreach($RootPages as $RootPage) {
                        if($RootPage->getId() !== $page->getId()) {
                            $RootPage->setIsRoot(0, $isPublic);
                        }
                    }
                } else {
                    $newestRootPage = null;
                    foreach($RootPages as $RootPage) {
                        if($newestRootPage === null) {
                            $newestRootPage = $RootPage;
                        } elseif($newestRootPage->getUpdatedAt()->getTimestamp() < $RootPage->getUpdatedAt()->getTimestamp()) {
                            $newestRootPage->setIsRoot(0, $isPublic);
                            $newestRootPage = $RootPage;
                        } else {
                            $RootPage->setIsRoot(0, $isPublic);
                        }
                    }
                }
        }
        $entityManager->flush();
    }
}