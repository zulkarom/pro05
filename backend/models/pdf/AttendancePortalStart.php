<?php

namespace backend\models\pdf;

use Yii;

class AttendancePortalStart extends \TCPDF {
	
	public $model;
	public $date;
	public $venue;
	public $venue_code;
	public $start_time;
	public $duration;
	
    //Page header
    public function Header() {
		//$this->myX = $this->getX();
		//$this->myY = $this->getY();
		//$savedX = $this->x;
		//savedY = $this->y;
		$dir = Yii::$app->assetManager->getPublishedUrl('@frontend/views/myasset');
		
		$page = $this->getPage();
		$height = 33;
		$line_height = 220;
		
		$time = strtotime($this->start_time) + ($this->duration * 60 * 60);
		//echo strtotime($this->start_time) . '=' . ($this->duration * 60 * 60); die();
		$timeend = date('H:i', $time);
		$now = strtoupper(date('d-M-Y h:m A', time()));
		$html ='
		
		<table border="1" cellpadding="6">
		<tr>
		
		<td align="center" width="12%">
		<img src="images/logo-attend.png" />
		</td>
		
		<td width="88%">
		
		<table border="0" cellpadding="2" >
		<tr>
		<td width="75%" height="'.$height.'" style="line-height:'.$line_height.'%">&nbsp;&nbsp;<b>'.$this->model->acceptedCourse->course->course_code.' - '.$this->model->groupName.' - '.strtoupper($this->model->acceptedCourse->course->course_name).'</b>
		</td>
		<td width="25%"  style="line-height:'.$line_height.'%">&nbsp;&nbsp;
		</td>
		</tr>
		
		<tr height="'.$height.'" style="line-height:'.$line_height.'%">
		<td>&nbsp;&nbsp;<b>TARIKH</b> : '.$this->date .'  &nbsp; MASA : '.$this->start_time.' - '.$timeend.'
		</td>
		<td>eFasi (QRcode)</td>
		</tr>
		
		<tr height="'.$height.'" style="line-height:'.$line_height.'%">
		<td>&nbsp;&nbsp;<b>TEMPAT</b> : '.$this->venue_code .' - '.$this->venue .'
		</td>
		<td>'.$now.'</td>
		</tr>
		
		
		</table>
		
		</td>
		</tr>
		</table>
		
		';
		
		$this->SetFont('arial', '', 8.5);

		$this->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'top', $autopadding = true);
		
		$this->setY(10);
		$this->setX(155);
		
		  $this->Cell(40, 10, 'Page '.$this->getAliasNumPage().' of '.$this->getAliasNbPages(), 0, false, 'L', 0, '', 0, false, 'T', 'M');
		
	 
		//$this->setX($this->myX);
		//$this->setY(90);
		
		//$this->SetY($savedY);
		//$this->SetX($savedX);

	    
    }
	
	 public function Footer() {
		 $y = $this->getY();
		 $this->SetFont('arial', '', 8.5);
		 
		 $this->setY($y);
		  $this->Cell(0, 10, '* H = HADIR, XH = TIDAK HADIR ', 0, false, 'L', 0, '', 0, false, 'T', 'M');
		 $this->setY($y);
	 }


}
