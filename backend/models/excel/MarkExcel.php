<?php

namespace backend\models\excel;

use Yii;
use common\models\Common;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;


class MarkExcel
{
	public $courseName;
	public $response;
	public $spreadsheet;
	public $sheet;
	public $border;
	public $bold;
	public $bgcolor;
	public $bgcolor_input;
	public $percentage;
	
	public function generateExcel(){
		$this->start();
		$this->setColumWidth();
		$this->topHeaderMark();
		$this->topAssessementMark();
		$this->listStudentMark();
		//$this->topHeaderInput();
		//$this->setColumWidth();
		$this->generate();
	}
	
	public function start(){
		$this->spreadsheet = new Spreadsheet();
		$this->spreadsheet->getProperties()->setCreator('eSIAP')
			->setLastModifiedBy('eSIAP')
			->setTitle('TEMPLATE MARKAH ' . $this->courseName)
			->setSubject('TEMPLATE MARKAH ' . $this->courseName)
			->setDescription('TEMPLATE MARKAH Generated by eSIAP')
			->setKeywords($this->courseName . ' Skyhint Design');
		
		$this->spreadsheet->getActiveSheet()->setTitle('MARKAH');
			
		$this->sheet = $this->spreadsheet->getActiveSheet();
		
		
		
		$this->border = array(
				'font'  => array(
					'bold'  => false,
					//'color' => array('rgb' => 'FF0000'),
					'size'  => 11,
					'name'  => 'Calibri'
					),
				'borders' => array(
					'outline' => array(
						'borderStyle' => Border::BORDER_THIN,
					),
				),
			);
		$this->bold = array(
				'font'  => array(
					'bold'  => true,
					//'color' => array('rgb' => 'FF0000'),
					'size'  => 11,
					'name'  => 'Calibri'
					),
				'borders' => array(
					'outline' => array(
						'borderStyle' => Border::BORDER_THIN,
					),
				),
			);
			
			
		$this->percentage = array();
		
		$this->bgcolor = 'FFD9D9D9';
		$this->bgcolor_input = 'FFFDE9D9';
		
	}
	
	public function setColumWidth(){
		$normal = 10.2;//9.43
		$this->sheet->getColumnDimension('A')->setWidth(4.86);
		$this->sheet->getColumnDimension('B')->setWidth(11);
		$this->sheet->getColumnDimension('C')->setWidth(48);
		$this->sheet->getColumnDimension('D')->setWidth(13);
		$this->sheet->getColumnDimension('E')->setWidth(15);
		$this->sheet->getColumnDimension('F')->setWidth(16.2);
		$this->sheet->getColumnDimension('G')->setWidth(16.2);
	}
	
	public function topHeaderMark(){
		//ROW HEIGHT
		$this->sheet->getRowDimension('1')->setRowHeight(33);
		$this->sheet->getRowDimension('2')->setRowHeight(15);
		
		//MERGE
		$this->sheet->mergeCells('A1:A2');
		$this->sheet->mergeCells('B1:B2');
		$this->sheet->mergeCells('C1:C2');
		
		//BORDER
		$this->sheet->getStyle('A1:A2')->applyFromArray($this->bold);
		$this->sheet->getStyle('B1:B2')->applyFromArray($this->bold);
		$this->sheet->getStyle('C1:C2')->applyFromArray($this->bold);

		//ALIGNMENT
		$this->sheet->getStyle('A1:A2')
		->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
		$this->sheet->getStyle('A1:A2')
		->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)
		->setWrapText(true);
		
