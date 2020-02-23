<?php

namespace backend\models\pdf;

use Yii;

class AttendanceStart extends \TCPDF {
	

    //Page header
    public function Header() {
		//$this->myX = $this->getX();
		//$this->myY = $this->getY();
		//$savedX = $this->x;
		//savedY = $this->y;
		date_default_timezone_set("Asia/Kuala_Lumpur");
	
		$dir = Yii::$app->assetManager->getPublishedUrl('@frontend/views/myasset');
		
		$page = $this->getPage();
		$html ='
		<table>
		<tr>
		<td width="30%">
		<br /><br /><br />
		eFasi</td>
		<td width="40%" align="center">

		<img src="images/logo-attendance.png" /><br />
		<b>Students Attendance</b>
		</td>
		<td width="5%"></td>
		<td width="25%">
		<br /><br />
		<span style="font-size:14px">Page : '.$this->getAliasNumPage().' of '.$this->getAliasNbPages().'
		<br />Date : '. strtoupper(date('d-M-Y h:m A', time())).' 
		</span>
		
		</td>
		</tr>
		</table>
		';

		$this->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'top', $autopadding = true);
		
	 
		//$this->setX($this->myX);
		//$this->setY(90);
		
		//$this->SetY($savedY);
		//$this->SetX($savedX);

	    
    }
	
	 public function Footer() {
		 
	 }


}
