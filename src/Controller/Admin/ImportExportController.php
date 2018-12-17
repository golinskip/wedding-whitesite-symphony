<?php

// src/Controller/CustomViewCRUDController.php

namespace App\Controller\Admin;

use Sonata\AdminBundle\Controller\CRUDController;
use App\Services\ConfigService;
use Symfony\Component\HttpFoundation\Request;

class ImportExportController extends CRUDController
{
    public function listAction()
    {
        
        return $this->renderWithExtraParams('admin/import_export/index.html.twig', [

        ]);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function importInvitationsAction() {

    }

    public static function getSubscribedServices()
    {
        return array_merge(parent::getSubscribedServices(), [
            'app.config' => ConfigService::class,
        ]);
    }
}