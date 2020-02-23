<?php

namespace backend\models\pdf;

use Yii;

class AttendanceSummaryStart extends \TCPDF {
	
	public $model;

    //Page header
    public function Header() {
		//$this->myX = $this->getX();
		//$this->myY = $this->getY();
		//$savedX = $this->x;
		//savedY = $this->y;
		date_default_timezone_set("Asia/Kuala_Lumpur");
	
		$dir = Yii::$app->assetManager->getPublishedUrl('@frontend/views/myasset');
		
		$page = $this->getPage();
		$height = 36;
		$line_height = 250;
		$html ='
		<table border="1" cellpadding="2">
		<tr>
		
		<td align="center" width="8%" rowspan="3">
		<img src="images/logo-attend.png" />
		</td>
		<td width="92%" height="'.$height.'" style="line-height:'.$line_height.'%">&nbsp;&nbsp;<b>STUDENT ATTENDANCE (OVERALL)</b>
		</td>
		</tr>
		
		<tr>
		<td height="'.$height.'" style="background-color:#ebebeb;line-height:'.$line_height.'%">&nbsp;&nbsp;<b>SEMESTER: </b>'. strtoupper($this->model->semester->fullFormat()).'
		</td>
		</tr>
		
		<tr>
		<td height="'.$height.'" style="background-color:#ebebeb;line-height:'.$line_height.'%">&nbsp;&nbsp;<b>SUBJECT: </b>'.$this->model->acceptedCourse->course->course_code.' ('.$this->model->applicationGroup->group_name.') - '.strtoupper($this->model->acceptedCourse->course->course_name).'
		</td>
		</tr>
		
		
		</table>
		';
		
		$this->SetFont('arial', '', 8.5);

		$this->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'top', $autopadding = true);
		
	 
		//$this->setX($this->myX);
		//$this->setY(90);
		
		//$this->SetY($savedY);
		//$this->SetX($savedX);

	    
    }
	
	 public function Footer() {
		 
		 $y = $this->getY();
		 $this->SetFont('arial', '', 8.5);
		 
		 $time = strtoupper(date('d-M-Y h:m A', time()));
		 
		  $this->Cell(0, 10, 'eFasi @  '. $time, 0, false, 'L', 0, '', 0, false, 'T', 'M');
		  
		  $this->setY($y);
		  $this->Cell(0, 10, '* H = HADIR, XH = TIDAK HADIR ', 0, false, 'C', 0, '', 0, false, 'T', 'M');
		 $this->setY($y);

		  $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().' of '.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
		  
		 
		
	 }


}
