<?php
App::uses('AppController', 'Controller');
class ExcelTestsController extends AppController{
	public $uses = ['Combo'];
	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow();
	}
	public function import(){
		
	}
	public function export(){
		set_time_limit(0);
		$title = ['序号', '商品', '价格'];
		App::import('Vendor','PHPExcel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
		->setLastModifiedBy("Maarten Balliauw")
		->setTitle("Office 2007 XLSX Test Document")
		->setSubject("Office 2007 XLSX Test Document")
		->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
		->setKeywords("office 2007 openxml php")
		->setCategory("Test result file");
		// 		$objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
		//select column_name from information_schema.COLUMNS where table_name='combos'
		$header = ['A', 'B','C'];
		
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A1', $title[0])
		->setCellValue('B1', $title[1])
		->setCellValue('C1', $title[2]);
		
		$page = 1;
		$limt = 500;
		$combos = $this->Combo->find('all', ['page'=>$page, 'limit'=>$limt]);
		$tempCount = 0;
		foreach ($combos as $key => $item){
			$tempCount ++;
			$index = $key+2;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$index, $item['Combo']['id']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$index, $item['Combo']['combo']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$index, $item['Combo']['eprice']);
		}
		
		//     	die;
		$objPHPExcel->getActiveSheet()->setTitle('Records');
		
		
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		
		ob_end_clean();//清除缓冲区,避免乱码
		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header("Content-Disposition: attachment;filename=\"考试统计.xls\"");//这个标题应该从数据库去数据进行组装
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		//header('Cache-Control: max-age=1');
		
		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		//     	var_dump($questionnaire[2]);die;
		
	}
}