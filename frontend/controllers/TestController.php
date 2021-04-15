<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use TCPDF;

/**
 * Site controller
 */
class TestController extends Controller
{

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionTestCurl()
    {
		$url = 'https://portal.umk.edu.my/api/timetable/student?semester=202020212&subject=AFT1043&group=L2T1';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		$data = curl_exec($ch);
		curl_close($ch);
		echo $data;
		exit();
    }
	
	
	public function actionTestPdf(){
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$pdf->AddPage();
$html = <<<EOD
<h1>Berjaya!</h1>
EOD;
		$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
		$pdf->Output('example_001.pdf', 'I');
		exit();
	}
}
