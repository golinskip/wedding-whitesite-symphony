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
use App\Entity\Invitation;
use App\Entity\InvitationGroup;
use App\Entity\Person;
use App\Entity\PersonGroup;

class InvitationsController extends AbstractController
{
    /**
     * @Route("/import/invitations", name="import_invitations")
     */
    public function importInvitationsAction(Request $request, TranslatorInterface $translator) {
        $referer = $request->headers->get('referer');
        $importFile = new ImportFile();
        $form = $this->createForm(ImportForm::class, $importFile, ['action' => $this->generateUrl('import_invitations')]);
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
            $PersonGroups = $this->getDoctrine()
                ->getRepository(PersonGroup::class)
                ->findAll();
            $InvitationGroups = $this->getDoctrine()
                ->getRepository(InvitationGroup::class)
                ->findAll();
            
            
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
                foreach ($cellIterator as $key => $cell) {
                    $cellValue = $cell->getValue();
                    switch($key) {
                        case 'A': // Invitation
                            if($cellValue !== null) {
                                $Invitation = new Invitation();
                                $Invitation->setName($cellValue);
                                $em->persist($Invitation);
                            }
                            break;
                        case 'B': // Person
                            $Person = new Person();
                            if($cellValue[0] == "?") {
                                $Person->setName(substr($cellValue, 1));
                                $Person->setEditable(true);
                            } else {
                                $Person->setName($cellValue);
                                $Person->setEditable(false);
                            }
                            $Person->setInvitation($Invitation);
                            $Invitation->addPerson($Person);
                            $em->persist($Person);
                            break;
                        case 'C': // Invitation Group
                            if($cellValue !== null) {
                                $InvitationGroup = null;
                                foreach($InvitationGroups as $CurInvitationGroup) {
                                    if($CurInvitationGroup->getName() == $cellValue ) {
                                        $InvitationGroup = $CurInvitationGroup;
                                        $Invitation->setInvitationGroup($CurInvitationGroup);
                                        break;
                                    }
                                }
                                if($InvitationGroup === null) {
                                    $InvitationGroup  = new InvitationGroup();
                                    $InvitationGroup->setName($cellValue);
                                    $InvitationGroup->addInvitation($Invitation);
                                    $Invitation->setInvitationGroup($InvitationGroup);
                                    $InvitationGroups[] = $InvitationGroup;
                                    $em->persist($InvitationGroup);
                                }
                            }
                            break;
                        case 'D': // Person Group
                            if($cellValue !== null) {
                                $PersonGroup = null;
                                foreach($PersonGroups as $CurPersonGroup) {
                                    if($CurPersonGroup->getName() == $cellValue ) {
                                        $PersonGroup = $CurPersonGroup;
                                        $Person->setPersonGroup($CurPersonGroup);
                                        break;
                                    }
                                }
                                if($PersonGroup === null) {
                                    $PersonGroup  = new PersonGroup();
                                    $PersonGroup->setName($cellValue);
                                    $PersonGroup->addPerson($Person);
                                    $Person->setPersonGroup($PersonGroup);
                                    $PersonGroups[] = $PersonGroup;
                                    $em->persist($PersonGroup);
                               }
                            }
                            break;
                        case 'E': // Code
                            if($cellValue !== null) {
                                $Invitation->setCode($cellValue);
                            }
                            break;
                    }
                }
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