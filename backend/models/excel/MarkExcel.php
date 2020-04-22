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
use PhpOffice\PhpSpreadsheet\Style\Protection;


class MarkExcel
{
	public $model;
	public $courseName;
	public $courseCode;
	public $semester;
	public $group;
	public $fasi;
	public $response;
	public $spreadsheet;
	public $sheet;
	public $border;
	public $border_bold;
	public $bgcolor = 'FFD9D9D9';
	public $bgcolor_green = 'ffe2efda';
	public $bgcolor_blue = 'ffddebf7';
	public $bgcolor_input = 'FFFDE9D9';
	public $percentage;
	public $bold;
	public $unbold;
	public $fontWhite;
	public $lastRow;
	public $lastRowMark;
	public $normal;
	
	public function generateExcel(){
		$this->startMetadata();
		$this->setStyle();
		
		$this->startMarkahSheet();
		
		$this->startRefleksiSheet();
		$this->setColumWidthRefleksi();
		$this->putTitleRefleksi();
		$this->subAttributeMoralTable();
		$this->subAttributeTanggungjawabTable();
		$this->topHeaderRefleksi();
		$this->listStudentRefleksi();
		
		$this->startAcaraSheet();
		$this->setColumWidthRefleksi();
		$this->putTitleAcara();
		$this->subAttributeKepimpinanTable();
		$this->subAttributeHubunganTable();
		$this->topHeaderAcara();
		$this->listStudentRefleksi();
		
		$this->startRefSheet();
		$this->setColumWidthRef();
		$this->gradeTable();
		
		$this->setMarkahActive();
		$this->setColumWidth();
		$this->putTitleMark();
		$this->topHeaderMark();
		$this->topAssessementMark();
		$this->listStudentMark();
		$this->analyseClo();
		$this->setProtection();

		$this->generate();
	}
	
	public function startMetadata(){
		$this->spreadsheet = new Spreadsheet();
		$this->spreadsheet->getProperties()->setCreator('eSIAP')
			->setLastModifiedBy('eSIAP')
			->setTitle('TEMPLATE MARKAH ' . $this->courseCode . ' ' . $this->courseName)
			->setSubject('TEMPLATE MARKAH ' . $this->courseCode . ' ' . $this->courseName)
			->setDescription('TEMPLATE MARKAH Generated by eSIAP')
			->setKeywords($this->courseCode . ' ' . $this->courseName . ' Skyhint Design');
		
		
	}
	
	public function setStyle(){
		$this->normal = array(
				'font'  => array(
					'bold'  => false,
					
					'size'  => 10,
					'name'  => 'Arial Narrow'
					),
			);
			
		$this->fontWhite = array(
				'font'  => array(
					'bold'  => false,
					'color' => array('rgb' => 'FFFFFFFF'),
					'size'  => 10,
					'name'  => 'Arial Narrow'
					),
			);
			
		$this->border = array(
				'font'  => array(
					'bold'  => false,
					//'color' => array('rgb' => 'FF0000'),
					'size'  => 10,
					'name'  => 'Arial Narrow'
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
					)
			);
		$this->unbold = array(
				'font'  => array(
					'bold'  => false,
					)
			);
		$this->border_bold = array(
				'font'  => array(
					'bold'  => true,
					//'color' => array('rgb' => 'FF0000'),
					'size'  => 10,
					'name'  => 'Arial Narrow'
					),
				'borders' => array(
					'outline' => array(
						'borderStyle' => Border::BORDER_THIN,
					),
				),
			);
			
			
		$this->percentage = array();
	}
	
	public function startMarkahSheet(){
		$this->spreadsheet->getActiveSheet()->setTitle('MARKAH');
		$this->sheet = $this->spreadsheet->getActiveSheet();
	}
	
	public function setColumWidth(){
		$normal = 10.2;//9.43
		$this->sheet->getColumnDimension('A')->setWidth(4.86);
		$this->sheet->getColumnDimension('B')->setWidth(15);
		$this->sheet->getColumnDimension('C')->setWidth(48);
		$this->sheet->getColumnDimension('D')->setWidth(13);
		$this->sheet->getColumnDimension('E')->setWidth(19);
		$this->sheet->getColumnDimension('F')->setWidth(21);
		$this->sheet->getColumnDimension('G')->setWidth(16.2);
		$this->sheet->getColumnDimension('H')->setWidth(12);
		$this->sheet->getColumnDimension('I')->setWidth(13);
		$this->sheet->getColumnDimension('J')->setWidth(9);
		$this->sheet->getColumnDimension('K')->setWidth(9);
	}
	
