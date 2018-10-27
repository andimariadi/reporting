<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class exports extends CI_Controller {

/**
* Index Page for this controller.
*
* Maps to the following URL
* 		http://example.com/index.php/welcome
*	- or -
* 		http://example.com/index.php/welcome/index
*	- or -
* Since this controller is set as the default controller in
* config/routes.php, it's displayed at http://example.com/
*
* So any other public methods not prefixed with an underscore will
* map to /index.php/welcome/<method_name>
* @see https://codeigniter.com/user_guide/general/urls.html
*/
function __construct() {
	parent::__construct();
	$this->load->model('Crud');
	$username 	= $this->session->userdata('username');
	$level 		= $this->session->userdata('level');
	if(empty($username)){
		redirect(base_url("Auth"));
	}
	if($level == 'teknisi'){
		redirect(base_url("report"));
	}
	$this->load->helper('Penghitungan_helper');
}

public function index() {

}

public function report($dev='', $year = '', $mount = '') {
	$dev = $dev == '' ? null : $dev;
	$y = $year == '' ? null : $year;
	$m = $mount == '' ? null : $mount;
	/** Error reporting */
	error_reporting(E_ALL);
	ini_set('display_errors', TRUE);
	ini_set('display_startup_errors', TRUE);
	date_default_timezone_set('Europe/London');

	if (PHP_SAPI == 'cli')
		die('This example should only be run from a Web Browser');

	$this->load->library('Excel');

	$objPHPExcel = new PHPExcel();

	$objPHPExcel->getProperties()->setCreator("Andi Mariadi")
	->setLastModifiedBy("Andi Mariadi")
	->setTitle("Office 2007 XLSX Test Document")
	->setSubject("Office 2007 XLSX Test Document")
	->setDescription("This document for Office 2007 XLSX, generated using PHP classes.")
	->setKeywords("office 2007 openxml php")
	->setCategory("Result file");

	$objDrawing = new PHPExcel_Worksheet_Drawing();
	$objDrawing->setName('Logo ');
	$objDrawing->setDescription('Logo ');

	if ($dev == 'jigsaw') {
		$objDrawing->setPath('___/images/report_jigsaw.png');
		$fillbor = '0561a3';
		$fillanu = '0070c0';
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:W4');
	} else {
		$objDrawing->setPath('___/images/report_network.png');
		$fillbor = 'ff0000';
		$fillanu = 'ff5050';
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:Q4');
	}

	$objDrawing->setResizeProportional(true);
	$objDrawing->setHeight(79);
	$objDrawing->setCoordinates('B1');
	$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

	$border = array('fill' => array('borders' => array(
		'right'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN)
	)));
	$bordering = array('fill' 	=> array(
		'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
		'color'		=> array('rgb' => $fillbor)
	),
		'font' => array(
			'size'  => 12,
			'name'  => 'Times New Roman',
			'color' => array('rgb' => 'ffffff')
		),
		'borders' => array(
			'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
			'left'	=> array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
			'top'	=> array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
			'right'		=> array('style' => PHPExcel_Style_Border::BORDER_MEDIUM)
		),
		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
		)
	);
	$styleArray = array(
		'borders' => array(
			'allborders' => array(
				'style' => PHPExcel_Style_Border::BORDER_THIN
			)
		)
	);

	$tebal = array(
		'borders' => array(
			'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_MEDIUM)
		)
	);

	$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray(
		array('fill' 	=> array(
			'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
			'color'		=> array('rgb' => $fillanu)
		)
	)
	);


	$objPHPExcel->getActiveSheet()->getStyle('A5:' . $objPHPExcel->getActiveSheet()->getHighestColumn() . $objPHPExcel->getActiveSheet()->getHighestRow())->applyFromArray($styleArray);

	$alphas = range('A', 'Z');
	if ($dev == 'jigsaw') {
		$objPHPExcel->getActiveSheet()->getStyle('A5:W5')->applyFromArray($bordering);
		$td = array('No', 'Date', 'Shift', 'CN Jigsaw', 'Type', 'BD Type', 'Problem', 'Work Location', 'Time First Problem', 'Start Waiting', 'End Waiting', 'Duration Waiting', 'Problem Analysis', 'Cause Of Problem', 'Corrective Action', 'Start Action', 'End Action', 'Duration Action', 'BD Reciever', 'RFU Reciever', 'PIC', 'Status', 'Remarks');
		$forv = 23;
	} else {
		$objPHPExcel->getActiveSheet()->getStyle('A5:Q5')->applyFromArray($bordering);
		$td = array('No', 'Date', 'Shift', 'CN Unit', 'Detail Problem Analysis', 'Category', 'Work Location', 'Time First Problem', 'Corrective Action', 'Start Action',' End Action','Duration', 'BD Reciever', 'RFU Reviever', 'PIC', 'Remarks', 'Status');
		$forv = 17;
	}

	for ($i=0; $i < $forv ; $i++) { 
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[$i] . '5', $td[$i]);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$i] . '5')->getAlignment()->setWrapText(true); 
	}

	if ($dev == 'jigsaw') {
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(4.29);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(16.57);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(7);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(17.86);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(35);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(9.86);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(60);
		$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(35);
		$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(42);
		$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(16.57);
		$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(16.57);
		$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(14.00);
		$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(200);
	} else {
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(4.29);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(16.57);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(6.29);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(14.71);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(32.86);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(13.71);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(18);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10.57);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(36.43);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(7.86);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(7.86);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(14.71);
		$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(17.43);
		$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(20.71);
		$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(131.43);
		$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(14.43);
	}
	$objPHPExcel->getActiveSheet()->getRowDimension('5')->setRowHeight(40);


	$cdev = $this->Crud->query("SELECT `id` FROM `device` WHERE `name`='{$dev}'");
	$devid = $cdev[0]['id'];
	if (isset($y) OR isset($m)) {
		$year = empty($y) ? null : $y;
		$month = empty($m) ? null : $m;
		$sss = "SELECT `date` FROM `report` WHERE `device_id`='{$devid}' AND YEAR(`date`)='{$year}' AND MONTH(`date`)='{$month}' GROUP BY `date`";
		$sql = $this->Crud->query($sss);
		$hitung = 5;
		foreach ($sql as $value) {
			$no = 0;
			$ss = "SELECT 
				`date`,
				`shift`,
				`unit_id`,
				`report`.`location`,
				`time_problem`,
				`start_waiting`,
				`end_waiting`,
				`start_action`,
				`end_action`,
				`bd_receiver`,
				`rfu_receiver`,
				`report`.`status`,
				`enum`.`name` as `bd_type`,
				`prob`.`name` as `problem`,
				`category`.`name` as `category`,
				`analysis`.`name` as `analysis`,
				`cause`.`name` as `cause`,
				`activity`.`name` as `activity`,
				`remark`.`name` as `remark`,
				GROUP_CONCAT(`user`.`name` SEPARATOR ', ') as `pic`,
				`other`
				FROM `report`
				LEFT JOIN `unit` ON `report`.`unit_id` = `unit`.`id`
				LEFT JOIN `enum` ON `report`.`bd_type` = `enum`.`id` LEFT JOIN `enum` as `prob` ON `report`.`problem` = `prob`.`id` 
				LEFT JOIN `enum` as `category` ON `unit`.`code_unit` = `category`.`id` 
				LEFT JOIN `enum` as `analysis` ON `report`.`analysis` = `analysis`.`id` 
				LEFT JOIN `enum` as `cause` ON `report`.`cause` = `cause`.`id` 
				LEFT JOIN `enum` as `activity` ON `report`.`activity` = `activity`.`id` LEFT JOIN `enum` as `remark` ON `report`.`remark` = `remark`.`id` LEFT JOIN `pic_report` ON `report`.`id` = `pic_report`.`report_id` LEFT JOIN `user` ON `pic_report`.`user_id` = `user`.`id` WHERE `report`.`device_id` = '{$devid}' AND `report`.`date`='" . $value['date'] . "' GROUP BY `pic_report`.`report_id` ORDER BY `shift`,
				`start_action` ASC";

			$sqla = $this->Crud->query($ss);
			$end = count($sqla);
			foreach ($sqla as $data) {
				$no++;
				$hitung++;
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[0] . $hitung, $no);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[1] . $hitung, $data['date']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[2] . $hitung, $data['shift']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[3] . $hitung, $data['unit_id']);

				if ($devid == 1) {
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[4] . $hitung, $data['category']);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[5] . $hitung, $data['bd_type']);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[6] . $hitung, $data['problem']);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[7] . $hitung, $data['location']);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[8] . $hitung, $data['time_problem']);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[9] . $hitung, $data['start_waiting']);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[10] . $hitung, $data['end_waiting']);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[11] . $hitung, selisih($data['start_waiting'],$data['end_waiting']));
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[12] . $hitung, $data['analysis']);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[13] . $hitung, $data['cause']);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[14] . $hitung, $data['activity']);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[15] . $hitung, $data['start_action']);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[16] . $hitung, $data['end_action']);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[17] . $hitung, selisih($data['start_action'],$data['end_action']));
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[18] . $hitung, $data['bd_receiver']);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[19] . $hitung, $data['rfu_receiver']);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[20] . $hitung, $data['pic']);
					$status = $data['status'] == 1 ? 'Not RFU' : 'RFU';
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[21] . $hitung, $status);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[22] . $hitung, $data['remark']);
				} else {
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[4] . $hitung, $data['problem']);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[5] . $hitung, $data['category']);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[6] . $hitung, $data['location']);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[7] . $hitung, $data['time_problem']);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[8] . $hitung, $data['activity']);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[9] . $hitung, $data['start_action']);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[10] . $hitung, $data['end_action']);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[11] . $hitung, selisih($data['start_action'],$data['end_action']));
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[12] . $hitung, $data['bd_receiver']);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[13] . $hitung, $data['rfu_receiver']);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[14] . $hitung, $data['pic']);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[15] . $hitung, $data['remark']);
					$status = $data['status'] == 1 ? 'Not RFU' : 'RFU';
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[16] . $hitung, $status);
				}
				for ($i=1, $a = 0; $i < $forv; $i++, $a++) { 
					$objPHPExcel->getActiveSheet()->getStyle($alphas[$a] . $hitung . ':' . $objPHPExcel->getActiveSheet()->getHighestColumn() . $objPHPExcel->getActiveSheet()->getHighestRow())->applyFromArray($styleArray);							
				}

			}
			$objPHPExcel->getActiveSheet()->getStyle("A{$hitung}:Q{$hitung}")->applyFromArray($tebal);
		}
	}



	$objPHPExcel->getActiveSheet()->setTitle('Activity ' . ucfirst($dev));

	$objPHPExcel->setActiveSheetIndex(0);
	// header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="ADMO MDI ' . $year . '_Report ' . date('F', strtotime('01-' . $mount . '-' . $year)) . ' Daily Activity ' . ucfirst($dev) . '.xls"');
	header('Cache-Control: max-age=0');
	header('Cache-Control: max-age=1');

	header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
	header ('Cache-Control: cache, must-revalidate');
	header ('Pragma: public');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');

	exit;
}


}
?>