		$this->sheet->getStyle('B1:B2')
		->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
		$this->sheet->getStyle('B1:B2')
		->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)
		->setWrapText(true);
		
		$this->sheet->getStyle('C1:C2')
		->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
		$this->sheet->getStyle('C1:C2')
		->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)
		->setWrapText(true);
		
		

		
		//STYLE
		//$this->sheet->getStyle('B4')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
		
		$this->sheet
			->getStyle('A1:C2')->getFill()
			->setFillType(Fill::FILL_SOLID)
			->getStartColor()->setARGB($this->bgcolor);
			
			
		//CONTENT
		$this->sheet
			->setCellValue('A1', 'Bil. ')
			->setCellValue('B1', 'No. Matrik')
			->setCellValue('C1', 'Nama Pelajar')
			;
	}
	
	public function topAssessementMark(){
		
		
		//BORDER
		$arr = ['D1', 'D2','E1', 'E2', 'F1', 'F2', 'G1', 'G2'];
		foreach($arr as $a){
			$this->sheet->getStyle($a)->applyFromArray($this->bold);
		}
		
		

		//ALIGNMENT
		$this->sheet->getStyle('D1:G2')
		->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
		$this->sheet->getStyle('D1:G2')
		->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)
		->setWrapText(true);
		
		//STYLE
		
		$this->sheet->getStyle('D2:G2')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_PERCENTAGE);
		
		$this->sheet
			->getStyle('D1:G2')->getFill()
			->setFillType(Fill::FILL_SOLID)
			->getStartColor()->setARGB($this->bgcolor);
		
		
			
		//CONTENT
		$this->sheet
			->setCellValue('D1', 'Tunjuk Cara')
			->setCellValue('E1', 'Laporan Keseluruhan')
			->setCellValue('F1', 'Kertas Cadangan Aktiviti')
			->setCellValue('G1', 'Laporan Aktiviti Berkumpulan')
			->setCellValue('D2', 0.25)
			->setCellValue('E2', 0.25)
			->setCellValue('F2', 0.25)
			->setCellValue('G2', 0.25)
			;
	}
	
	public function listStudentMark(){
		if($this->response){
			$row = 3;
			foreach($this->response->result as $student){
				$this->rowStudentMark($row, $student);
				$row++;
			}
		}
	}
	
	public function rowStudentMark($row, $student){
		//ROW HEIGHT
		$this->sheet->getRowDimension($row)->setRowHeight(15);
		
		//BORDER
		$col = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];
		foreach($col as $c){
			$this->sheet->getStyle($c.$row)->applyFromArray($this->border);
		}
		
		//ALIGNMENT
		$this->sheet->getStyle('A'.$row.':B'. $row)
		->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
		$this->sheet->getStyle('C'.$row)
		->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
		
		$this->sheet->getStyle('D'.$row.':G'. $row)
		->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
		
		

		
		//STYLE
		//$this->sheet->getStyle('B4')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
		

			
		$number = $row - 2;
		//CONTENT
		$this->sheet
			->setCellValue('A' . $row, $number)
			->setCellValue('B' . $row, $student->id)
			->setCellValue('C' . $row, $student->name)
			;
	}
	
	public function topHeaderInput(){
		$this->spreadsheet->createSheet();
		$this->spreadsheet->setActiveSheetIndex(1);
		$this->spreadsheet->getActiveSheet()->setTitle('INPUT');
		$this->sheet = $this->spreadsheet->getActiveSheet();
		
		//ROW HEIGHT
		$this->sheet->getRowDimension('1')->setRowHeight(33);
		$this->sheet->getRowDimension('2')->setRowHeight(15);
		
		//MERGE
		$this->sheet->mergeCells('A1:A2');
		$this->sheet->mergeCells('B1:B2');
		$this->sheet->mergeCells('C1:C2');
		
		//BORDER
		$this->sheet->getStyle('A1:A2')->applyFromArray($this->bold);
		$this->sheet->getStyle('B1:B2')->applyFromArray($this->bold);
		$this->sheet->getStyle('C1:C2')->applyFromArray($this->bold);

		//ALIGNMENT
		$this->sheet->getStyle('A1:A2')
		->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
		$this->sheet->getStyle('A1:A2')
		->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)
		->setWrapText(true);
		
		$this->sheet->getStyle('B1:B2')
		->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
		$this->sheet->getStyle('B1:B2')
		->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)
		->setWrapText(true);
		
		$this->sheet->getStyle('C1:C2')
		->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
		$this->sheet->getStyle('C1:C2')
		->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)
		->setWrapText(true);
		
		

		
		//STYLE
		//$this->sheet->getStyle('B4')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
		
		$this->sheet
			->getStyle('A1:C2')->getFill()
			->setFillType(Fill::FILL_SOLID)
			->getStartColor()->setARGB($this->bgcolor_input);
			
			
		//CONTENT
		$this->sheet
			->setCellValue('A1', 'Bil. ')
			->setCellValue('B1', 'No. Matrik')
			->setCellValue('C1', 'Nama Pelajar')
			;
	}
	
	public function generate(){
		// Rename worksheet
		
		
		

		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$this->spreadsheet->setActiveSheetIndex(0);
		
		// Redirect output to a client’s web browser (Xls)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $this->courseName .'.xls"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
		header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header('Pragma: public'); // HTTP/1.0

		$writer = IOFactory::createWriter($this->spreadsheet, 'Xls');
		$writer->save('php://output');
		exit;
	}
	
	public function abc($col){
		$arr = [
			1 => 'A',
			2 => 'B',
			3 => 'C',
			4 => 'D',
			5 => 'E',
			6 => 'F',
			7 => 'G',
			8 => 'H',
			9 => 'I',
			10 => 'J',
			11 => 'K',
			12 => 'L',
			13 => 'M',
			14 => 'N',
			15 => 'O',
			16 => 'P',
			17 => 'Q'
		];
		
		return $arr[$col];
	}
	
	
	
}
