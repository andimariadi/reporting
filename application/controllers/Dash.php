<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dash extends CI_Controller {

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
		$page 		= 'Dashboard';

		if ($level == 'teknisi') {
			redirect(base_url('report'));
		} elseif (!$level) {
			redirect(base_url('Auth'));
		}

		/*$src = $this->Crud->search('user', array('username' => $username))->row_array();
		if (date('Y-m-d H:i:s') >= $src['last_login']) {
			$this->session->set_flashdata('msg', '<b>Error!</b>. Session has expired! Please re-login :)');
			redirect(base_url('Auth/logout/session'));
		} else {
			$this->Crud->update('user', array('username' => $username), array('last_login' => date('Y-m-d H:i:s', strtotime('+ 10 minutes'))));
		}*/
	}

	public function index()
	{
		if ((date('H:i:s') >= '07:00:00') AND (date('H:i:s') <= '18:00:00')) {
			$shift = 1;
			$last_biling = date('Y-m-d');
		} elseif((date('H:i:s') > '18:00:00') AND (date('H:i:s') <= '23:59:59')) {
			$shift = 2;
			$last_biling = date('Y-m-d');
		} else {
			$shift = 2;
			$last_biling = date('Y-m-d', strtotime('-1 days'));
		}

		$this->load->view('templates/head', array('title' => 'ReportingMDI | Dashboard'));
		$data = $this->Crud->query("SELECT `name` ,COUNT(IF(`device_id` = '1', `report_id`, NULL)) AS 'jigsaw',COUNT(IF(`device_id` = '2', `report_id`, NULL)) AS 'network'FROM (SELECT `user`.`id`,`user`.`name`, `pic_report`.`report_id`, `report`.`device_id` FROM `user` LEFT JOIN `enum` as `level` ON `user`.`level` = `level`.`id` LEFT JOIN `pic_report` ON `user`.`id` = `pic_report`.`user_id` LEFT JOIN `report` ON `pic_report`.`report_id` = `report`.`id` WHERE `level`.`name` = 'man power' AND YEAR(`date`) = '" . date('Y') . "' AND MONTH(`date`) = '" . date('m') . "' GROUP BY `user`.`id`,`date`, `shift`, `unit_id`, `bd_type`, `problem`, `category`,`analysis`,`cause`, `start_waiting`, `end_waiting`, `start_action`, `end_action` ) a GROUP BY `id`");
		$count = $this->Crud->query("SELECT
		SUM(`Jigsaw`) as `Jigsaw`,
		SUM(`Network`) as `Network`
		FROM (
		    SELECT 
		IF( `device_id` = '1', COUNT(`id`), 0) AS 'Jigsaw',
		IF( `device_id` = '2', COUNT(`id`), 0) AS 'Network',
		    COUNT(`id`) as `average`
		FROM `report`
		WHERE YEAR(`date`) = '" . date('Y') . "' AND MONTH(`date`) = '" . date('m') . "'
		GROUP BY `date`, `shift`, `unit_id`, `bd_type`, `problem`, `category`,`analysis`,`cause`, `start_waiting`, `end_waiting`, `start_action`, `end_action`) a");
		$total_unit = $this->Crud->query("SELECT COUNT(*) as `count` FROM `unit` WHERE `status` = 0");
		$last_jigsaw = $this->Crud->query("SELECT `report`.`id` as `id`, `date`, `shift`, `unit_id`, `report`.`location`, `time_problem`, `start_waiting`, `end_waiting`, `start_action`, `end_action`, `bd_receiver`, `rfu_receiver`, `report`.`status`, `enum`.`name` as `bd_type`, `prob`.`name` as `problem`, `category`.`name` as `category`, `analysis`.`name` as `analysis`, `cause`.`name` as `cause`, `activity`.`name` as `activity`, `remark`.`name` as `remark`, GROUP_CONCAT(`user`.`name` SEPARATOR ', ') as `pic`, `other`, `type`.`name` as `type` FROM `report` LEFT JOIN `enum` ON `report`.`bd_type` = `enum`.`id` LEFT JOIN `enum` as `prob` ON `report`.`problem` = `prob`.`id` LEFT JOIN `enum` as `category` ON `report`.`category` = `category`.`id` LEFT JOIN `enum` as `analysis` ON `report`.`analysis` = `analysis`.`id` LEFT JOIN `enum` as `cause` ON `report`.`cause` = `cause`.`id` LEFT JOIN `enum` as `activity` ON `report`.`activity` = `activity`.`id` LEFT JOIN `enum` as `remark` ON `report`.`remark` = `remark`.`id` LEFT JOIN `pic_report` ON `report`.`id` = `pic_report`.`report_id` LEFT JOIN `user` ON `pic_report`.`user_id` = `user`.`id` LEFT JOIN `unit` ON `report`.`unit_id` = `unit`.`id` LEFT JOIN `enum` as `type` ON `unit`.`code_unit` = `type`.`id` WHERE `report`.`device_id` = 1 AND `date` = '{$last_biling}' AND `shift` = '{$shift}' GROUP BY `pic_report`.`report_id`");

		$last_network = $this->Crud->query("SELECT `report`.`id` as `id`, `date`, `shift`, `unit_id`, `report`.`location`, `time_problem`, `start_waiting`, `end_waiting`, `start_action`, `end_action`, `bd_receiver`, `rfu_receiver`, `report`.`status`, `enum`.`name` as `bd_type`, `prob`.`name` as `problem`, `category`.`name` as `category`, `analysis`.`name` as `analysis`, `cause`.`name` as `cause`, `activity`.`name` as `activity`, `remark`.`name` as `remark`, GROUP_CONCAT(`user`.`name` SEPARATOR ', ') as `pic`, `other`, `type`.`name` as `type` FROM `report` LEFT JOIN `enum` ON `report`.`bd_type` = `enum`.`id` LEFT JOIN `enum` as `prob` ON `report`.`problem` = `prob`.`id` LEFT JOIN `enum` as `category` ON `report`.`category` = `category`.`id` LEFT JOIN `enum` as `analysis` ON `report`.`analysis` = `analysis`.`id` LEFT JOIN `enum` as `cause` ON `report`.`cause` = `cause`.`id` LEFT JOIN `enum` as `activity` ON `report`.`activity` = `activity`.`id` LEFT JOIN `enum` as `remark` ON `report`.`remark` = `remark`.`id` LEFT JOIN `pic_report` ON `report`.`id` = `pic_report`.`report_id` LEFT JOIN `user` ON `pic_report`.`user_id` = `user`.`id` LEFT JOIN `unit` ON `report`.`unit_id` = `unit`.`id` LEFT JOIN `enum` as `type` ON `unit`.`code_unit` = `type`.`id` WHERE `report`.`device_id` = 2 AND `date` = '{$last_biling}' AND `shift` = '{$shift}' GROUP BY `pic_report`.`report_id`");
		$data = array('employee' => $data, 
			'count' => $count, 
			'total_unit' => $total_unit[0]['count'], 
			'last_jigsaw' => $last_jigsaw,
			'last_network' => $last_network
		);
		$this->load->view('pages/home', $data);
	}

	public function device()
	{
		# start level #
		$level 		= $this->session->userdata('level');
		if ($level == 'report' || $level == 'man power') {redirect(base_url('Dash')); }
		# end for level #

		$this->load->view('templates/head', array('title' => 'ReportingMDI | Device'));
		$device = $this->Crud->query("SELECT `device`.`id`,`name`, COUNT(`report`.`id`) as `total` FROM `device` LEFT JOIN `report` ON `device`.`id` = `report`.`device_id` GROUP BY `device`.`id`");
		$data = array(
			'device' => $device
		);
		$this->load->view('pages/device', $data);
	}

	public function category()
	{
		# start level #
		$level 		= $this->session->userdata('level');
		if ($level == 'report' || $level == 'man power') {redirect(base_url('Dash')); }
		# end for level #

		$this->load->view('templates/head', array('title' => 'ReportingMDI | Category Report'));
		$category = $this->Crud->multijoinwhere('enum', array('device' => 'enum.device_id = device.id'),array('type' => 'category'), array('order' => 'enum.device_id', 'by' => 'asc'), array('enum.id','enum.name', 'device.name as device'))->result_array();
		$device = $this->Crud->query("SELECT * FROM `device` WHERE `id` != 3");
		$data = array(
			'category' => $category,
			'device' => $device
		);
		$this->load->view('pages/category', $data);
	}

	public function people()
	{
		# start level #
		$level 		= $this->session->userdata('level');
		if ($level == 'report' || $level == 'man power' || $level == 'administrator') {redirect(base_url('Dash')); }
		# end for level #

		$this->load->view('templates/head', array('title' => 'ReportingMDI | People'));
		$user = $this->Crud->multijoin("user", array('enum' => 'user.level = enum.id'), array('order' => 'user.username', 'by' => 'asc'), array('user.id', 'user.username', 'user.name', 'user.description', 'enum.name as level', 'user.last_login'))->result_array();
		$level = $this->Crud->search('enum', array('type' => 'level'))->result_array();
		$data = array(
			'user' => $user,
			'level' => $level
		);
		$this->load->view('pages/people', $data);
	}
	
	public function level()
	{
		# start level #
		$level 		= $this->session->userdata('level');
		if ($level == 'report' || $level == 'man power' || $level == 'administrator') {redirect(base_url('Dash')); }
		# end for level #

		$this->load->view('templates/head', array('title' => 'ReportingMDI | Level User'));
		$level = $this->Crud->search('enum', array('type' => 'level'))->result_array();
		$data = array(
			'level' => $level
		);
		$this->load->view('pages/level', $data);
	}

	public function periodic()
	{
		# start level #
		$level 		= $this->session->userdata('level');
		if ($level == 'report' || $level == 'man power') {redirect(base_url('Dash')); }
		# end for level #

		$this->load->view('templates/head', array('title' => 'ReportingMDI | Time Periodic'));
		$sql = $this->Crud->view('periodic_pm');
		$data = array(
			'data' => $sql
		);
		$this->load->view('pages/periodic', $data);
	}

	public function problem()
	{
		# start level #
		$level 		= $this->session->userdata('level');
		if ($level == 'report' || $level == 'man power') {redirect(base_url('Dash')); }
		# end for level #

		$this->load->view('templates/head', array('title' => 'ReportingMDI | Problem'));
		$device = $this->Crud->query("SELECT * FROM `device` WHERE `id` != 3");
		$data = array(
			'device' => $device
		);
		$this->load->view('pages/problem', $data);
	}

	public function analysis()
	{
		# start level #
		$level 		= $this->session->userdata('level');
		if ($level == 'report' || $level == 'man power') {redirect(base_url('Dash')); }
		# end for level #

		$this->load->view('templates/head', array('title' => 'ReportingMDI | Analysis'));
		$device = $this->Crud->query("SELECT * FROM `device` WHERE `id` != 3");
		$data = array(
			'device' => $device
		);
		$this->load->view('pages/analysis', $data);
	}

	public function cause()
	{
		# start level #
		$level 		= $this->session->userdata('level');
		if ($level == 'report' || $level == 'man power') {redirect(base_url('Dash')); }
		# end for level #

		$this->load->view('templates/head', array('title' => 'ReportingMDI | Cause By Problem'));
		$device = $this->Crud->query("SELECT * FROM `device` WHERE `id` != 3");
		$data = array(
			'device' => $device
		);
		$this->load->view('pages/cause', $data);
	}

	public function action()
	{
		# start level #
		$level 		= $this->session->userdata('level');
		if ($level == 'report' || $level == 'man power') {redirect(base_url('Dash')); }
		# end for level #

		$this->load->view('templates/head', array('title' => 'ReportingMDI | Action'));
		$device = $this->Crud->query("SELECT * FROM `device` WHERE `id` != 3");
		$data = array(
			'device' => $device
		);
		$this->load->view('pages/action', $data);
	}

	public function remark()
	{
		# start level #
		$level 		= $this->session->userdata('level');
		if ($level == 'report' || $level == 'man power') {redirect(base_url('Dash')); }
		# end for level #

		$this->load->view('templates/head', array('title' => 'ReportingMDI | Remark'));
		$device = $this->Crud->query("SELECT * FROM `device` WHERE `id` != 3");
		$data = array(
			'device' => $device
		);
		$this->load->view('pages/remark', $data);
	}

	public function backlog()
	{
		# start level #
		$level 		= $this->session->userdata('level');
		if ($level == 'report' || $level == 'man power') {redirect(base_url('Dash')); }
		# end for level #

		$this->load->view('templates/head', array('title' => 'ReportingMDI | Backlog'));
		$device = $this->Crud->query("SELECT * FROM `device` WHERE `id` != 3");
		$data = array(
			'device' => $device
		);
		$this->load->view('pages/backlog', $data);
	}

	public function other()
	{
		# start level #
		$level 		= $this->session->userdata('level');
		if ($level == 'report' || $level == 'man power') {redirect(base_url('Dash')); }
		# end for level #

		$this->load->view('templates/head', array('title' => 'ReportingMDI | Other Element'));
		$device = $this->Crud->query("SELECT * FROM `device` WHERE `id` != 3");
		$data = array(
			'device' => $device
		);
		$this->load->view('pages/other', $data);
	}

	public function relations()
	{
		# start level #
		$level 		= $this->session->userdata('level');
		if ($level == 'report' || $level == 'man power') {redirect(base_url('Dash')); }
		# end for level #

		$this->load->view('templates/head', array('title' => 'ReportingMDI | Device'));
		$device = $this->Crud->query("SELECT * FROM `device` WHERE `id` != 3");
		$data = array(
			'device' => $device
		);
		$this->load->view('pages/relations', $data);
	}

	public function unit($dev = '')
	{
		# start level #
		$level 		= $this->session->userdata('level');
		if ($level == 'man power') {redirect(base_url('Dash')); }
		# end for level #

		$dev = $dev != '' ? $dev : 'Jigsaw';
		$this->load->library('table');
		$this->load->view('templates/head', array('title' => 'ReportingMDI | Unit'));
		$dev_id = $this->Crud->search('device', array('name' => $dev))->row_array()['id'];
		$unit = $this->Crud->query("SELECT `unit`.*, `ser`.`name` as `series_name`, `type`.`name` as `type_name`, `cod`.`name` as `code_name`, `ant`.`name` as `antenna_name`, `power`.`name` as `poweroff_name`
			, (SELECT GROUP_CONCAT(DISTINCT `backlog_name` SEPARATOR ', ') as `backlog` FROM (SELECT `backlog`.`id`, `unit_id`,`backlog`.`backlog`, (SELECT `value` FROM `backlog` as a where a.unit_id = `backlog`.`unit_id` AND a.backlog = `backlog`.`backlog` ORDER BY `id` DESC LIMIT 1) as `value`, `enum`.`name` as `backlog_name`, `date` FROM `backlog` LEFT JOIN `enum` ON `backlog`.`backlog` = `enum`.`id`) as A WHERE `unit_id` = `unit`.`id` AND `value`= 0 AND `date` <= '" . date('Y-m-d') . "' GROUP BY `unit_id`) as `backlog`
		 FROM `unit` LEFT JOIN `enum` as `ser` ON `unit`.`series` = `ser`.`id` LEFT JOIN `enum` as `type` ON `unit`.`type` = `type`.`id` LEFT JOIN `enum` as `cod` ON `unit`.`code_unit` = `cod`.`id` LEFT JOIN `enum` as `ant` ON `unit`.`antenna` = `ant`.`id`
			LEFT JOIN `enum` as `power` ON `unit`.`poweroff` = `power`.`id`
		 WHERE `unit`.`device_id` = '{$dev_id}'");
		$bd_type = $this->Crud->search('enum', array('type' => 'bd_type', 'device_id' => $dev_id))->result_array();
		$series = $this->Crud->search('enum', array('type' => 'series', 'device_id' => $dev_id))->result_array();
		$unit_type = $this->Crud->search('enum', array('type' => 'unit_type', 'device_id' => $dev_id))->result_array();
		$antenna = $this->Crud->search('enum', array('type' => 'antenna', 'device_id' => $dev_id))->result_array();
		$code_unit = $this->Crud->search('enum', array('type' => 'code_unit', 'device_id' => $dev_id))->result_array();
		$poweroff = $this->Crud->search('enum', array('type' => 'poweroff', 'device_id' => $dev_id))->result_array();
		$group_loc = $this->Crud->query("SELECT `location`, (COUNT(*)-SUM(IF(`status` = '1', `status`, 0))) as `Installed`, SUM(IF(`status` = '1', `status`, 0)) as `Uninstalled`, ((COUNT(*)-SUM(IF(`status` = '1', `status`, 0)))/COUNT(*)*100) as `Percent` FROM `unit` WHERE `unit`.`device_id` = '{$dev_id}' GROUP BY `location`");
		$data = array(
			'level' => $level,
			'unit' => $unit,
			'dev_id' => $dev_id,
			'dev'	=> $dev,
			'bd_type' => $bd_type,
			'unit_type'	=> $unit_type,
			'series'	=> $series,
			'antenna'	=> $antenna,
			'code_unit'	=> $code_unit,
			'poweroff'	=> $poweroff,
			'group' 	=> $group_loc
		);
		$this->load->view('pages/unit', $data);
	}

	public function report($dev = '', $year = '', $month = '', $page = '')
	{
		$level 		= $this->session->userdata('level');

		$this->load->helper('penghitungan_helper');
		$dev = $dev != '' ? $dev : 'Jigsaw';
		$page == '' ? $page = 1 : $page;

		$this->load->library('table');
		$this->load->view('templates/head', array('title' => 'ReportingMDI | Report ' . ucfirst($dev)));
		$dev_id = $this->Crud->search('device', array('name' => $dev))->row_array()['id'];
		
		//setting halaman
		$per_page = 10;
		$start = ($page - 1) * $per_page;
		$sql = $this->Crud->query("SELECT `date` FROM `report` WHERE YEAR(`date`) = '{$year}' AND MONTH(`date`) = '{$month}' AND device_id = {$dev_id} GROUP BY `date` LIMIT $start, $per_page");
		$sqla = $this->Crud->query("SELECT `date` FROM `report` WHERE YEAR(`date`) = '{$year}' AND MONTH(`date`) = '{$month}' AND device_id = {$dev_id} GROUP BY `date`");
		$total = count($sqla);
		$page_total =  ceil($total / $per_page);
		$data = array(
			'dev_id' => $dev_id,
			'dev'	=> $dev,
			'year' => $year,
			'month' => $month,
			'query' => $sql,
			'page_total'	=> $page_total,
			'page' => $page,
			'level' => $level
		);
		$this->load->view('pages/report', $data);
	}

	public function report_advanced($dev = '', $year = '', $month = '', $page = '')
	{
		# start level #
		$level 		= $this->session->userdata('level');
		if ($level == 'report' || $level == 'man power') {redirect(base_url('Dash')); }
		# end for level #

		$this->load->helper('penghitungan_helper');
		$dev = $dev != '' ? $dev : 'Jigsaw';
		$page == '' ? $page = 1 : $page;

		$this->load->view('templates/head', array('title' => 'ReportingMDI | Report ' . ucfirst($dev)));
		$dev_id = $this->Crud->search('device', array('name' => $dev))->row_array()['id'];
		$bd = $this->Crud->search('enum', array('type' => 'bd_type'))->result_array();
		$problem = $this->Crud->query("SELECT `enum`.`id`, `enum`.`name`, `enum`.`alias` FROM `relations` LEFT JOIN `enum` ON `relations`.`problem` = `enum`.`id` WHERE `relations`.`device_id` = {$dev_id} GROUP BY `enum`.`id`");

		//setting halaman
		$per_page = 10;
		$start = ($page - 1) * $per_page;
		$sql = $this->Crud->query("SELECT `date` FROM `report` WHERE YEAR(`date`) = '{$year}' AND MONTH(`date`) = '{$month}' AND device_id = {$dev_id} GROUP BY `date` LIMIT $start, $per_page");
		$sqla = $this->Crud->query("SELECT `date` FROM `report` WHERE YEAR(`date`) = '{$year}' AND MONTH(`date`) = '{$month}' AND device_id = {$dev_id} GROUP BY `date`");
		$total = count($sqla);
		$page_total =  ceil($total / $per_page);
		$data = array(
			'dev_id' => $dev_id,
			'dev'	=> $dev,
			'year' => $year,
			'month' => $month,
			'query' => $sql,
			'page_total'	=> $page_total,
			'page' => $page,
			'problem'	=> $problem,
			'bd' => $bd
		);
		$this->load->view('pages/report_advanced', $data);
	}

	public function report_summary($unit='', $page = '')
	{
		$this->load->helper('penghitungan_helper');
		$unit = $unit != '' ? urldecode($unit) : 'D3-006';
		$page == '' ? $page = 1 : $page;
		$this->load->view('templates/head', array('title' => 'ReportingMDI | Report Summary ' . ucfirst($unit)));
		$dev = $this->Crud->sql_query("SELECT `device`.`id`,`device`.`name` FROM `unit` LEFT JOIN `device` ON `unit`.`device_id` = `device`.`id` WHERE `unit`.`id` = '{$unit}'")->row_array()['name'];
		
		//setting halaman
		$per_page = 100;
		$start = ($page - 1) * $per_page;
		$sql = $this->Crud->query("SELECT `report`.`id` as `id`, `date`, `shift`, `unit_id`, `location`, `time_problem`, `start_waiting`, `end_waiting`, `start_action`, `end_action`, `bd_receiver`, `rfu_receiver`, `status`, `enum`.`name` as `bd_type`, `prob`.`name` as `problem`, `category`.`name` as `category`, `analysis`.`name` as `analysis`, `cause`.`name` as `cause`, `activity`.`name` as `activity`, `remark`.`name` as `remark`, GROUP_CONCAT(`user`.`name` SEPARATOR ', ') as `pic`,(SELECT GROUP_CONCAT(DISTINCT `backlog_name` SEPARATOR '<br /> - ') as `backlog` FROM (SELECT `backlog`.`id`, `unit_id`,`backlog`.`backlog`, (SELECT `value` FROM `backlog` as a where a.unit_id = `backlog`.`unit_id` AND a.backlog = `backlog`.`backlog` ORDER BY `id` DESC LIMIT 1) as `value`, `enum`.`name` as `backlog_name`, `date` FROM `backlog` LEFT JOIN `enum` ON `backlog`.`backlog` = `enum`.`id`) as A WHERE `unit_id` = `report`.`unit_id` AND `value`= 0 AND `date` <= `report`.`date` GROUP BY `unit_id`) as `backlog`, `other` FROM `report` LEFT JOIN `enum` ON `report`.`bd_type` = `enum`.`id` LEFT JOIN `enum` as `prob` ON `report`.`problem` = `prob`.`id` LEFT JOIN `enum` as `category` ON `report`.`category` = `category`.`id` LEFT JOIN `enum` as `analysis` ON `report`.`analysis` = `analysis`.`id` LEFT JOIN `enum` as `cause` ON `report`.`cause` = `cause`.`id` LEFT JOIN `enum` as `activity` ON `report`.`activity` = `activity`.`id` LEFT JOIN `enum` as `remark` ON `report`.`remark` = `remark`.`id` LEFT JOIN `pic_report` ON `report`.`id` = `pic_report`.`report_id` LEFT JOIN `user` ON `pic_report`.`user_id` = `user`.`id` WHERE `report`.`unit_id` = '{$unit}' GROUP BY `pic_report`.`report_id`  ORDER BY `report`.`date` ASC LIMIT $start, $per_page");
		$sqla = $this->Crud->query("SELECT `unit_id` FROM `report` WHERE `report`.`unit_id` = '{$unit}'");
		$total = count($sqla);
		$page_total =  ceil($total / $per_page);
		$data = array(
			'unit' => $unit,
			'query' => $sql,
			'dev' => $dev,
			'page_total'	=> $page_total,
			'page' => $page
		);
		$this->load->view('pages/report_summary', $data);
	}

	public function chart($dev='')
	{
		$dev = $dev == '' ? 'Jigsaw' : ucfirst($dev);
		$this->load->view('templates/head', array('title' => 'ReportingMDI | Chart ' . $dev));
		$dev_id = $this->Crud->search('device', array('name' => $dev))->row_array()['id'];
		$field = $this->Crud->query("SELECT `enum`.`id`,`enum`.`name`,`enum`.`alias` FROM `relations` LEFT JOIN `enum` ON `relations`.`analysis` = `enum`.`id` WHERE `relations`.`device_id` = '{$dev_id}' GROUP BY `enum`.`id`");
		$data = array(
			'dev' => $dev,
			'dev_id' => $dev_id,
			'data' => $field
		);
		$this->load->view('pages/chart', $data);
	}

	public function profile($user='')
	{
		$level 	= $this->session->userdata('level');
		if ($level == 'supervisor' || $level == 'administrator') {
			if ($user == '') {
				$username = $this->session->userdata('username');
			} else {
				$username = $user;
			}
		} else {
			$username 	= $this->session->userdata('username');
		}
		$profile = $this->Crud->sql_query("SELECT `user`.`id`,`user`.`username`, `user`.`name`, `user`.`description`, `enum`.`name` as `level` FROM `user` LEFT JOIN `enum` ON `user`.`level`  = `enum`.`id` WHERE `user`.`username` = '{$username}'")->row_array();
		$count_jigsaw = $this->Crud->sql_query("SELECT `date` FROM `pic_report` LEFT JOIN `report` ON `pic_report`.`report_id` = `report`.`id` WHERE `report`.`device_id` = 1 AND `pic_report`.`user_id` = '{$profile['id']}' GROUP BY `date`, `unit_id`, `bd_type`, `problem`, `category`,`analysis`,`cause`, `start_waiting`, `end_waiting`, `start_action`, `end_action`")->result_array();
		$count_network = $this->Crud->sql_query("SELECT `date` FROM `pic_report` LEFT JOIN `report` ON `pic_report`.`report_id` = `report`.`id` WHERE `report`.`device_id` = 2 AND `pic_report`.`user_id` = '{$profile['id']}' GROUP BY `date`, `unit_id`, `bd_type`, `problem`, `category`,`analysis`,`cause`, `start_waiting`, `end_waiting`, `start_action`, `end_action`")->result_array();
		$this->load->view('templates/head', array('title' => 'ReportingMDI | Profile'));
		$data = array(
			'userprofile' => $this->session->userdata('username'),
			'username' => $username,
			'data' => $profile,
			'count_jigsaw' => count($count_jigsaw),
			'count_network' => count($count_network)
		);
		$this->load->view('pages/profile', $data);
	}

	public function bandwith()
	{
		$this->load->view('templates/head', array('title' => 'ReportingMDI | Bandwith'));
		$this->load->view('pages/bandwith');
	}

	public function battery($year = '', $month = '')
	{
		if ($year == '' && $month == '') {
			$sql = $this->Crud->query("SELECT `unit_id`,
				SUM(IF(DAY(`date`) = '1' AND HOUR(`date`) = 06,`volt`, 0)) as '1_1',
				SUM(IF(DAY(`date`) = '1' AND HOUR(`date`) = 18,`volt`, 0)) as '1_2',
				SUM(IF(DAY(`date`) = '2' AND HOUR(`date`) = 06,`volt`, 0)) as '2_1',
				SUM(IF(DAY(`date`) = '2' AND HOUR(`date`) = 18,`volt`, 0)) as '2_2',
				SUM(IF(DAY(`date`) = '3' AND HOUR(`date`) = 06,`volt`, 0)) as '3_1',
				SUM(IF(DAY(`date`) = '3' AND HOUR(`date`) = 18,`volt`, 0)) as '3_2',
				SUM(IF(DAY(`date`) = '4' AND HOUR(`date`) = 06,`volt`, 0)) as '4_1',
				SUM(IF(DAY(`date`) = '4' AND HOUR(`date`) = 18,`volt`, 0)) as '4_2',
				SUM(IF(DAY(`date`) = '5' AND HOUR(`date`) = 06,`volt`, 0)) as '5_1',
				SUM(IF(DAY(`date`) = '5' AND HOUR(`date`) = 18,`volt`, 0)) as '5_2',
				SUM(IF(DAY(`date`) = '6' AND HOUR(`date`) = 06,`volt`, 0)) as '6_1',
				SUM(IF(DAY(`date`) = '6' AND HOUR(`date`) = 18,`volt`, 0)) as '6_2',
				SUM(IF(DAY(`date`) = '7' AND HOUR(`date`) = 06,`volt`, 0)) as '7_1',
				SUM(IF(DAY(`date`) = '7' AND HOUR(`date`) = 18,`volt`, 0)) as '7_2',
				SUM(IF(DAY(`date`) = '8' AND HOUR(`date`) = 06,`volt`, 0)) as '8_1',
				SUM(IF(DAY(`date`) = '8' AND HOUR(`date`) = 18,`volt`, 0)) as '8_2',
				SUM(IF(DAY(`date`) = '9' AND HOUR(`date`) = 06,`volt`, 0)) as '9_1',
				SUM(IF(DAY(`date`) = '9' AND HOUR(`date`) = 18,`volt`, 0)) as '9_2',
				SUM(IF(DAY(`date`) = '10' AND HOUR(`date`) = 06,`volt`, 0)) as '10_1',
				SUM(IF(DAY(`date`) = '10' AND HOUR(`date`) = 18,`volt`, 0)) as '10_2',
				SUM(IF(DAY(`date`) = '11' AND HOUR(`date`) = 06,`volt`, 0)) as '11_1',
				SUM(IF(DAY(`date`) = '11' AND HOUR(`date`) = 18,`volt`, 0)) as '11_2',
				SUM(IF(DAY(`date`) = '12' AND HOUR(`date`) = 06,`volt`, 0)) as '12_1',
				SUM(IF(DAY(`date`) = '12' AND HOUR(`date`) = 18,`volt`, 0)) as '12_2',
				SUM(IF(DAY(`date`) = '13' AND HOUR(`date`) = 06,`volt`, 0)) as '13_1',
				SUM(IF(DAY(`date`) = '13' AND HOUR(`date`) = 18,`volt`, 0)) as '13_2',
				SUM(IF(DAY(`date`) = '14' AND HOUR(`date`) = 06,`volt`, 0)) as '14_1',
				SUM(IF(DAY(`date`) = '14' AND HOUR(`date`) = 18,`volt`, 0)) as '14_2',
				SUM(IF(DAY(`date`) = '15' AND HOUR(`date`) = 06,`volt`, 0)) as '15_1',
				SUM(IF(DAY(`date`) = '15' AND HOUR(`date`) = 18,`volt`, 0)) as '15_2',
				SUM(IF(DAY(`date`) = '16' AND HOUR(`date`) = 06,`volt`, 0)) as '16_1',
				SUM(IF(DAY(`date`) = '16' AND HOUR(`date`) = 18,`volt`, 0)) as '16_2',
				SUM(IF(DAY(`date`) = '17' AND HOUR(`date`) = 06,`volt`, 0)) as '17_1',
				SUM(IF(DAY(`date`) = '17' AND HOUR(`date`) = 18,`volt`, 0)) as '17_2',
				SUM(IF(DAY(`date`) = '18' AND HOUR(`date`) = 06,`volt`, 0)) as '18_1',
				SUM(IF(DAY(`date`) = '18' AND HOUR(`date`) = 18,`volt`, 0)) as '18_2',
				SUM(IF(DAY(`date`) = '19' AND HOUR(`date`) = 06,`volt`, 0)) as '19_1',
				SUM(IF(DAY(`date`) = '19' AND HOUR(`date`) = 18,`volt`, 0)) as '19_2',
				SUM(IF(DAY(`date`) = '20' AND HOUR(`date`) = 06,`volt`, 0)) as '20_1',
				SUM(IF(DAY(`date`) = '20' AND HOUR(`date`) = 18,`volt`, 0)) as '20_2',
				SUM(IF(DAY(`date`) = '21' AND HOUR(`date`) = 06,`volt`, 0)) as '21_1',
				SUM(IF(DAY(`date`) = '21' AND HOUR(`date`) = 18,`volt`, 0)) as '21_2',
				SUM(IF(DAY(`date`) = '22' AND HOUR(`date`) = 06,`volt`, 0)) as '22_1',
				SUM(IF(DAY(`date`) = '22' AND HOUR(`date`) = 18,`volt`, 0)) as '22_2',
				SUM(IF(DAY(`date`) = '23' AND HOUR(`date`) = 06,`volt`, 0)) as '23_1',
				SUM(IF(DAY(`date`) = '23' AND HOUR(`date`) = 18,`volt`, 0)) as '23_2',
				SUM(IF(DAY(`date`) = '24' AND HOUR(`date`) = 06,`volt`, 0)) as '24_1',
				SUM(IF(DAY(`date`) = '24' AND HOUR(`date`) = 18,`volt`, 0)) as '24_2',
				SUM(IF(DAY(`date`) = '25' AND HOUR(`date`) = 06,`volt`, 0)) as '25_1',
				SUM(IF(DAY(`date`) = '25' AND HOUR(`date`) = 18,`volt`, 0)) as '25_2',
				SUM(IF(DAY(`date`) = '26' AND HOUR(`date`) = 06,`volt`, 0)) as '26_1',
				SUM(IF(DAY(`date`) = '26' AND HOUR(`date`) = 18,`volt`, 0)) as '26_2',
				SUM(IF(DAY(`date`) = '27' AND HOUR(`date`) = 06,`volt`, 0)) as '27_1',
				SUM(IF(DAY(`date`) = '27' AND HOUR(`date`) = 18,`volt`, 0)) as '27_2',
				SUM(IF(DAY(`date`) = '28' AND HOUR(`date`) = 06,`volt`, 0)) as '28_1',
				SUM(IF(DAY(`date`) = '28' AND HOUR(`date`) = 18,`volt`, 0)) as '28_2',
				SUM(IF(DAY(`date`) = '29' AND HOUR(`date`) = 06,`volt`, 0)) as '29_1',
				SUM(IF(DAY(`date`) = '29' AND HOUR(`date`) = 18,`volt`, 0)) as '29_2',
				SUM(IF(DAY(`date`) = '30' AND HOUR(`date`) = 06,`volt`, 0)) as '30_1',
				SUM(IF(DAY(`date`) = '30' AND HOUR(`date`) = 18,`volt`, 0)) as '30_2',
				SUM(IF(DAY(`date`) = '31' AND HOUR(`date`) = 06,`volt`, 0)) as '31_1',
				SUM(IF(DAY(`date`) = '31' AND HOUR(`date`) = 18,`volt`, 0)) as '31_2'
				FROM `battery` WHERE YEAR(`date`) = '" . date('Y') . "' AND MONTH(`date`) = '" . date('m') . "'GROUP BY `unit_id` ORDER BY `unit_id` ASC");
		} else {
			$sql = $this->Crud->query("SELECT `unit_id`,
				SUM(IF(DAY(`date`) = '1' AND HOUR(`date`) = 06,`volt`, 0)) as '1_1',
				SUM(IF(DAY(`date`) = '1' AND HOUR(`date`) = 18,`volt`, 0)) as '1_2',
				SUM(IF(DAY(`date`) = '2' AND HOUR(`date`) = 06,`volt`, 0)) as '2_1',
				SUM(IF(DAY(`date`) = '2' AND HOUR(`date`) = 18,`volt`, 0)) as '2_2',
				SUM(IF(DAY(`date`) = '3' AND HOUR(`date`) = 06,`volt`, 0)) as '3_1',
				SUM(IF(DAY(`date`) = '3' AND HOUR(`date`) = 18,`volt`, 0)) as '3_2',
				SUM(IF(DAY(`date`) = '4' AND HOUR(`date`) = 06,`volt`, 0)) as '4_1',
				SUM(IF(DAY(`date`) = '4' AND HOUR(`date`) = 18,`volt`, 0)) as '4_2',
				SUM(IF(DAY(`date`) = '5' AND HOUR(`date`) = 06,`volt`, 0)) as '5_1',
				SUM(IF(DAY(`date`) = '5' AND HOUR(`date`) = 18,`volt`, 0)) as '5_2',
				SUM(IF(DAY(`date`) = '6' AND HOUR(`date`) = 06,`volt`, 0)) as '6_1',
				SUM(IF(DAY(`date`) = '6' AND HOUR(`date`) = 18,`volt`, 0)) as '6_2',
				SUM(IF(DAY(`date`) = '7' AND HOUR(`date`) = 06,`volt`, 0)) as '7_1',
				SUM(IF(DAY(`date`) = '7' AND HOUR(`date`) = 18,`volt`, 0)) as '7_2',
				SUM(IF(DAY(`date`) = '8' AND HOUR(`date`) = 06,`volt`, 0)) as '8_1',
				SUM(IF(DAY(`date`) = '8' AND HOUR(`date`) = 18,`volt`, 0)) as '8_2',
				SUM(IF(DAY(`date`) = '9' AND HOUR(`date`) = 06,`volt`, 0)) as '9_1',
				SUM(IF(DAY(`date`) = '9' AND HOUR(`date`) = 18,`volt`, 0)) as '9_2',
				SUM(IF(DAY(`date`) = '10' AND HOUR(`date`) = 06,`volt`, 0)) as '10_1',
				SUM(IF(DAY(`date`) = '10' AND HOUR(`date`) = 18,`volt`, 0)) as '10_2',
				SUM(IF(DAY(`date`) = '11' AND HOUR(`date`) = 06,`volt`, 0)) as '11_1',
				SUM(IF(DAY(`date`) = '11' AND HOUR(`date`) = 18,`volt`, 0)) as '11_2',
				SUM(IF(DAY(`date`) = '12' AND HOUR(`date`) = 06,`volt`, 0)) as '12_1',
				SUM(IF(DAY(`date`) = '12' AND HOUR(`date`) = 18,`volt`, 0)) as '12_2',
				SUM(IF(DAY(`date`) = '13' AND HOUR(`date`) = 06,`volt`, 0)) as '13_1',
				SUM(IF(DAY(`date`) = '13' AND HOUR(`date`) = 18,`volt`, 0)) as '13_2',
				SUM(IF(DAY(`date`) = '14' AND HOUR(`date`) = 06,`volt`, 0)) as '14_1',
				SUM(IF(DAY(`date`) = '14' AND HOUR(`date`) = 18,`volt`, 0)) as '14_2',
				SUM(IF(DAY(`date`) = '15' AND HOUR(`date`) = 06,`volt`, 0)) as '15_1',
				SUM(IF(DAY(`date`) = '15' AND HOUR(`date`) = 18,`volt`, 0)) as '15_2',
				SUM(IF(DAY(`date`) = '16' AND HOUR(`date`) = 06,`volt`, 0)) as '16_1',
				SUM(IF(DAY(`date`) = '16' AND HOUR(`date`) = 18,`volt`, 0)) as '16_2',
				SUM(IF(DAY(`date`) = '17' AND HOUR(`date`) = 06,`volt`, 0)) as '17_1',
				SUM(IF(DAY(`date`) = '17' AND HOUR(`date`) = 18,`volt`, 0)) as '17_2',
				SUM(IF(DAY(`date`) = '18' AND HOUR(`date`) = 06,`volt`, 0)) as '18_1',
				SUM(IF(DAY(`date`) = '18' AND HOUR(`date`) = 18,`volt`, 0)) as '18_2',
				SUM(IF(DAY(`date`) = '19' AND HOUR(`date`) = 06,`volt`, 0)) as '19_1',
				SUM(IF(DAY(`date`) = '19' AND HOUR(`date`) = 18,`volt`, 0)) as '19_2',
				SUM(IF(DAY(`date`) = '20' AND HOUR(`date`) = 06,`volt`, 0)) as '20_1',
				SUM(IF(DAY(`date`) = '20' AND HOUR(`date`) = 18,`volt`, 0)) as '20_2',
				SUM(IF(DAY(`date`) = '21' AND HOUR(`date`) = 06,`volt`, 0)) as '21_1',
				SUM(IF(DAY(`date`) = '21' AND HOUR(`date`) = 18,`volt`, 0)) as '21_2',
				SUM(IF(DAY(`date`) = '22' AND HOUR(`date`) = 06,`volt`, 0)) as '22_1',
				SUM(IF(DAY(`date`) = '22' AND HOUR(`date`) = 18,`volt`, 0)) as '22_2',
				SUM(IF(DAY(`date`) = '23' AND HOUR(`date`) = 06,`volt`, 0)) as '23_1',
				SUM(IF(DAY(`date`) = '23' AND HOUR(`date`) = 18,`volt`, 0)) as '23_2',
				SUM(IF(DAY(`date`) = '24' AND HOUR(`date`) = 06,`volt`, 0)) as '24_1',
				SUM(IF(DAY(`date`) = '24' AND HOUR(`date`) = 18,`volt`, 0)) as '24_2',
				SUM(IF(DAY(`date`) = '25' AND HOUR(`date`) = 06,`volt`, 0)) as '25_1',
				SUM(IF(DAY(`date`) = '25' AND HOUR(`date`) = 18,`volt`, 0)) as '25_2',
				SUM(IF(DAY(`date`) = '26' AND HOUR(`date`) = 06,`volt`, 0)) as '26_1',
				SUM(IF(DAY(`date`) = '26' AND HOUR(`date`) = 18,`volt`, 0)) as '26_2',
				SUM(IF(DAY(`date`) = '27' AND HOUR(`date`) = 06,`volt`, 0)) as '27_1',
				SUM(IF(DAY(`date`) = '27' AND HOUR(`date`) = 18,`volt`, 0)) as '27_2',
				SUM(IF(DAY(`date`) = '28' AND HOUR(`date`) = 06,`volt`, 0)) as '28_1',
				SUM(IF(DAY(`date`) = '28' AND HOUR(`date`) = 18,`volt`, 0)) as '28_2',
				SUM(IF(DAY(`date`) = '29' AND HOUR(`date`) = 06,`volt`, 0)) as '29_1',
				SUM(IF(DAY(`date`) = '29' AND HOUR(`date`) = 18,`volt`, 0)) as '29_2',
				SUM(IF(DAY(`date`) = '30' AND HOUR(`date`) = 06,`volt`, 0)) as '30_1',
				SUM(IF(DAY(`date`) = '30' AND HOUR(`date`) = 18,`volt`, 0)) as '30_2',
				SUM(IF(DAY(`date`) = '31' AND HOUR(`date`) = 06,`volt`, 0)) as '31_1',
				SUM(IF(DAY(`date`) = '31' AND HOUR(`date`) = 18,`volt`, 0)) as '31_2'
				FROM `battery` WHERE YEAR(`date`) = '" . $year . "' AND MONTH(`date`) = '" . $month . "'GROUP BY `unit_id` ORDER BY `unit_id` ASC");
		}
		$this->load->view('templates/head', array('title' => 'ReportingMDI | Battery'));
		
		$data = array(
			'query' => $sql,
			'year' => $year,
			'month' => $month
		);
		$this->load->view('pages/battery', $data);
	}

	public function pm($dev = '', $year = '', $month = '')
	{
		$level 		= $this->session->userdata('level');

		$this->load->helper('penghitungan_helper');
		$dev = $dev != '' ? $dev : 'Jigsaw';
		
		$this->load->library('table');
		$this->load->view('templates/head', array('title' => 'ReportingMDI | Preventive Maintenance ' . ucfirst($dev)));
		$dev_id = $this->Crud->search('device', array('name' => $dev))->row_array()['id'];
		
		//setting halaman
		$sql = $this->Crud->query("SELECT `report`.`id`, `report`.`unit_id`, `type`.`name` as `type`, `report`.`date`, `unit`.`sn_display`, `unit`.`sn_wb`, `unit`.`sn_gps`, (SELECT GROUP_CONCAT(`user`.`name` SEPARATOR ', ') FROM `pic_report` LEFT JOIN `user` ON `pic_report`.`user_id` = `user`.`id` WHERE `pic_report`.`report_id` = `report`.`id` GROUP BY `pic_report`.`report_id`) as `pic` FROM `report`
LEFT JOIN `enum` ON `report`.`problem` = `enum`.`id`
LEFT JOIN `unit` ON `report`.`unit_id` = `unit`.`id`
LEFT JOIN `enum` as `type` ON `unit`.`code_unit` = `type`.`id`
WHERE `enum`.`name` LIKE '%Preventive maintenance%' AND YEAR(`report`.`date`) = '{$year}' AND MONTH(`report`.`date`) = '{$month}' AND `report`.`device_id` = {$dev_id}
ORDER BY `report`.`date`");
		$data = array(
			'dev_id' => $dev_id,
			'dev'	=> $dev,
			'year' => $year,
			'month' => $month,
			'query' => $sql,
			'level' => $level
		);
		$this->load->view('pages/pm', $data);
	}

	public function pm_summary($unit = '')
	{
		$level 		= $this->session->userdata('level');
		$unit = $unit != '' ? urldecode($unit) : 'D3-006';
		$this->load->helper('penghitungan_helper');
		$this->load->view('templates/head', array('title' => 'ReportingMDI | Preventive Maintenance ' . ucfirst($unit)));
		$src = $this->Crud->search('unit', array('id' => $unit))->row_array();
		$unit_id = $src['id'];
		$dev = $this->Crud->search('device', array('id' => $src['device_id']))->row_array();
		
		//setting halaman
		$sql = $this->Crud->query("SELECT `report`.`date`,`report`.`id`, `report`.`unit_id`, `type`.`name` as `type`, `report`.`date`, `unit`.`sn_display`, `unit`.`sn_wb`, `unit`.`sn_gps`, (SELECT GROUP_CONCAT(`user`.`name` SEPARATOR ', ') FROM `pic_report` LEFT JOIN `user` ON `pic_report`.`user_id` = `user`.`id` WHERE `pic_report`.`report_id` = `report`.`id` GROUP BY `pic_report`.`report_id`) as `pic` FROM `report`
LEFT JOIN `enum` ON `report`.`problem` = `enum`.`id`
LEFT JOIN `unit` ON `report`.`unit_id` = `unit`.`id`
LEFT JOIN `enum` as `type` ON `unit`.`code_unit` = `type`.`id`
WHERE `enum`.`name` LIKE '%Preventive maintenance%' AND `report`.`unit_id` = '{$unit_id}'
ORDER BY `report`.`date`");
		$data = array(
			'unit_id' => $unit_id,
			'dev' => $dev['name'],
			'unit'	=> $unit,
			'query' => $sql,
			'level' => $level
		);
		$this->load->view('pages/pm_summary', $data);
	}

	public function r_backlog($dev = '', $unit_id = '')
	{
		# start level #
		$level 		= $this->session->userdata('level');
		if ($level == 'man power') {redirect(base_url('Dash')); }
		# end for level #

		$dev = $dev != '' ? $dev : 'Jigsaw';
		$this->load->view('templates/head', array('title' => 'ReportingMDI | Backlog ' . $dev));
		$dev_id = $this->Crud->search('device', array('name' => $dev))->row_array()['id'];
		if ($unit_id != '') {
			$unit_id = $unit_id != '' ? urldecode($unit_id) : 'D3-006';
			$unit = $this->Crud->query("SELECT `backlog`.`unit_id` as `id`, `ser`.`name` as `series_name`,`backlog`.`date`,`backlog`.`unit_id`, `cod`.`name` as `code_name`, IF(`backlog`.`value`='0', \"OPEN\", \"CLOSE\") as `value`, `enum`.`name` as `backlog`, GROUP_CONCAT(`user`.`name` separator ', ') as `pic` FROM `backlog`
				LEFT JOIN `unit` ON `backlog`.`unit_id` = `unit`.`id`
LEFT JOIN `enum` ON `backlog`.`backlog` = `enum`.`id`
LEFT JOIN `user` ON `backlog`.`user_id` = `user`.`id`
LEFT JOIN `enum` as `cod` ON `unit`.`code_unit` = `cod`.`id`
LEFT JOIN `enum` as `ser` ON `unit`.`series` = `ser`.`id`
GROUP BY `date`, `unit_id`, `backlog`, `value`
HAVING `unit_id` = '{$unit_id}'
ORDER BY `date`, `unit_id`");
		} else {
			$unit = $this->Crud->query("SELECT `unit`.*, `ser`.`name` as `series_name`, `type`.`name` as `type_name`, `cod`.`name` as `code_name`, `ant`.`name` as `antenna_name`, `power`.`name` as `poweroff_name`
			, (SELECT GROUP_CONCAT(DISTINCT `backlog_name` SEPARATOR '<br /> - ') as `backlog` FROM (SELECT `backlog`.`id`, `unit_id`,`backlog`.`backlog`, (SELECT `value` FROM `backlog` as a where a.unit_id = `backlog`.`unit_id` AND a.backlog = `backlog`.`backlog` ORDER BY `id` DESC LIMIT 1) as `value`, `enum`.`name` as `backlog_name`, `date` FROM `backlog` LEFT JOIN `enum` ON `backlog`.`backlog` = `enum`.`id`) as A WHERE `unit_id` = `unit`.`id` AND `value`= 0 AND `date` <= '" . date('Y-m-d') . "' GROUP BY `unit_id`) as `backlog`
		 FROM `unit` LEFT JOIN `enum` as `ser` ON `unit`.`series` = `ser`.`id` LEFT JOIN `enum` as `type` ON `unit`.`type` = `type`.`id` LEFT JOIN `enum` as `cod` ON `unit`.`code_unit` = `cod`.`id` LEFT JOIN `enum` as `ant` ON `unit`.`antenna` = `ant`.`id`
			LEFT JOIN `enum` as `power` ON `unit`.`poweroff` = `power`.`id`
		 WHERE `unit`.`device_id` = '{$dev_id}' HAVING `backlog` != ''");
		}
		$group_loc = $this->Crud->query("SELECT `location`,
(COUNT(*)-SUM(IF(`status` = '1', `status`, 0))) as `Installed`,
SUM(IF(`status` = '1', `status`, 0)) as `Uninstalled`,
((COUNT(*)-SUM(IF(`status` = '1', `status`, 0)))/COUNT(*)*100) as `Percent`
FROM `unit` WHERE `unit`.`device_id` = '{$dev_id}' GROUP BY `location`");
		$data = array(
			'unit' => $unit,
			'dev_id' => $dev_id,
			'dev'	=> $dev,
			'group' 	=> $group_loc,
			'unit_id' => $unit_id
		);
		$this->load->view('pages/r_backlog', $data);
	}
}
