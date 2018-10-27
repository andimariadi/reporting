<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Json extends CI_Controller {

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
	}

	public function index ($page = 'Homepage') {
		$data['title'] = $page;
		$this->load->view('templates/head', $data);
		$this->load->view('pages/home');
	}

	public function report($last_biling = '', $shift = '') {
		$this->load->helper('penghitungan_helper');
		if ($last_biling != '' AND $shift != '') {
			$last_biling = $last_biling;
			$shift = $shift;	
		} elseif($last_biling != '' AND $shift == '') {
			$last_biling = $last_biling;
			if ((date('H:i:s') >= '07:30:00') AND (date('H:i:s') <= '18:30:00')) {
				$shift = 1;
			} elseif((date('H:i:s') > '18:30:00') AND (date('H:i:s') <= '23:59:59')) {
				$shift = 2;
			} else {
				$shift = 2;
			}
		} else {
			if ((date('H:i:s') >= '07:30:00') AND (date('H:i:s') <= '18:30:00')) {
				$shift = 1;
				$last_biling = date('Y-m-d');
			} elseif((date('H:i:s') > '18:30:00') AND (date('H:i:s') <= '23:59:59')) {
				$shift = 2;
				$last_biling = date('Y-m-d');
			} else {
				$shift = 2;
				$last_biling = date('Y-m-d', strtotime('-1 days'));
			}
		}
		$last_jigsaw = $this->Crud->sql_query("SELECT `report`.`id` as `id`, `date`, `shift`, `unit_id`, `report`.`location`, `time_problem`, `start_waiting`, `end_waiting`, `start_action`, `end_action`, `bd_receiver`, `rfu_receiver`, `report`.`status`, `enum`.`name` as `bd_type`, `prob`.`name` as `problem`, `category`.`name` as `category`, `analysis`.`name` as `analysis`, `cause`.`name` as `cause`, `activity`.`name` as `activity`, `remark`.`name` as `remark`, GROUP_CONCAT(`user`.`name` SEPARATOR ', ') as `pic`, `other`, `type`.`name` as `type` FROM `report` LEFT JOIN `enum` ON `report`.`bd_type` = `enum`.`id` LEFT JOIN `enum` as `prob` ON `report`.`problem` = `prob`.`id` LEFT JOIN `enum` as `category` ON `report`.`category` = `category`.`id` LEFT JOIN `enum` as `analysis` ON `report`.`analysis` = `analysis`.`id` LEFT JOIN `enum` as `cause` ON `report`.`cause` = `cause`.`id` LEFT JOIN `enum` as `activity` ON `report`.`activity` = `activity`.`id` LEFT JOIN `enum` as `remark` ON `report`.`remark` = `remark`.`id` LEFT JOIN `pic_report` ON `report`.`id` = `pic_report`.`report_id` LEFT JOIN `user` ON `pic_report`.`user_id` = `user`.`id` LEFT JOIN `unit` ON `report`.`unit_id` = `unit`.`id` LEFT JOIN `enum` as `type` ON `unit`.`code_unit` = `type`.`id` WHERE `report`.`device_id` = 1 AND `date` = '{$last_biling}' AND `shift` = '{$shift}' GROUP BY `pic_report`.`report_id`");

		$last_network = $this->Crud->sql_query("SELECT `report`.`id` as `id`, `date`, `shift`, `unit_id`, `report`.`location`, `time_problem`, `start_waiting`, `end_waiting`, `start_action`, `end_action`, `bd_receiver`, `rfu_receiver`, `report`.`status`, `enum`.`name` as `bd_type`, `prob`.`name` as `problem`, `category`.`name` as `category`, `analysis`.`name` as `analysis`, `cause`.`name` as `cause`, `activity`.`name` as `activity`, `remark`.`name` as `remark`, GROUP_CONCAT(`user`.`name` SEPARATOR ', ') as `pic`, `other`, `type`.`name` as `type` FROM `report` LEFT JOIN `enum` ON `report`.`bd_type` = `enum`.`id` LEFT JOIN `enum` as `prob` ON `report`.`problem` = `prob`.`id` LEFT JOIN `enum` as `category` ON `report`.`category` = `category`.`id` LEFT JOIN `enum` as `analysis` ON `report`.`analysis` = `analysis`.`id` LEFT JOIN `enum` as `cause` ON `report`.`cause` = `cause`.`id` LEFT JOIN `enum` as `activity` ON `report`.`activity` = `activity`.`id` LEFT JOIN `enum` as `remark` ON `report`.`remark` = `remark`.`id` LEFT JOIN `pic_report` ON `report`.`id` = `pic_report`.`report_id` LEFT JOIN `user` ON `pic_report`.`user_id` = `user`.`id` LEFT JOIN `unit` ON `report`.`unit_id` = `unit`.`id` LEFT JOIN `enum` as `type` ON `unit`.`code_unit` = `type`.`id` WHERE `report`.`device_id` = 2 AND `date` = '{$last_biling}' AND `shift` = '{$shift}' GROUP BY `pic_report`.`report_id`");
		$response = array();
		$response["date"]=$last_biling;
		$response["shift"]=$shift;
		if($last_jigsaw->num_rows() > 0 || $last_network->num_rows() > 0){
		  $response["jigsaw"] = array();
		  $no = 0;
		  foreach ($last_jigsaw->result_array() as $x) {
		  	if ($x['status'] == 0) {
		  		$status = 'RFU';
		  	} else {
		  		$status = 'Not RFU';
		  	}
		  	$no++;
		    $h['no'] = $no;
		    $h['date'] = $x["date"];
		    $h['unit_id'] = $x["unit_id"];
		    $h['type'] = $x["type"];
		    $h['problem'] = $x["problem"];
		    $h['activity'] = $x["activity"];
		    $h['duration'] = selisih($x['start_action'], $x['end_action']);
		    $h['pic'] = $x["pic"];
		    $h['status'] = $status;
		    array_push($response["jigsaw"], $h);
		  }
		  $response["network"] = array();
		  $no = 0;
		  foreach ($last_network->result_array() as $x) {
		  	if ($x['status'] == 0) {
		  		$status = 'RFU';
		  	} else {
		  		$status = 'Not RFU';
		  	}
		  	$no++;
		    $h['no'] = $no;
		    $h['date'] = $x["date"];
		    $h['unit_id'] = $x["unit_id"];
		    $h['type'] = $x["type"];
		    $h['problem'] = $x["problem"];
		    $h['activity'] = $x["activity"];
		    $h['duration'] = selisih($x['start_action'], $x['end_action']);
		    $h['pic'] = $x["pic"];
		    $h['status'] = $status;
		    array_push($response["network"], $h);
			}
		}else {
		  $response["data"]="empty";
		}
		echo json_encode($response);
	}

	public function summary($unit='')
	{
		$unit = $unit != '' ? str_replace('_', ' ', ($unit)) : 'D3-006';
		$this->load->helper('penghitungan_helper');
		$sql = $this->Crud->sql_query("SELECT `report`.`id` as `id`, `date`, `shift`, `unit_id`, `location`, `time_problem`, `start_waiting`, `end_waiting`, `start_action`, `end_action`, `bd_receiver`, `rfu_receiver`, `status`, `enum`.`name` as `bd_type`, `prob`.`name` as `problem`, `category`.`name` as `category`, `analysis`.`name` as `analysis`, `cause`.`name` as `cause`, `activity`.`name` as `activity`, `remark`.`name` as `remark`, GROUP_CONCAT(`user`.`name` SEPARATOR ', ') as `pic`,(SELECT GROUP_CONCAT(DISTINCT `backlog_name` SEPARATOR '<br /> - ') as `backlog` FROM (SELECT `backlog`.`id`, `unit_id`,`backlog`.`backlog`, (SELECT `value` FROM `backlog` as a where a.unit_id = `backlog`.`unit_id` AND a.backlog = `backlog`.`backlog` ORDER BY `id` DESC LIMIT 1) as `value`, `enum`.`name` as `backlog_name`, `date` FROM `backlog` LEFT JOIN `enum` ON `backlog`.`backlog` = `enum`.`id`) as A WHERE `unit_id` = `report`.`unit_id` AND `value`= 0 AND `date` <= `report`.`date` GROUP BY `unit_id`) as `backlog`, `other` FROM `report` LEFT JOIN `enum` ON `report`.`bd_type` = `enum`.`id` LEFT JOIN `enum` as `prob` ON `report`.`problem` = `prob`.`id` LEFT JOIN `enum` as `category` ON `report`.`category` = `category`.`id` LEFT JOIN `enum` as `analysis` ON `report`.`analysis` = `analysis`.`id` LEFT JOIN `enum` as `cause` ON `report`.`cause` = `cause`.`id` LEFT JOIN `enum` as `activity` ON `report`.`activity` = `activity`.`id` LEFT JOIN `enum` as `remark` ON `report`.`remark` = `remark`.`id` LEFT JOIN `pic_report` ON `report`.`id` = `pic_report`.`report_id` LEFT JOIN `user` ON `pic_report`.`user_id` = `user`.`id` WHERE `report`.`unit_id` = '{$unit}' GROUP BY `pic_report`.`report_id`  ORDER BY `report`.`date` DESC LIMIT 20");
		if($sql->num_rows() > 0){
		  $response = array();
		  $response["data"] = array();
		  $no = 0;
		  foreach ($sql->result_array() as $x) {
		  	$no++;
		    $h['no'] = $no;
		    $h['date'] = $x['date'];
		    $h['shift'] = $x['shift'];
		    $h['unit_id'] = $x["unit_id"];
		    $h['problem'] = $x["problem"];
		    $h['activity'] = $x["activity"];
		    $h['duration'] = selisih($x['start_action'], $x['end_action']);
		    $h['pic'] = $x["pic"];
		    array_push($response["data"], $h);
		  }
		}else {
		  $response["data"]="empty";  
		}
		echo json_encode($response);		
	}

	public function detail($unit='')
	{
		$unit = $unit != '' ? str_replace('_', ' ', ($unit)) : 'D3-006';
		$this->load->helper('penghitungan_helper');
		$sql = $this->Crud->sql_query("SELECT `unit`.*, `ser`.`name` as `series_name`, `type`.`name` as `type_name`, `cod`.`name` as `code_name`, `ant`.`name` as `antenna_name`, `power`.`name` as `poweroff_name`
			, (SELECT GROUP_CONCAT(DISTINCT `backlog_name` SEPARATOR ', ') as `backlog` FROM (SELECT `backlog`.`id`, `unit_id`,`backlog`.`backlog`, (SELECT `value` FROM `backlog` as a where a.unit_id = `backlog`.`unit_id` AND a.backlog = `backlog`.`backlog` ORDER BY `id` DESC LIMIT 1) as `value`, `enum`.`name` as `backlog_name`, `date` FROM `backlog` LEFT JOIN `enum` ON `backlog`.`backlog` = `enum`.`id`) as A WHERE `unit_id` = `unit`.`id` AND `value`= 0 AND `date` <= '" . date('Y-m-d') . "' GROUP BY `unit_id`) as `backlog`
		 FROM `unit` LEFT JOIN `enum` as `ser` ON `unit`.`series` = `ser`.`id` LEFT JOIN `enum` as `type` ON `unit`.`type` = `type`.`id` LEFT JOIN `enum` as `cod` ON `unit`.`code_unit` = `cod`.`id` LEFT JOIN `enum` as `ant` ON `unit`.`antenna` = `ant`.`id`
			LEFT JOIN `enum` as `power` ON `unit`.`poweroff` = `power`.`id`
		 WHERE `unit`.`id` = '{$unit}'");
		if($sql->num_rows() > 0){
		  $response = array();
		  $response["data"] = array();
		  foreach ($sql->result_array() as $x) {
		  	$battery = empty(explode(';', $x['explode'])[1]) ? null : explode(';', $x['explode'])[1];
		  	if ($x['status'] == 0) {
		  		$status = 'Installed';
		  	} else {
		  		$status = 'Uninstall';
		  	}
		  	if ($x['locked'] == 1) {
		  		$locked = 'Locked';
		  	} else {
		  		$locked = 'Not Locked';
		  	}
			$h['id'] 	= $x['id'];
			$h['series_name'] 	= $x['series_name'];
			$h['type_name'] 	= $x['type_name'];
			$h['code_name'] 	= $x['code_name'];
			$h['description'] 	= $x['description'];
			$h['position'] 	= $x['position'];
			$h['location'] 	= $x['location'];
			$h['sn_display'] 	= $x['sn_display'];
			$h['sn_wb'] 	= $x['sn_wb'];
			$h['sn_gps'] 	= $x['sn_gps'];
			$h['antenna_name'] 	= $x['antenna_name'];
			$h['backlog'] 	= $x['backlog'];
			$h['poweroff_name'] = $x['poweroff_name'];
			$h['status'] 	= $status;
			$h['locked'] 	= $locked;
			$h['device_id'] = $x['device_id'];
			$h['battery'] = $battery;
		    array_push($response["data"], $h);
		  }
		}else {
		  $response["data"]="empty";  
		}
		echo json_encode($response);		
	}
}