	public function putTitleMark(){
		
		//ROW HEIGHT
		$this->sheet->getRowDimension('2')->setRowHeight(15);
		$this->sheet->getRowDimension('3')->setRowHeight(15);
		$this->sheet->getRowDimension('3')->setRowHeight(15);
		
		
		//BORDER
		$this->sheet->getStyle('A2:K2')->applyFromArray($this->border);
		$this->sheet->getStyle('A3:K3')->applyFromArray($this->border);
		$this->sheet->getStyle('A4:K4')->applyFromArray($this->border);

		
		//STYLE
		
		
		$this->sheet
			->getStyle('A2:K4')->getFill()
			->setFillType(Fill::FILL_SOLID)
			->getStartColor()->setARGB('FFFFFFFF');
			
			
		//CONTENT
		$this->sheet
			->setCellValue('B2', 'SEMESTER:')
			->setCellValue('C2', strtoupper($this->semester->niceFormat()))
			->setCellValue('B3', 'SUBJEK:')
			->setCellValue('C3', strtoupper($this->courseCode . '('.$this->group .') - ' . $this->courseName))
			->setCellValue('B4', 'FASILITATOR:')
			->setCellValue('C4', strtoupper($this->fasi))
			//$model->semester->id
			;
	}
	
	public function topHeaderMark(){
		//ROW HEIGHT
		$this->sheet->getRowDimension('6')->setRowHeight(15);
		$this->sheet->getRowDimension('7')->setRowHeight(41);
		$this->sheet->getRowDimension('8')->setRowHeight(15);
		
		//MERGE
		$this->sheet->mergeCells('A6:A8');
		$this->sheet->mergeCells('B6:B8');
		$this->sheet->mergeCells('C6:C8');
		
		//BORDER
		$this->sheet->getStyle('A6:A8')->applyFromArray($this->border_bold);
		$this->sheet->getStyle('B6:B8')->applyFromArray($this->border_bold);
		$this->sheet->getStyle('C6:C8')->applyFromArray($this->border_bold);

		//ALIGNMENT
		$this->sheet->getStyle('A6:A8')
		->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
		$this->sheet->getStyle('A6:A8')
		->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)
		->setWrapText(true);
		
