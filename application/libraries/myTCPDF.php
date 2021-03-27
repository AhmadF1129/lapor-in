<?php
defined('BASEPATH') or exit('No direct script access allowed');

require('TCPDF/tcpdf.php');

class myTCPDF extends TCPDF
{
    protected $ci;

    public function __construct()
    {
        parent::__construct();
        $this->ci = &get_instance();
    }

    // PAGE HEADER => Logo | Title
    public function Header()
    {
        // Get Image
        $image_file = '<img src="' . K_PATH_IMAGES . 'smkn1subang.png' . '" height="75" width="auto">';

        // Set Header
        $setHeader = '
            <table>
                <tr>
                    <td rowspan="3" width="15%">' . $image_file . '</td>
                    <td width="85%"><h1>SMK NEGERI 1 SUBANG</h1></td>
                </tr>
                <tr>
                    <td style="font-size:15px" width="85%">LAPORAN</td>
                </tr>
                <tr>
                    <td style="font-size:15px" width="85%">DATA PENGADUAN - SMKN 1 SUBANG</td>
                </tr>
            </table>
            <br>
            <hr>';
        $this->writeHTMLCell(0, 0, '', '', $setHeader, 0, 0, 0, true, false, false);
    }

    // PAGE FOOTER => Printed Date | Page Number
    public function Footer()
    {
        // Set Footer
        $setFooter = '
            <hr>
            <br>
            <table> 
                <tr>
                    <td width="90%">Print @ ' . gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7) . '</td>
                    <td width="10%">Page ' . $this->getAliasNumPage() . ' / ' . $this->getAliasNbPages() . '</td>
                </tr>
            </table> ';

        $this->SetFont('helvetica', 'I', 8);
        $this->writeHTMLCell(0, 0, '', '', $setFooter, 0, 1, 0, true, 'L', true);
    }
}
