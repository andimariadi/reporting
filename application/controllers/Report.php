<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

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
		$this->load->model('crud');
		$this->load->helper('cookie');
		$username 	= $this->session->userdata('username');
		$level 	= $this->session->userdata('level');
		if ($level != 'teknisi') {
			redirect(base_url('Auth/logout'));
		}
		$src = $this->Crud->search('user', array('username' => $username))->row_array();
		if (date('Y-m-d H:i:s') >= $src['last_login']) {
			redirect(base_url('Auth/logout/session'));
		} else {
			$this->Crud->update('user', array('username' => $username), array('last_login' => date('Y-m-d H:i:s', strtotime('+ 10 minutes'))));
		}
	}

	public function index()
	{
		$this->load->view('templates/head_login', array('title' => 'Reporting'));
	  	$expire = time() + (86400 * 30);
	  	$expire = ($expire > 0) ? 86400 + $expire : 0;
		$cookie = array(
			'dev' 		=> $this->input->cookie('dev'),
			'hour' 		=> 86400,
			'submit' 	=> $this->input->post('submit')
		);
		$this->load->view('report/report', $cookie);
	}

	public function report()
	{
		$this->load->view('templates/head_report', array('title' => 'Reporting'));
	  	$dev_id =  !$this->input->cookie('dev') ? 1 : $this->input->cookie('dev');
	  	$dev_name = $this->Crud->search('device', array('id' => $dev_id))->row_array()['name'];
	  	$pic = $this->Crud->query("SELECT `user`.`id`,`user`.`name`,`user`.`username` FROM `user` LEFT JOIN `enum` ON `user`.`level` = `enum`.`id` WHERE `enum`.`name` IN ('man power') ORDER BY `user`.`name` ASC");
	  	$bd = $this->Crud->search('enum', array('type' => 'bd_type', 'device_id' => $dev_id))->result_array();
	  	$problem = $this->Crud->query("SELECT `enum`.`id`, `enum`.`name`, `enum`.`alias` FROM `relations` LEFT JOIN `enum` ON `relations`.`problem` = `enum`.`id` WHERE `relations`.`device_id` = {$dev_id} GROUP BY `enum`.`id`");
	  	$antenna = $this->Crud->search('enum', array('type' => 'antenna'))->result_array();
	  	$poweroff = $this->Crud->search('enum', array('type' => 'poweroff'))->result_array();
	  	$backlog = $this->Crud->search('enum', array('type' => 'backlog'))->result_array();
		$cookie = array(
			'dev' 		=> $dev_id,
			'dev_name'	=> $dev_name,
			'pic'		=> $pic,
			'bd'		=> $bd,
			'problem'	=> $problem,
			'antenna'	=> $antenna,
			'poweroff'	=> $poweroff,
			'backlog'	=> $backlog
		);

		$this->load->view('report/input', $cookie);
	}

	public function save()
	{
		if ((date('H:i:s') >= '07:00:00') AND (date('H:i:s') <= '17:30:00')) {
	    	$shift = 1;
	    	$tproblem = '07:00:00';
	    	$date = date('Y-m-d');
	  	} else {
	    	$shift = 2;
	    	$tproblem = '17:30:00';
	    	if ((date('H:i:s') >= '00:00:00') AND (date('H:i:s') <= '07:00:00')) {
	      		$date = date('Y-m-d', strtotime('-1 Day'));
	    	} else {
	      		$date = date('Y-m-d');
	    	}
	  	}



		$dev_id 		= $this->input->cookie('dev');
		$unit 			= strtoupper(trim($this->input->post('unit')));
		$location 		= trim($this->input->post('location'));
		$bd 			= trim($this->input->post('bd'));
		$bd_rec 		= trim($this->input->post('bd_rec'));
		$rfu_rec 		= trim($this->input->post('rfu_rec'));
		$startwait 		= trim($this->input->post('startwait'));
		$endwait 		= trim($this->input->post('endwait'));
		$startaction 	= trim($this->input->post('startaction'));
		$endaction 		= trim($this->input->post('endaction'));
		$problem 		= trim($this->input->post('problem'));
		$analysis 		= trim($this->input->post('analysis'));
		$cause 			= trim($this->input->post('cause'));
		$action 		= $this->input->post('action');
		$remark 		= $this->input->post('remark');
		$antenna 		= trim($this->input->post('antenna'));
		$poweroff 		= trim($this->input->post('poweroff'));
		$locked 		= trim($this->input->post('locked'));
		$sn_display 	= trim($this->input->post('sn_display'));
		$sn_wb 			= trim($this->input->post('sn_wb'));
		$sn_gps 		= trim($this->input->post('sn_gps'));
		$status 		= trim($this->input->post('status'));
		$battery 		= ';' . $this->input->post('battery');
		$pic 			= $this->input->post('pic');

		//other activity
		$action_o 		= $this->input->post('action-o');
		$remark_o 		= $this->input->post('remark-o');

		if ($dev_id == 3) {
			if (
				$startaction != ''&&
				$endaction != ''&&
				$action_o != '' &&
				$remark_o != ''
			) {
				$other = $action_o . '[||]' . $remark_o;
				$this->db->trans_start();
	  			# code...
			  	//transaction go
				$data = array(
					'updated_date'	=> date('Y-m-d H:i:s'),
					'date' => $date,
					'shift' => $shift,
					'start_action' => $startaction,
					'end_action' => $endaction,
					'other' => $other,
					'device_id' => $dev_id
				);
				$this->Crud->insert('report', $data);
				$this->db->trans_complete();
				//transaction end;
				$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible">
			                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			                <h4><i class="icon fa fa-ban"></i> Success!</h4>
			                Activity has been added!
			              </div>');
				redirect(base_url('Report/report'));
			} else {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible">
	                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
	                Insert error, field cannot empty!
	              </div>');
				redirect(base_url('Report/report'));
			}
		} else {
			//for pic
			if (
				$unit != ''&&
				$location != ''&&
				//$bd != ''&&
				$bd_rec != ''&&
				$rfu_rec != ''&&
				//$startwait != ''&&
				//$endwait != ''&&
				$startaction != ''&&
				$endaction != ''&&
				$problem != ''&&
				$analysis != ''&&
				$cause != ''&&
				$action != ''&&
				//$remark != ''&&
				//$antenna != ''&&
				//$poweroff != ''&&
				//($locked != ''|| $locked == 1 || $locked == 0) &&
				//$sn_display != ''&&
				//$sn_wb != ''&&
				//$sn_gps != ''&&
				($status != ''|| $status == 1 || $status == 0)
			) {
				$src_unit = $this->Crud->search('unit', array('id' => $unit))->num_rows();
				if ($src_unit > 0) {
					$remark != '' ? $remark : $remark = array('');
					foreach ($action as $val) {
					  	foreach ($remark as $key) {
							$relation = $this->Crud->sql_query("SELECT * FROM `relations` WHERE `problem` = '{$problem}' AND `analysis` = '{$analysis}' AND `cause` = '{$cause}' AND `action` = '{$val}'")->row_array();
							if ($relation > 0) {
								
								$this->db->trans_start();
					  			# code...
							  	//transaction go
								$data = array(
									'updated_date'	=> date('Y-m-d H:i:s'),
									'date' => $date,
									'shift' => $shift,
									'unit_id' => $unit,
									'bd_type' => $bd,
									'problem' => $problem,
									'category' => $relation['category'],
									'location' => $location,
									'analysis' => $analysis,
									'cause' => $cause,
									'activity' => $val,
									'time_problem' => $tproblem,
									'start_waiting' => $startwait,
									'end_waiting' => $endwait,
									'start_action' => $startaction,
									'end_action' => $endaction,
									'bd_receiver' => $bd_rec,
									'rfu_receiver' => $rfu_rec,
									'status' => $status,
									'remark' => $key,
									'other' => $action_o,
									'device_id' => $dev_id
								);
								$this->Crud->insert('report', $data);
								$last_insert = $this->db->insert_id();
								$update = array(
									'position' => $location,
									'sn_display' => $sn_display,
									'sn_wb' => $sn_wb,
									'sn_gps' => $sn_gps,
									'status' => $status,
									'poweroff' => $poweroff,
									'locked' => $locked,
									'antenna' => $antenna,
									'explode' => $battery
								);
								//for pic report
								foreach ($pic as $value) {
									$this->Crud->insert('pic_report', array('user_id' => $value, 'report_id' => $last_insert));
								}
								$this->Crud->update('unit', array('id' => $unit), $update);
								$this->db->trans_complete();
								//transaction end;

					  		}
						}
					}
					$cookie = array('name'   => 'unit', 'value'  => $unit, 'expire' => 86400 );
					$this->input->set_cookie($cookie);
					$cookie = array('name'   => 'pic', 'value'  => serialize($pic), 'expire' => 86400 );
					$this->input->set_cookie($cookie);
					redirect(base_url('Report/backlog'));
				} else {
					$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible">
			                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
			                <b>"' . $unit . '"</b> not found!
			              </div>');
					redirect(base_url('Report/report'));
				}
			} else {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible">
	                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
	                Insert error, field cannot empty!
	              </div>');
				redirect(base_url('Report/report'));
			}
		}
	}

	public function backlog()
	{
		if ($this->input->cookie('pic') != '') {
			$this->load->view('templates/head_report', array('title' => 'Reporting'));
			$dev =  !$this->input->cookie('dev') ? 1 : $this->input->cookie('dev');
			$pic =  unserialize($this->input->cookie('pic'));
			$unit =  !$this->input->cookie('unit') ? 1 : $this->input->cookie('unit');
			$sql = $this->Crud->query("SELECT * FROM `enum` WHERE `type` = 'backlog' AND `device_id` = {$dev} ORDER BY `alias` ASC");
			$data = array(
				'pic' => $pic,
				'unit' => $unit,
				'backlog' => $sql
			);
			$this->load->view('report/backlog', $data);
		} else {
			redirect(base_url('Report/report'));
		}		
	}

	public function update_backlog()
	{
		$unit 		= !$this->input->cookie('unit') ? 1 : $this->input->cookie('unit');
		$pic 		= !$this->input->cookie('pic') ? 1 : unserialize($this->input->cookie('pic'));
		$id 		= trim($this->input->post('id'));
		$backlog 	= trim($this->input->post('backlog'));
		$val 		= trim($this->input->post('val'));
		$src = $this->Crud->search('backlog', array('unit_id' => $unit, 'id' => $id, 'value' => '0'))->num_rows();
		if ($src > 0) {
			$src = $this->Crud->search('backlog', array('unit_id' => $unit, 'id' => $id, 'value' => $val))->num_rows();
			if ($src > 0) {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                Hmmmmm, No data changes!
              </div>');
			} else {
				foreach ($pic as $value) {
					$this->Crud->insert('backlog', array('unit_id' => $unit, 'user_id' => $value, 'backlog' => $backlog, 'value' => $val, 'date' => date('Y-m-d')));
				}
				$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible">
		                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		                <h4><i class="icon fa fa-check"></i> Success!</h4>
		                Backlog <b>"' . $unit . '"</b> has been modified!
		              </div>');
			}
		} else {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                Insert error, field cannot empty!
              </div>');
		}
	}

	public function save_backlog()
	{
		$unit 		= !$this->input->cookie('unit') ? 1 : $this->input->cookie('unit');
		$pic 		=  !$this->input->cookie('pic') ? 1 : unserialize($this->input->cookie('pic'));
		$backlog 	= trim($this->input->post('backlog'));
		$val 		= trim($this->input->post('val'));
		if ($backlog == '' || $val == '' || $val == 1) {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                Insert error, field cannot empty!
              </div>');
		} else {
			$src = $this->Crud->sql_query("SELECT * FROM (SELECT `backlog`.`id`, `unit_id`,`backlog`.`backlog`, (SELECT `value` FROM `backlog` as a where a.unit_id = `backlog`.`unit_id` AND a.backlog = `backlog`.`backlog` ORDER BY `id` DESC LIMIT 1) as `value`, `enum`.`name` as `backlog_name` FROM `backlog` LEFT JOIN `enum` ON `backlog`.`backlog` = `enum`.`id`) as A WHERE `unit_id` = '{$unit}' AND `value`= 0 AND `backlog` = '{$backlog}' GROUP BY `unit_id`, `backlog`")->num_rows();
			if ($src > 0) {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                Data already exist, please correct your data again!
              </div>');
			} else {
				foreach ($pic as $value) {
					$this->Crud->insert('backlog', array('unit_id' => $unit, 'user_id' => $value, 'backlog' => $backlog, 'value' => $val, 'date' => date('Y-m-d')));
				}
				$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible">
		                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		                <h4><i class="icon fa fa-check"></i> Success!</h4>
		                Backlog <b>"' . $unit . '"</b> has been added!
		              </div>');
			}
		}
	}

	public function finish()
	{
		delete_cookie('pic');
		delete_cookie('unit');
		delete_cookie('dev');
	    redirect(base_url('Report'));
	}

	public function restart()
	{
		delete_cookie('pic');
		delete_cookie('unit');
	    redirect(base_url('Report/report'));
	}

}
