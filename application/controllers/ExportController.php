<?php
defined('BASEPATH') or exit('No direct script access allowed');
include($_SERVER['DOCUMENT_ROOT'] . '/lapor-in/application/helpers/ChromePhp.php');

// Get PHPOffice from Vendor
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class ExportController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function export_pdf()
    {
        $pdf = new myTCPDF();

        // SET DOCUMENT INFORMATION
        $pdf->SetCreator('AHMAD-FADILAH');
        $pdf->SetAuthor('AHMAD-FADILAH');
        $pdf->SetTitle('LAPORAN');

        // // HEADER - LOGO | TITLE => [NOT_USED] Set on myTCPDF Parent Construct
        // $pdf->SetHeaderData('polban.png', 13, 'POLITEKNIK NEGERI BANDUNG', "LAPORAN \n LAYANAN UPTK - POLBAN");

        // SET HEADER AND FOOTER FONTS
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED); // set default monospaced font

        // SET DOCUMENT - MARGIN
        $pdf->SetMargins(15, 32, 15);
        $pdf->SetHeaderMargin(5);
        $pdf->SetFooterMargin(10);

        // SET DOCUMENT - OTHERS_1
        $pdf->SetAutoPageBreak(TRUE, 25); // set auto page breaks
        $pdf->setCellPaddings(1, 1, 1, 1); // set cell padding
        $pdf->setCellMargins(1, 1, 1, 1); // set cell margins
        $pdf->SetFillColor(255, 255, 127); // set color for background
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); // set image scale factor
        $pdf->SetFont('times', '', 10); // set font
        $pdf->AddPage('L', 'Letter'); // add a page

        // ---------------------------------------------------------

        // INFO
        $info = '
				<p>
					<strong>JENIS LAYANAN</strong> : ' . $_POST['jenisLayanan'] . '
				</p>
				<p>
					<strong>PADA</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : ' .  $_POST['padaWaktu'] . '
				</p>';

        // PRINT - INFO
        $pdf->writeHTMLCell(0, 0, '', '', $info, 0, 1, 0, true, 'L', true);

        // INIT TABLE
        $table = '
            <table cellspacing="2" cellpading="4">
				<tr color="#fff" bgcolor="#002080">';

        // TABLE - HEADER FIELDS
        $tableFields = $_POST['tableFields']['pdf'];
        foreach ($tableFields as $fn) {
            $table .= '
                    <td width="' . $fn['Width'] . '" align="center">' . $fn['Name'] . '</td>';
        }

        $table .= '
                </tr>';

        // TABLE - DATA
        $tableData = $_POST['tableData'];
        $table .= $tableData . '
			</table>';

        // PRINT - TABLE DATA
        $pdf->writeHTMLCell(0, 0, '', '', $table, 0, 1, 0, true, 'C', true);

        // SET DOCUMENT - OTHERS_2
        $pdf->lastPage(); // move pointer to last page

        // ---------------------------------------------------------

        // SAVE AND SHOW
        $saveDir = 'PDF_CACHES/';
        $fileName = 'report_' . Date('Y-m-d') . '.pdf';

        if (!is_dir(FCPATH . $saveDir))
            mkdir(FCPATH . $saveDir, 0777, TRUE);

        // F = Saves to Filesystem | D = Force Download | I = Show to Browser | S = as String | E = Base64
        ob_clean();
        $pdf->Output(FCPATH . $saveDir . $fileName, 'F');

        echo json_encode(array(
            'mode' => 'pdf',
            'path' => FCPATH . $saveDir . $fileName,
            'url'  => base_url($saveDir . $fileName)
        ));
    }

    public function export_xls()
    {
        $spreadsheet = new Spreadsheet();

        $spreadsheet->setActiveSheetIndex(0); // set active worksheet

        // GLOBAL STYLE
        $styleArray = [
            'headerTitle_1' => [
                'font' => [
                    'name' => 'Times New Roman',
                    'bold' => TRUE,
                    'size' => 16
                ],
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
                ]
            ],
            'headerTitle_2' => [
                'font' => [
                    'bold' => TRUE,
                    'size' => 14
                ],
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
                ]
            ],
            'headerInfo' => [
                'font' => [
                    'name' => 'Times New Roman',
                    'bold' => TRUE
                ]
            ],
            'headerFields' => [
                'borders' => [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000']
                    ]
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
                ]
            ],
            'dataContents' => [
                'borders' => [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000']
                    ]
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    'wrapText' => TRUE
                ]
            ],
        ];

        // ---------------------------------------------------------

        // HEADER - LOGO
        $logo = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $logo->setName('LOGO SMKN 1 SUBANG');
        $logo->setDescription('LOGO');
        $logo->setPath('assets\images\smkn1subang.png');
        $logo->setCoordinates('B2');
        $logo->setHeight(80);
        $logo->setOffsetX(50);
        $logo->setWorksheet($spreadsheet->getActiveSheet());

        // ---------------------------------------------------------

        // HEADER - TITLE 
        $spreadsheet->getActiveSheet()->setCellValue('C2', 'SMK NEGERI 1 SUBANG');
        $spreadsheet->getActiveSheet()->setCellValue('C3', 'LAPORAN');
        $spreadsheet->getActiveSheet()->setCellValue('C4', 'DATA PENGADUAN - SMKN 1 SUBANG');
        $spreadsheet->getActiveSheet()->getStyle('C2:F2')->applyFromArray($styleArray['headerTitle_1']);
        $spreadsheet->getActiveSheet()->getStyle('C3:F4')->applyFromArray($styleArray['headerTitle_2']);

        // ---------------------------------------------------------

        // INFO
        $spreadsheet->getActiveSheet()->setCellValue('B6', 'JENIS LAYANAN');
        $spreadsheet->getActiveSheet()->setCellValue('C6', ': ' . $_POST['jenisLayanan']);
        $spreadsheet->getActiveSheet()->setCellValue('B7', 'PADA');
        $spreadsheet->getActiveSheet()->setCellValue('C7',  ': ' . $_POST['padaWaktu']);
        $spreadsheet->getActiveSheet()->getStyle('B6:B7')->applyFromArray($styleArray['headerInfo']);

        // ---------------------------------------------------------

        // TABLE - HEADER FIELDS
        $tableFields = $_POST['tableFields']['xls'];
        foreach ($tableFields as $fn) {
            // CONTENTS
            $spreadsheet->getActiveSheet()->setCellValue($fn['CellPos'], $fn['Name']);

            // STYLE
            $spreadsheet->getActiveSheet()->getStyle($fn['CellPos'])->applyFromArray($styleArray['headerFields']);
            $spreadsheet->getActiveSheet()->getColumnDimension($fn['ColPos'])->setWidth($fn['ColWidth']);
        }

        // ---------------------------------------------------------

        // TABLE - DATA
        $isSet_tableData = isset($_POST['tableData']);
        if ($isSet_tableData) {
            $tableData = $_POST['tableData'];
            $rowPosInit = $tableData[0]['rowPos'];
            foreach ($tableData as $dt) {
                // CONTENTS
                $colPos = [];
                $colPos = $dt['colPos'];
                $data = [];
                $data = $dt['contentData'];

                for ($i = 0; $i < count($data); $i++) {
                    // CONTENTS - DATA
                    $spreadsheet->getActiveSheet()->setCellValue($colPos[$i] . $rowPosInit, $data[$i]);

                    // STYLE
                    $spreadsheet->getActiveSheet()->getStyle($colPos[$i] . $rowPosInit)->applyFromArray($styleArray['dataContents']);
                }
                $rowPosInit++;
            }
        }

        // ---------------------------------------------------------

        // SAVE AND FORCE DOWNLOAD
        $writer = new Xlsx($spreadsheet);
        $fileName = 'report_' . Date('Y-m-d') . '.xlsx';
        $fileType = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';

        ob_start();
        $writer->save('php://output');
        $writerData = ob_get_contents();
        ob_end_clean();

        echo json_encode(array(
            'mode' => 'xls',
            'name' => $fileName,
            'file'  => 'data:' . $fileType . ';base64,' . base64_encode($writerData)
        ));
    }
}