		$this->sheet->getStyle('B6:B8')
		->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
		$this->sheet->getStyle('B6:B8')
		->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)
		->setWrapText(true);
		
		$this->sheet->getStyle('C6:C8')
		->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
		$this->sheet->getStyle('C6:C8')
		->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)
		->setWrapText(true);
		
		

		
		//STYLE
		//$this->sheet->getStyle('B4')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
		
		$this->sheet
			->getStyle('A6:C8')->getFill()
			->setFillType(Fill::FILL_SOLID)
			->getStartColor()->setARGB($this->bgcolor_green);
			
			
		//CONTENT
		$this->sheet
			->setCellValue('A6', 'BIL. ')
			->setCellValue('B6', 'NO. MATRIK')
			->setCellValue('C6', 'NAMA PELAJAR')
			;
	}
	
	public function topAssessementMark(){
		
		$arr1 = ['D6:E6', 'F6:G6','H6:H7', 'I6:I7', 'J6:J7', 'K6:K7'];
		//MERGE
		foreach($arr1 as $a){
			$this->sheet->mergeCells($a);
		}
		
		//BORDER
		$arr2 = [
		'D7', 'E7', 'F7', 'G7', 
		'D8', 'E8', 'F8', 'G8',
		'H8', 'I8', 'J8', 'K8'
		];
		$arr3 = array_merge($arr1, $arr2);
		foreach($arr3 as $a){
			$this->sheet->getStyle($a)->applyFromArray($this->border_bold);
			
			//ALIGNMENT
			$this->sheet->getStyle($a)
			->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
			$this->sheet->getStyle($a)
			->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)
			->setWrapText(true);
		}
		
		$unbold = ['D7', 'E7', 'F7', 'G7'];
		foreach($unbold as $a){
			$this->sheet->getStyle($a)->applyFromArray($this->unbold);
		}
		
		//STYLE

		$this->sheet
			->getStyle('D7:G8')->getFill()
			->setFillType(Fill::FILL_SOLID)
			->getStartColor()->setARGB($this->bgcolor);
		$this->sheet
			->getStyle('D6:G6')->getFill()
			->setFillType(Fill::FILL_SOLID)
			->getStartColor()->setARGB($this->bgcolor_green);
		$this->sheet
			->getStyle('H6:I8')->getFill()
			->setFillType(Fill::FILL_SOLID)
			->getStartColor()->setARGB($this->bgcolor_green);
		$this->sheet
			->getStyle('J6:K8')->getFill()
			->setFillType(Fill::FILL_SOLID)
			->getStartColor()->setARGB($this->bgcolor_blue);
		
			
		//CONTENT
		$this->sheet
			->setCellValue('D6', 'REFLEKSI')
			->setCellValue('F6', 'PENGURUSAN ACARA/AKTIVITI')
			->setCellValue('H6', "REFLEKSI\n(50%)")
			->setCellValue('I6', "PENGURUSAN ACARA\n(50%)")
			->setCellValue('J6', 'JUMLAH')
			->setCellValue('K6', 'GRED')
			->setCellValue('D7', "Moral\n(25%)")
			->setCellValue('E7', "Tanggungjawab Kerja\n(25%)")
			->setCellValue('F7', "Pengetahuan & pemahaman kepimpinan \n(25%)")
			->setCellValue('G7', "Membina hubungan baik\n(25%)")
			->setCellValue('D8', 'CLO 1')
			->setCellValue('E8', 'CLO 1')
			->setCellValue('F8', 'CLO 2')
			->setCellValue('G8', 'CLO 2')
			->setCellValue('H8', 'CLO 1')
			->setCellValue('I8', 'CLO 2')
			->setCellValue('J8', '100%')
			;
	}
	
	public function listStudentMark(){
		if($this->response){
			$row = 9;
			$i = 1;
			foreach($this->response->result as $student){
				$this->rowStudentMark($row, $i, $student);
				$row++;
				$i++;
			}
			$this->lastRowMark = $row - 1;
		}
	}
	
	public function rowStudentMark($row, $i, $student){
		//ROW HEIGHT
		$this->sheet->getRowDimension($row)->setRowHeight(15);
		
		//BORDER
		$col = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K'];
		foreach($col as $c){
			$this->sheet->getStyle($c.$row)->applyFromArray($this->border);
		}
		
		//ALIGNMENT
		$this->sheet->getStyle('A'.$row.':B'. $row)
		->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
		$this->sheet->getStyle('C'.$row)
		->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
		
		$this->sheet->getStyle('D'.$row.':K'. $row)
		->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
		
		$this->sheet
			->getStyle('H'.$row.':I'.$row)->getFill()
			->setFillType(Fill::FILL_SOLID)
			->getStartColor()->setARGB($this->bgcolor_green);
		$this->sheet
			->getStyle('J'.$row.':K'.$row)->getFill()
			->setFillType(Fill::FILL_SOLID)
			->getStartColor()->setARGB($this->bgcolor_blue);
		
		

		
		//STYLE
		//$this->sheet->getStyle('B4')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
		

		
		//CONTENT
		$this->sheet
			->setCellValue('A' . $row, $i)
			->setCellValue('B' . $row, $student->id)
			->setCellValue('C' . $row, $student->name)
			;
			

			$this->sheet
			->setCellValue('D'. $row, '=5*VLOOKUP(B'.$row.',REFLEKSI!$B$16:$F$'.$this->lastRow.',4,0)');
			
			$this->sheet
			->setCellValue('E'. $row, '=5*VLOOKUP(B'.$row.',REFLEKSI!$B$16:$F$'.$this->lastRow.',5,0)');
			
			$this->sheet
			->setCellValue('F'. $row, '=5*VLOOKUP(B'.$row.',PENGURUSAN_ACARA!$B$16:$F$'.$this->lastRow.',4,0)');
			
			$this->sheet
			->setCellValue('G'. $row, '=5*VLOOKUP(B'.$row.',PENGURUSAN_ACARA!$B$16:$F$'.$this->lastRow.',5,0)');
			
			$this->sheet
			->setCellValue('H'. $row, '=D'.$row.'+E'.$row)
			->setCellValue('I'. $row, '=F'.$row.'+G'.$row)
			->setCellValue('J'. $row, '=H'.$row.'+I'.$row)
			->setCellValue('K'. $row, '=VLOOKUP(J'.$row.',REF!$A$2:$B$12,2)')
			;
			
	}
	
	public function analyseClo(){
		
		$row0 = $this->lastRowMark + 2;
		$row1 = $row0 + 1;
		$row2 = $row1 + 1;
		$row3 = $row2 + 1;
		$row4 = $row3 + 1;
		$row5 = $row4 + 1;
		
		$this->sheet->getRowDimension($row5)->setRowHeight(34);
		
		$this->sheet->getStyle('G'.$row5)
			->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
			
		$this->sheet->getStyle('H'.$row5.':I'.$row5)
			->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
		
		$this->sheet->getStyle('H'.$row5.':I'.$row5)
			->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)
			->setWrapText(true);
		
		$this->sheet->getStyle('G'.$row0.':I'.$row5)->applyFromArray($this->normal);
		$this->sheet->getStyle('G'.$row0.':I'.$row0)->applyFromArray($this->bold);
		
		$this->sheet->getStyle('G'.$row0 . ':I'.$row0)
		->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
		
		$this->sheet->getStyle('G'.$row1 . ':G'.$row5)
		->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
		$this->sheet->getStyle('H'.$row1 . ':I'.$row5)
		->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
		
		$bottom = [
			'borders' => [
				'bottom' => [
					'borderStyle' => Border::BORDER_THIN,
				],
			],
		];
		
		$this->sheet->getStyle('G'.$row0.':I'.$row0)
		->applyFromArray($bottom);
		$this->sheet->getStyle('G'.$row2.':I'.$row2)
		->applyFromArray($bottom);
		
		$this->sheet->getStyle('H'.$row1. ':I' . $row1)->getNumberFormat()
		->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
		$this->sheet->getStyle('H'.$row3. ':I' . $row3)->getNumberFormat()
		->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
		
		$this->sheet->getStyle('H'.$row4. ':I' . $row4)->getNumberFormat()
		->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
		
		
		$this->sheet
			->setCellValue('G'. $row0, 'CLO ANALYSIS')
			->setCellValue('H'. $row0, 'CLO 1')
			->setCellValue('I'. $row0, 'CLO 2')
			->setCellValue('G'. $row1, 'AVERAGE')
			->setCellValue('H'. $row1, '=AVERAGE(H9:H'.$this->lastRowMark .')')
			->setCellValue('I'. $row1, '=AVERAGE(I9:I'.$this->lastRowMark .')')
			->setCellValue('G'. $row2, 'CLO WEIGHTAGE')
			->setCellValue('H'. $row2, 50)
			->setCellValue('I'. $row2, 50)
			->setCellValue('G'. $row3, 'AVG / WEIGHTAGE')
			->setCellValue('H'. $row3, '=H'.$row1.'/H'.$row2)
			->setCellValue('I'. $row3, '=I'.$row1.'/I'.$row2)
			->setCellValue('G'. $row4, 'STUDENT ACHIEVEMENT(0-4)')
			->setCellValue('H'. $row4, '=H'.$row3 . '*4')
			->setCellValue('I'. $row4, '=I'.$row3 . '*4')
			->setCellValue('G'. $row5, 'ACHIEVEMENT ANALYSIS')
			->setCellValue('H'. $row5, '=VLOOKUP(H'.$row4.',REF!$D$2:$E$6,2)')
			->setCellValue('I'. $row5, '=VLOOKUP(I'.$row4.',REF!$D$2:$E$6,2)')
			;
			
			
	}
	
	public function startRefleksiSheet(){
		$this->spreadsheet->createSheet();
		$this->spreadsheet->setActiveSheetIndex(1);
		$this->spreadsheet->getActiveSheet()->setTitle('REFLEKSI');
		$this->sheet = $this->spreadsheet->getActiveSheet();
	}
	
	public function setColumWidthRefleksi(){
		$normal = 10.2;//9.43
		$this->sheet->getColumnDimension('A')->setWidth(5);
		$this->sheet->getColumnDimension('B')->setWidth(20);
		$this->sheet->getColumnDimension('C')->setWidth(20);
		$this->sheet->getColumnDimension('D')->setWidth(20);
		$this->sheet->getColumnDimension('E')->setWidth(21);
		$this->sheet->getColumnDimension('F')->setWidth(22);
	}
	
	public function putTitleRefleksi(){
		
		//STYLE
		
		$this->sheet->getStyle('B2:B5')->applyFromArray($this->bold);
		
		
		$this->sheet
			->getStyle('B4:D4')->getFill()
			->setFillType(Fill::FILL_SOLID)
			->getStartColor()->setARGB($this->bgcolor_green);
			
			
		//CONTENT
		$this->sheet
			->setCellValue('B2', 'REFLEKSI (CLO 1)')
			->setCellValue('B4', 'Atribut:')
			->setCellValue('B5', 'Aktiviti:')
			->setCellValue('C4', 'Etika, Nilai, Sikap dan Professionalisme')
			->setCellValue('C5', 'Tunjuk cara/Pembentangan/Kerja Berkumpulan/Refleksi')
			;
	}
	
	public function subAttributeMoralTable(){
		$this->sheet->getRowDimension('9')->setRowHeight(55.5);
		$this->sheet->mergeCells('B7:F7');
		
		//BORDER
		$arr = [
		'B7:F7', 'B8', 'C8', 'D8', 'E8', 'F8', 'B9', 'C9', 'D9', 'E9', 'F9'
		];

		foreach($arr as $a){
			$this->sheet->getStyle($a)->applyFromArray($this->border);
			
			//ALIGNMENT
			$this->sheet->getStyle($a)
			->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
			$this->sheet->getStyle($a)
			->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)
			->setWrapText(true);
		}
		
		$this->sheet->getStyle('B7:F8')->applyFromArray($this->bold);

		
		//STYLE

		$this->sheet
			->getStyle('B7:F7')->getFill()
			->setFillType(Fill::FILL_SOLID)
			->getStartColor()->setARGB($this->bgcolor_green);
		
			
		//CONTENT
		$this->sheet
			->setCellValue('B7', 'Subattribut-1: MORAL')
			->setCellValue('B8', 'Sangat Lemah (1)')
			->setCellValue('C8', "Lemah (2)")
			->setCellValue('D8', "Memuaskan (3)")
			->setCellValue('E8', 'Baik (4)')
			->setCellValue('F8', 'Sangat Baik (5)')
			
			->setCellValue('B9', 'Tidak mengamalkan nilai-nilai murni atau tidak berkelakuan baik sepertimana sepatutnya.')
			->setCellValue('C9', "Mengamalkan nilai-nilai murni atau berkelakuan baik hanya dalam beberapa keadaan.")
			->setCellValue('D9', "Mengamalkan nilai-nilai murni dan berkelakuan baik dalam banyak keadaan.")
			->setCellValue('E9', 'Mengamalkan nilai-nilai murni dan berkelakuan baik dalam hampir semua keadaan')
			->setCellValue('F9', 'Sentiasa mengamalkan nilai-nilai murni dan berkelakuan baik dalam apa jua keadaan.')
			
			;
	}
	
	public function subAttributeTanggungjawabTable(){
		$this->sheet->getRowDimension('13')->setRowHeight(55.5);
		$this->sheet->mergeCells('B11:F11');
		
		//BORDER
		$arr = [
		'B11:F11', 'B12', 'C12', 'D12', 'E12', 'F12', 'B13', 'C13', 'D13', 'E13', 'F13'
		];

		foreach($arr as $a){
			$this->sheet->getStyle($a)->applyFromArray($this->border);
			
			//ALIGNMENT
			$this->sheet->getStyle($a)
			->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
			$this->sheet->getStyle($a)
			->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)
			->setWrapText(true);
		}
		
		$this->sheet->getStyle('B11:F12')->applyFromArray($this->bold);

		
		//STYLE

		$this->sheet
			->getStyle('B11:F11')->getFill()
			->setFillType(Fill::FILL_SOLID)
			->getStartColor()->setARGB($this->bgcolor_green);
		
			
		//CONTENT
		$this->sheet
			->setCellValue('B11', 'Subatribut-2: TANGGUNGJAWAB KERJA')
			->setCellValue('B12', 'Sangat Lemah (1)')
			->setCellValue('C12', "Lemah (2)")
			->setCellValue('D12', "Memuaskan (3)")
			->setCellValue('E12', 'Baik (4)')
			->setCellValue('F12', 'Sangat Baik (5)')
			
			->setCellValue('B13', 'Tidak menjalankan tugas yang diberi walaupun dengan pengawasan.')
			->setCellValue('C13', "Menjalankan tugas yang diberi mengikut skop kerja dengan pengawasan.")
			->setCellValue('D13', "Menjalankan tugas yang diberi mengikut skop kerja yang memenuhi jangkaan.")
			->setCellValue('E13', 'Menjalankan tugas yang diberi mengikut skop kerja yang melebihi jangkaan.')
			->setCellValue('F13', 'Menjalankan tugas yang diberi melebihi skop kerja yang ditetapkan dan menlangkaui jangkaan.')
			
			;
	}
	
	public function topHeaderRefleksi(){
		$this->sheet->getRowDimension('15')->setRowHeight(25.5);
		$this->sheet->mergeCells('C15:D15');
		
		//BORDER
		$arr = [
		'B15', 'C15:D15',  'E15', 'F15'
		];

		foreach($arr as $a){
			$this->sheet->getStyle($a)->applyFromArray($this->border);
			
			//ALIGNMENT
			$this->sheet->getStyle($a)
			->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
			$this->sheet->getStyle($a)
			->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)
			->setWrapText(true);
		}
		
		$this->sheet->getStyle('B15:F15')->applyFromArray($this->bold);

		
		//STYLE

		$this->sheet
			->getStyle('B15:F15')->getFill()
			->setFillType(Fill::FILL_SOLID)
			->getStartColor()->setARGB($this->bgcolor_blue);
		
			
		//CONTENT
		$this->sheet
			->setCellValue('B15', 'NO.MATRIK')
			->setCellValue('C15', "NAMA PELAJAR")
			->setCellValue('E15', "MORAL\n(Markah: 1-5)")
			->setCellValue('F15', "TANGGUNGJAWAB KERJA\n(Markah: 1-5)")
			;
	}
	
	public function listStudentRefleksi(){
		if($this->response){
			$row = 16;
			foreach($this->response->result as $student){
				$this->rowStudentRefleksi($row, $student);
				$row++;
			}
			$this->lastRow = $row - 1;
		}
	}
	
	
	
	public function rowStudentRefleksi($row, $student){
		//ROW HEIGHT
		$this->sheet->getRowDimension($row)->setRowHeight(15);
		
		//BORDER
		$col = ['B{R}', 'C{R}:D{R}', 'E{R}', 'F{R}'];
		foreach($col as $c){
			$kol = str_replace('{R}', $row,$c);
			$this->sheet->getStyle($kol)->applyFromArray($this->border);
		}
		
		$this->sheet->getStyle('E'.$row . ':F'. $row)
			->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)
			->setWrapText(true);
		
		//DATA VALIDATION
		$validation = $this->sheet->getCell('E'.$row)
		->getDataValidation();
		$validation->setType( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST );
		$validation->setErrorStyle( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP);
		$validation->setAllowBlank(false);
		$validation->setShowInputMessage(true);
		$validation->setShowErrorMessage(true);
		$validation->setShowDropDown(true);
		$validation->setErrorTitle('Input error');
		$validation->setError('Value is not in list.');
		$validation->setPromptTitle('Allowed input');
		$validation->setPrompt('Only numbers 0, 0.5, 1, 1.5, 2, 2.5, 3, 3.5, 4, 4.5, 5 are allowed. You can type directly or choose from the list');
		$validation->setFormula1('"5,4.5,4,3.5,3,2.5,2,1.5,1,0.5,0"');
		$this->sheet->getCell('F'.$row)->setDataValidation(clone $validation);
		
		//CONTENT
		$this->sheet
			->setCellValue('B' . $row, $student->id)
			->setCellValue('C' . $row, $student->name)
			;
	}
	
	public function startAcaraSheet(){
		$this->spreadsheet->createSheet();
		$this->spreadsheet->setActiveSheetIndex(2);
		$this->spreadsheet->getActiveSheet()->setTitle('PENGURUSAN_ACARA');
		$this->sheet = $this->spreadsheet->getActiveSheet();
	}
	
	public function putTitleAcara(){
		
		//STYLE
		
		$this->sheet->getStyle('B2:B5')->applyFromArray($this->bold);
		
		
		$this->sheet
			->getStyle('B4:D4')->getFill()
			->setFillType(Fill::FILL_SOLID)
			->getStartColor()->setARGB($this->bgcolor_green);
			
		
			
			
		//CONTENT
		$this->sheet
			->setCellValue('B2', 'PENGURUSAN ACARA/AKTIVITI (CLO 2)')
			->setCellValue('B4', 'Atribut:')
			->setCellValue('B5', 'Aktiviti:')
			->setCellValue('C4', 'Kepimpinan, Kerja Berpasukan')
			->setCellValue('C5', 'Tugasan berkumpulan (pembentangan/perbincangan/projek)')
			;
	}
	
	public function subAttributeKepimpinanTable(){
		$this->sheet->getRowDimension('9')->setRowHeight(80);
		$this->sheet->mergeCells('B7:F7');
		
		//BORDER
		$arr = [
		'B7:F7', 'B8', 'C8', 'D8', 'E8', 'F8', 'B9', 'C9', 'D9', 'E9', 'F9'
		];

		foreach($arr as $a){
			$this->sheet->getStyle($a)->applyFromArray($this->border);
			
			//ALIGNMENT
			$this->sheet->getStyle($a)
			->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
			$this->sheet->getStyle($a)
			->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)
			->setWrapText(true);
		}
		
		$this->sheet->getStyle('B7:F8')->applyFromArray($this->bold);

		
		//STYLE

		$this->sheet
			->getStyle('B7:F7')->getFill()
			->setFillType(Fill::FILL_SOLID)
			->getStartColor()->setARGB($this->bgcolor_green);
		
			
		//CONTENT
		$this->sheet
			->setCellValue('B7', 'Subattribut-1: PENGETAHUAN & PEMAHAMAN KEPIMPINAN')
			->setCellValue('B8', 'Sangat Lemah (1)')
			->setCellValue('C8', "Lemah (2)")
			->setCellValue('D8', "Memuaskan (3)")
			->setCellValue('E8', 'Baik (4)')
			->setCellValue('F8', 'Sangat Baik (5)')
			
			->setCellValue('B9', 'Tiada bukti jelas tentang pengetahuan dan pemahaman yang dizahirkan dalam amalan.')
			->setCellValue('C9', "Boleh mempamerkan pengetahuan dan kefahaman asas kepimpinan dalam amalan tetapi memerlukan penambahbaikan.")
			->setCellValue('D9', "Boleh mempamerkan pengetahuan dan kefahaman asas kepimpinan dalam amalan tetapi memerlukan sedikit penambahbaikan.")
			->setCellValue('E9', 'Boleh mempamerkan pengetahuan dan kefahaman asas kepimpinan dalam amalan dengan baik.')
			->setCellValue('F9', 'Mempamerkan bukti jelas tentang pengetahuan dan pemahaman yang dizahirkan dalam amalan dengan sangat baik.')
			
			;
	}
	
	public function subAttributeHubunganTable(){
		$this->sheet->getRowDimension('13')->setRowHeight(76);
		$this->sheet->mergeCells('B11:F11');
		
		//BORDER
		$arr = [
		'B11:F11', 'B12', 'C12', 'D12', 'E12', 'F12', 'B13', 'C13', 'D13', 'E13', 'F13'
		];

		foreach($arr as $a){
			$this->sheet->getStyle($a)->applyFromArray($this->border);
			
			//ALIGNMENT
			$this->sheet->getStyle($a)
			->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
			$this->sheet->getStyle($a)
			->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)
			->setWrapText(true);
		}
		
		$this->sheet->getStyle('B11:F12')->applyFromArray($this->bold);

		
		//STYLE

		$this->sheet
			->getStyle('B11:F11')->getFill()
			->setFillType(Fill::FILL_SOLID)
			->getStartColor()->setARGB($this->bgcolor_green);
		
			
		//CONTENT
		$this->sheet
			->setCellValue('B11', 'Subatribut-2: MEMBINA HUBUNGAN BAIK')
			->setCellValue('B12', 'Sangat Lemah (1)')
			->setCellValue('C12', "Lemah (2)")
			->setCellValue('D12', "Memuaskan (3)")
			->setCellValue('E12', 'Baik (4)')
			->setCellValue('F12', 'Sangat Baik (5)')
			
			->setCellValue('B13', 'Tiada bukti jelas kebolehan membina hubungan baik dan bekerjasama dengan anggota kumpulan secara berkesan dalam mencapai objektif.')
			->setCellValue('C13', "Boleh membina hubungan baik, dan bekerjasama dengan anggota lain dengan kesan terhad untuk mencapai objektif yang sama tetapi memerlukan penambahbaikan.")
			->setCellValue('D13', "Boleh membina hubungan baik, dan bekerjasama dengan anggota lain untuk mencapai objektif yang sama dan memerlukan sedikit penambahbaikan.")
			->setCellValue('E13', 'Boleh membina hubungan baik, dan bekerjasama dengan anggota lain untuk mencapai objektif yang sama.')
			->setCellValue('F13', 'Mempamerkan bukti jelas kebolehan membina hubungan baik dan bekerjasama dengan anggota kumpulan secara berkesan dalam mencapai objektif.')
			
			;
	}
	
	public function topHeaderAcara(){
		$this->sheet->getRowDimension('15')->setRowHeight(25.5);
		$this->sheet->mergeCells('C15:D15');
		
		//BORDER
		$arr = [
		'B15', 'C15:D15',  'E15', 'F15'
		];

		foreach($arr as $a){
			$this->sheet->getStyle($a)->applyFromArray($this->border);
			
			//ALIGNMENT
			$this->sheet->getStyle($a)
			->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
			$this->sheet->getStyle($a)
			->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)
			->setWrapText(true);
		}
		
		$this->sheet->getStyle('B15:F15')->applyFromArray($this->bold);

		
		//STYLE

		$this->sheet
			->getStyle('B15:F15')->getFill()
			->setFillType(Fill::FILL_SOLID)
			->getStartColor()->setARGB($this->bgcolor_blue);
		
			
		//CONTENT
		$this->sheet
			->setCellValue('B15', 'NO.MATRIK')
			->setCellValue('C15', "NAMA PELAJAR")
			->setCellValue('E15', "Pengetahuan Kepimpinan\n(Markah: 1-5)")
			->setCellValue('F15', "Membina Hubungan Baik\n(Markah: 1-5)")
			;
	}
	
	public function startRefSheet(){
		$this->spreadsheet->createSheet();
		$this->spreadsheet->setActiveSheetIndex(3);
		$this->spreadsheet->getActiveSheet()->setTitle('REF');
		$this->sheet = $this->spreadsheet->getActiveSheet();
	}
	
	public function setColumWidthRef(){
		$normal = 10.2;//9.43
		$this->sheet->getColumnDimension('A')->setWidth(13);
		$this->sheet->getColumnDimension('B')->setWidth(8);
		$this->sheet->getColumnDimension('C')->setWidth(7);
		$this->sheet->getColumnDimension('D')->setWidth(9);
		$this->sheet->getColumnDimension('E')->setWidth(27);
	}
	
	public function gradeTable(){
		$this->sheet->mergeCells('D1:E1');
		//BORDER
		$col1 = [
		'A', 'B'
		];
		$row1 = [1,2,3,4,5,6,7,8,9,10,11,12];
		
		foreach($col1 as $c1){
			foreach($row1 as $r1){
				$this->sheet->getStyle($c1 . $r1)->applyFromArray($this->border);
			}
		}
		
		$col1 = [
		'D', 'E'
		];
		$row1 = [1,2,3,4,5,6];
		
		foreach($col1 as $c1){
			foreach($row1 as $r1){
				$this->sheet->getStyle($c1 . $r1)->applyFromArray($this->border);
			}
		}
		
		
		
		$this->sheet->getStyle('A1:B1')->applyFromArray($this->fontWhite);
		$this->sheet->getStyle('D1:E1')->applyFromArray($this->fontWhite);
		
		$this->sheet->getStyle('A2:E12')->applyFromArray($this->normal);
		
		$this->sheet->getStyle('A1:E12')
			->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)
			->setWrapText(true);

		//STYLE

		$this->sheet
			->getStyle('A1:B1')->getFill()
			->setFillType(Fill::FILL_SOLID)
			->getStartColor()->setARGB('FF000000');
		$this->sheet
			->getStyle('D1:E1')->getFill()
			->setFillType(Fill::FILL_SOLID)
			->getStartColor()->setARGB('FF000000');
		
			
		//CONTENT
		$this->sheet
			->setCellValue('A1', 'BERMULA')->setCellValue('B1', 'GRED')
			->setCellValue('A2', 0)->setCellValue('B2', 'F')
			->setCellValue('A3', 40)->setCellValue('B3', 'D')
			->setCellValue('A4', 45)->setCellValue('B4', 'C-')
			->setCellValue('A5', 50)->setCellValue('B5', 'C')
			->setCellValue('A6', 55)->setCellValue('B6', 'C+')
			->setCellValue('A7', 60)->setCellValue('B7', 'B-')
			->setCellValue('A8', 65)->setCellValue('B8', 'B')
			->setCellValue('A9', 70)->setCellValue('B9', 'B+')
			->setCellValue('A10', 75)->setCellValue('B10', 'A-')
			->setCellValue('A11', 80)->setCellValue('B11', 'A')
			->setCellValue('A12', 90)->setCellValue('B12', 'A+')
			
			->setCellValue('D1', 'CLO ACHIEVEMENT ANALYSIS')
			
			->setCellValue('D2', 0)->setCellValue('E2', 'Sangat Lemah/ Very Poor')
			->setCellValue('D3', 1)->setCellValue('E3', 'Lemah/ Poor')
			->setCellValue('D4', 2)->setCellValue('E4', 'Baik/ Good')
			->setCellValue('D5', 3)->setCellValue('E5', 'Sangat Baik/ Very Good')
			->setCellValue('D6', 3.7)->setCellValue('E6', 'Cemerlang/ Excellent')
			//
			;
	}
	
	public function setMarkahActive(){
		$this->spreadsheet->setActiveSheetIndex(0);
		$this->sheet = $this->spreadsheet->getActiveSheet();
	}
	
	public function setProtection(){
		$pass = 'efasi123';
		$this->spreadsheet->setActiveSheetIndex(0);
		$this->sheet = $this->spreadsheet->getActiveSheet();
		$this->sheet->getStyle('A1')->applyFromArray($this->normal);
		$this->sheet->getProtection()
			->setPassword($pass)
			->setSheet(true);
		///
		
		
		$this->spreadsheet->setActiveSheetIndex(1);
		$this->sheet = $this->spreadsheet->getActiveSheet();
		$this->sheet->getStyle('E16:F'.$this->lastRow)->getProtection()->setLocked(Protection::PROTECTION_UNPROTECTED);
		$this->sheet->getProtection()
			->setPassword($pass)
			->setSheet(true);
		$this->sheet->getStyle('A1')->applyFromArray($this->normal);
			
		$this->spreadsheet->setActiveSheetIndex(2);
		$this->sheet = $this->spreadsheet->getActiveSheet();
		$this->sheet->getStyle('E16:F'.$this->lastRow)->getProtection()->setLocked(Protection::PROTECTION_UNPROTECTED);
		$this->sheet->getProtection()
			->setPassword($pass)
			->setSheet(true);
		$this->sheet->getStyle('A1')->applyFromArray($this->normal);
		
		$this->spreadsheet->setActiveSheetIndex(3);
		$this->sheet = $this->spreadsheet->getActiveSheet();
		$this->sheet->getProtection()
			->setPassword($pass)
			->setSheet(true);
	}
	
	
	
	public function generate(){
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$this->spreadsheet->setActiveSheetIndex(0);
		
		// Redirect output to a client’s web browser (Xls)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $this->courseCode . ' ' . $this->courseName .'.xls"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
		header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header('Pragma: public'); // HTTP/1.0

		$writer = IOFactory::createWriter($this->spreadsheet, 'Xls');
		$writer->setPreCalculateFormulas(FALSE);
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
