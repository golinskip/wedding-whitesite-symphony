<?php

namespace App\Controller\AdminControllers\Import;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Translation\TranslatorInterface;
use PhpOffice\PhpSpreadsheet\IOFactory as Excel;
use App\Services\ConfigService;
use App\Model\ImportFile;
use App\Form\Admin\ImportForm;
use App\Entity\Gift;
use App\Application\Sonata\MediaBundle\Entity\Media;
use Sonata\MediaBundle\Entity\MediaManager;
use Sonata\MediaBundle\Model\MediaManagerInterface;

class GiftsController extends AbstractController
{
    /**
     * @Route("/import/gifts", name="import_gifts")
     */
    public function importInvitationsAction(Request $request, TranslatorInterface $translator) {
        $referer = $request->headers->get('referer');
        $importFile = new ImportFile();
        $form = $this->createForm(ImportForm::class, $importFile, ['action' => $this->generateUrl('import_gifts')]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $importFile->getFile();

            $fileName = $importFile->generateUniqueFileName();

            // Move the file to the directory where brochures are stored
            try {
                $file->move(
                    $this->getParameter('import_directory'),
                    $fileName
                );
            } catch (FileException $e) {
                $this->addFlash('danger', $translator->trans('import.msg.fail_upload', [], 'admin'));
                return new RedirectResponse($referer);
            }

            $em = $this->getDoctrine()->getManager();
            
            
            $reader = Excel::createReaderForFile($this->getParameter('import_directory').DIRECTORY_SEPARATOR.$fileName);
            $reader->setReadDataOnly(true);
            $worksheet = $reader->load($this->getParameter('import_directory').DIRECTORY_SEPARATOR.$fileName);
            $activeSheet = $worksheet->getActiveSheet();
            $first = true;
            $Invitation = $PersonGroup = $InvitationGroup = $Person = null;
            foreach ($activeSheet->getRowIterator() as $row) {
                if($first) {
                    $first = false;
                    continue;
                }
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(FALSE);
                $gift = new Gift;
                foreach ($cellIterator as $key => $cell) {
                    $cellValue = $cell->getValue();
                    switch($key) {
                        case 'A':
                            if($cellValue !== null) {
                                $gift->setName($cellValue);
                            }
                            break;
                        case 'B':
                            if($cellValue !== null) {
                                $gift->setShortDescription($cellValue);
                            }
                            break;
                        case 'C':
                            if($cellValue !== null) {
                                $gift->setDescription($cellValue);
                            }
                            break;
                        case 'D':
                            if($cellValue !== null) {
                                $gift->setLink($cellValue);
                            }
                            break;
                    }
                }
                $gift->setIsEnabled(true);
                $em->persist($gift);
            }
            $em->flush();
        }
        $this->addFlash('success', $translator->trans('import.msg.success_invitation', [], 'admin'));
        return new RedirectResponse($referer);
    }

    public static function getSubscribedServices()
    {
        return array_merge(parent::getSubscribedServices(), [
            'app.config' => ConfigService::class,
        ]);
    }
}