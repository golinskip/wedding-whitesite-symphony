<?php

namespace App\Controller\AdminControllers\Export;

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

use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class InvitationsController extends AbstractController
{
    /**
     * @Route("/export/invitations", name="export_invitations")
     */
    public function exportAction(Request $request, TranslatorInterface $translator) {
        $spreadsheet = new Spreadsheet();
        
        /* @var $sheet \PhpOffice\PhpSpreadsheet\Writer\Xlsx\Worksheet */
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle($translator->trans('export.invitations.filetitle', [], 'admin'));
        $sheet->setCellValue('A1', $translator->trans('export.invitations.headers.A', [], 'admin'));
        $sheet->setCellValue('B1', $translator->trans('export.invitations.headers.B', [], 'admin'));
        $sheet->setCellValue('C1', $translator->trans('export.invitations.headers.C', [], 'admin'));
        $sheet->setCellValue('D1', $translator->trans('export.invitations.headers.D', [], 'admin'));
        $sheet->setCellValue('E1', $translator->trans('export.invitations.headers.E', [], 'admin'));


        $Invitations = $this->getDoctrine()
            ->getRepository(Invitation::class)
            ->findAll();
        $rowIterator = 2;
        foreach($Invitations as $Invitation) {
            $sheet->setCellValue('A'.$rowIterator, $Invitation->getName());
            $sheet->setCellValue('E'.$rowIterator, $Invitation->getCode());
            if($Invitation->getInvitationGroup()) {
                $sheet->setCellValue('C'.$rowIterator, $Invitation->getInvitationGroup()->getName());
            }
            foreach($Invitation->getPeople() as $Person) {
                $sheet->setCellValue('B'.$rowIterator, $Person->getName());
                if($Person->getPersonGroup()) {
                    $sheet->setCellValue('D'.$rowIterator, $Person->getPersonGroup()->getName());
                }
                $rowIterator++;
            }
            
        }
        
        // Create your Office 2007 Excel (XLSX Format)
        $writer = new Xlsx($spreadsheet);
        
        // Create a Temporary file in the system
        $fileName = $translator->trans('export.invitations.filename', [], 'admin').'.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        
        // Create the excel file in the tmp directory of the system
        $writer->save($temp_file);
        
        // Return the excel file as an attachment
        return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);
    }

    public static function getSubscribedServices()
    {
        return array_merge(parent::getSubscribedServices(), [
            'app.config' => ConfigService::class,
        ]);
    }
}