<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Save extends CI_Controller {

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
		$username 	= $this->session->userdata('username');
		$level 		= $this->session->userdata('level');
		$page 		= 'Dashboard';

		if ($level == 'teknisi') {
			redirect(base_url('report'));
		}
		elseif (!$level) {
			redirect(base_url('Auth'));
		}
	}

	public function index ($page = 'Login') {
		$data['title'] = $page;
		$this->load->view('templates/head_login', $data);
		$this->load->view('login/login');
	}

	public function device() {
		$name = trim($this->input->post('device'));
		$src = $this->Crud->search('device', array('name' => $name))->num_rows();
		if ($src > 0) {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                Name <b>"' . $name . '"</b> is already on database!
              </div>');
		} else {
			$data = array('name' => $name);
			$this->Crud->insert('device', $data);
			$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                Device <b>"' . $name . '"</b> is added on database!
              </div>');
		}
		redirect(base_url('Dash/device'));
	}

	public function enum($enum='') {
		$name = trim($this->input->post('name'));
		$device = !$this->input->post('device') ? 0 : trim($this->input->post('device'));
		$alias = !$this->input->post('alias') ? '' : trim($this->input->post('alias'));
		$type = strtolower(trim($enum));
		$src = $this->Crud->search('enum', array('name' => $name, 'device_id' => $device, 'type' => $enum))->num_rows();
		if ($src > 0) {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                Name <b>"' . $name . '"</b> is already on ' . $enum .'!
              </div>');
		} else {
			$data = array('name' => $name, 'device_id' => $device, 'type' => $type, 'alias' => $alias);
			$this->Crud->insert('enum', $data);
			$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                <b>"' . $name . '"</b> is added on ' . $enum .'!
              </div>');
		}
		if ($enum == 'bd_type' || $enum == 'series' || $enum == 'unit_type' || $enum == 'antenna' || $enum == 'code_unit' || $enum == 'poweroff') {
			$enum = 'other';
		}
		redirect(base_url('Dash/' . $enum));
	}

	public function periodic() {
		$year = trim($this->input->post('year'));
		$month = trim($this->input->post('month'));
		$src = $this->Crud->search('periodic_pm', array('year' => $year))->num_rows();
		if ($src > 0) {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                Year <b>"' . $year . '"</b> is already on database!
              </div>');
		} else {
			if ($month > 0 && $month <= 12) {
				$time = 'P' . $month . 'M';
				$data = array('year' => $year, 'time_period' => $time);
				$this->Crud->insert('periodic_pm', $data);
				$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible">
	                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	                <h4><i class="icon fa fa-check"></i> Success!</h4>
	                <b>"' . $year . '"</b> is added!
	              </div>');
			} else {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                Insert error, please check your data again!
              </div>');
			}
		}
		redirect(base_url('Dash/periodic'));
	}

	public function people() {
		$username = trim($this->input->post('username'));
		$name = trim($this->input->post('name'));
		$password = password_hash(trim($this->input->post('pass')), PASSWORD_DEFAULT);
		$description = trim($this->input->post('description'));
		$level = trim($this->input->post('level'));
		$src = $this->Crud->search('user', array('username' => $username))->num_rows();
		if ( preg_match('/[^A-Za-z0-9]/',$username)) {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible">
	                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
	                Insert error, username only allowed number and alfabet!
	              </div>');
		} else {
			if ($src > 0) {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible">
	                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
	                Username <b>"' . $username . '"</b> is already on database!
	              </div>');
			} else {
				$src = $this->Crud->search('enum', array('id' => $level, 'type' => 'level'))->num_rows();
				if ($src > 0) {
					$data = array(
						'username' => $username,
						'name' => $name,
						'password' => $password,
						'description' => $description,
						'level' => $level
					);
					$this->Crud->insert('user', $data);
					$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible">
		                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		                <h4><i class="icon fa fa-check"></i> Success!</h4>
		                <b>"' . $name . '"</b> is added on database!
		              </div>');
				} else {
					$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible">
	                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
	                Insert error, please check your data again!
	              </div>');				
				}
			}
		}
		
		redirect(base_url('Dash/people'));
	}

	public function relations() {
		$category = !$this->input->post('category') ? '' : trim($this->input->post('category'));
		$problem = !$this->input->post('problem') ? '' : trim($this->input->post('problem'));
		$analysis = !$this->input->post('analysis') ? '' : trim($this->input->post('analysis'));
		$cause = !$this->input->post('cause') ? '' : trim($this->input->post('cause'));
		$action = !$this->input->post('action') ? '' : trim($this->input->post('action'));
		$remark = !$this->input->post('remark') ? '' : trim($this->input->post('remark'));
		$device = !$this->input->post('device') ? 1 : trim($this->input->post('device'));
		$src = $this->Crud->search('relations', array('category' => $category, 'problem' => $problem, 'analysis' => $analysis, 'cause' => $cause, 'action' => $action, 'remark' => $remark, 'device_id' => $device))->num_rows();
		if ($src > 0) {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                <b>"Relations"</b> is already on database!
              </div>');
		} else {
			$category_src = $this->Crud->search('enum', array('id' => $category))->num_rows();
			$problem_src = $this->Crud->search('enum', array('id' => $problem))->num_rows();
			$analysis_src = $this->Crud->search('enum', array('id' => $analysis))->num_rows();
			$cause_src = $this->Crud->search('enum', array('id' => $cause))->num_rows();
			$action_src = $this->Crud->search('enum', array('id' => $action))->num_rows();
			$remark_src = $this->Crud->search('enum', array('id' => $remark))->num_rows();
			if (
				$category_src > 0 ||
				$problem_src > 0 ||
				$analysis_src > 0 ||
				$cause_src > 0 ||
				$action_src > 0 ||
				$remark_src > 0
			) {
				$data = array('category' => $category, 'problem' => $problem, 'analysis' => $analysis, 'cause' => $cause, 'action' => $action, 'remark' => $remark, 'device_id' => $device);
				$this->Crud->insert('relations', $data);
				$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible">
	                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	                <h4><i class="icon fa fa-check"></i> Success!</h4>
	                <b>"Relations"</b> is added on database!
	              </div>');
			} else {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                Insert error, please check your data again!
              </div>');
			}
		}
		redirect(base_url('Dash/relations'));
	}

	public function unit($dev='') {
		$id = $this->input->post('id') == '' ? '' : strtoupper($this->input->post('id'));
		$series = $this->input->post('series') == '' ? '' : $this->input->post('series');
		$type = $this->input->post('type') == '' ? '' : $this->input->post('type');
		$code_unit = $this->input->post('code_unit') == '' ? '' : $this->input->post('code_unit');
		$description = $this->input->post('description') == '' ? '' : $this->input->post('description');
		$position = $this->input->post('position') == '' ? '' : $this->input->post('position');
		$sn_display = $this->input->post('sn_display') == '' ? '' : $this->input->post('sn_display');
		$sn_wb = $this->input->post('sn_wb') == '' ? '' : $this->input->post('sn_wb');
		$sn_gps = $this->input->post('sn_gps') == '' ? '' : $this->input->post('sn_gps');
		$antenna = $this->input->post('antenna') == '' ? '' : $this->input->post('antenna');
		$status = $this->input->post('status') == '' ? '' : $this->input->post('status');
		$poweroff = $this->input->post('poweroff') == '' ? '' : $this->input->post('poweroff');
		$locked = $this->input->post('locked') == '' ? '' : $this->input->post('locked');
		$explode = $this->input->post('explode') == '' ? '' : $this->input->post('explode');
		$location = $this->input->post('location') == '' ? '' : $this->input->post('location');
		$device_id = $this->input->post('device') == '' ? '' : $this->input->post('device');
		$battery = $this->input->post('battery') == '' ? '' : ';' . $this->input->post('battery');
		
		if (
			$id != '' &&
			$description != '' &&
			$position != '' &&
			($status != '' || $status == '0' || $status == '1' || $status == '2') &&
			$device_id != ''
		) {
			$src = $this->Crud->search('unit', array('id' => $id))->num_rows();
			if ($src > 0) {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible">
	                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
	                <b>"' . $id . '"</b> is already on database!
	              </div>');
			} else {
				$this->Crud->insert('unit', array('id' => $id, 'series' => $series, 'type' => $type, 'code_unit' => $code_unit, 'description' => $description, 'position' => $position, 'sn_display' => $sn_display, 'sn_wb' => $sn_wb, 'sn_gps' => $sn_gps, 'antenna' => $antenna, 'status' => $status, 'poweroff' => $poweroff, 'locked' => $locked, 'explode' => $explode, 'device_id' => $device_id, 'location' => $location, 'explode' => $battery));
				$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible">
	                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	                <h4><i class="icon fa fa-check"></i> Success!</h4>
	                <b>"' . $id . '"</b> is added on database!
	              </div>');
			}
		} else {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-ban"></i> Alert!</h4>
            Insert error, field cannot empty!
          </div>');
		}
		redirect(base_url('Dash/unit/' . $dev));
	}
}
