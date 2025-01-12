<?php

// src/Controller/CustomViewCRUDController.php

namespace App\Controller\Admin;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Translation\TranslatorInterface;
use App\Services\ConfigService;
use App\Model\ImportFile;
use App\Form\Admin\ImportForm;

class ImportExportController extends CRUDController
{
    public function listAction()
    {
        $importInvitation = new ImportFile();
        $importInvitationsForm = $this->createForm(ImportForm::class, $importInvitation, [
            'action' => $this->generateUrl('import_invitations'),
        ]);

        return $this->renderWithExtraParams('admin/import_export/index.html.twig', [
            'importInvitationsForm' => $importInvitationsForm->createView(),
        ]);
    }

    public static function getSubscribedServices()
    {
        return array_merge(parent::getSubscribedServices(), [
            'app.config' => ConfigService::class,
        ]);
    }
}