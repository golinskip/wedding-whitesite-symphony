<?php

// src/Controller/CustomViewCRUDController.php

namespace App\Controller\Admin;

use Sonata\AdminBundle\Controller\CRUDController;
use App\Services\ConfigService;
use Symfony\Component\HttpFoundation\Request;

class ConfigController extends CRUDController
{
    public function listAction()
    {
        $configService = $this->container->get('app.config');
        $request = $this->getRequest();

        $object = $configService->getObject();

        $form = $configService->createForm($this->createFormBuilder($object));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $configObj = $form->getData();

            $configService->updateObject($configObj);

            return $this->redirectToRoute('config_list');
        }

        return $this->renderWithExtraParams('admin/setup/index.html.twig', [
            'form' => $form->createView(),
            'obj' => $object,
        ]);
    }

    public static function getSubscribedServices()
    {
        return array_merge(parent::getSubscribedServices(), [
            'app.config' => ConfigService::class,
        ]);
    }
}