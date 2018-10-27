<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Edit extends CI_Controller {

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
		} elseif (!$level) {
			redirect(base_url('Auth'));
		}
	}

	public function index ($page = 'Login') {
		$data['title'] = $page;
		$this->load->view('templates/head_login', $data);
		$this->load->view('login/login');
	}

	public function device() {
		$id = trim($this->input->post('id'));
		$name = trim($this->input->post('device'));
		$src = $this->Crud->search('device', array('id' => $id))->num_rows();
		if ($src > 0) {
			$same = $this->Crud->search('device', array('name' => $name))->num_rows();
			if ($same > 0) {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                Name <b>"' . $name . '"</b> is already on database!
              </div>');
			} else {
				$this->Crud->update('device', array('id' => $id), array('name' => $name));
				$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                Device <b>"' . $name . '"</b> has been modified!
              </div>');
			}
		} else {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                Device <b>"' . $id . '/' . $name . '"</b> not ready on database!
              </div>');
		}
	}

	public function level() {
		$id = trim($this->input->post('id'));
		$name = trim($this->input->post('name'));
		$src = $this->Crud->search('enum', array('id' => $id))->num_rows();
		if ($src > 0) {
			$same = $this->Crud->search('enum', array('name' => $name, 'type' => 'level'))->num_rows();
			if ($same > 0) {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                Name <b>"' . $name . '"</b> is already on database!
              </div>');
			} else {
				$this->Crud->update('enum', array('id' => $id), array('name' => $name));
				$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                Name <b>"' . $name . '"</b> has been modified!
              </div>');
			}
		} else {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                Device <b>"' . $id . '/' . $name . '"</b> not ready on database!
              </div>');
		}
	}

	public function people() {
		$id = trim($this->input->post('id'));
		$username = trim($this->input->post('username'));
		$name = trim($this->input->post('name'));
		$description = trim($this->input->post('description'));
		$level = trim($this->input->post('level'));
		$src = $this->Crud->search('user', array('id' => $id))->num_rows();
		if ($src > 0) {
			$src = $this->Crud->search('enum', array('id' => $level, 'type' => 'level'))->num_rows();
			if ($src > 0) {
				$data = array(
					'username' => $username,
					'name' => $name,
					'description' => $description,
					'level' => $level
				);
				$this->Crud->update('user', array('id' => $id), $data);
				$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible">
	                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	                <h4><i class="icon fa fa-check"></i> Success!</h4>
	                <b>"' . $username . '"</b> has been modified!
	              </div>');
			} else {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                Insert error, please check your data agarin!
              </div>');				
			}
		} else {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                Data not found on database!
              </div>');
		}
	}

	public function reset_password() {
		$id = trim($this->input->post('id'));
		$username = trim($this->input->post('username'));
		$password = password_hash(trim($username), PASSWORD_DEFAULT);
		$src = $this->Crud->search('user', array('id' => $id, 'username' => $username))->num_rows();
		if ($src > 0) {
			$data = array(
				'id' => $id,
				'password' => $password
			);
			$this->Crud->update('user', array('id' => $id), $data);
			$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                <b>"' . $username . '"</b> has been default password!
              </div>');
		} else {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                Data not found on database!
              </div>');
		}
	}

	public function category() {
		$id = trim($this->input->post('id'));
		$name = trim($this->input->post('name'));
		$device = trim($this->input->post('device'));
		$src = $this->Crud->search('enum', array('id' => $id))->num_rows();
		if ($src > 0) {
			$same = $this->Crud->search('enum', array('name' => $name, 'type' => 'category', 'device_id' => $device))->num_rows();
			if ($same > 0) {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                Name <b>"' . $name . '"</b> is already on database!
              </div>');
			} else {
				$src = $this->Crud->search('device', array('id' => $device))->num_rows();
				if ($src > 0) {
					$this->Crud->update('enum', array('id' => $id), array('name' => $name));
					$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible">
	                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	                <h4><i class="icon fa fa-check"></i> Success!</h4>
	                Name <b>"' . $name . '"</b> has been modified!
	              </div>');
				} else {
					$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible">
	                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
	                Insert error, please check your data agarin!
	              </div>');
				}
			}
		} else {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                Device <b>"' . $id . '/' . $name . '"</b> not ready on database!
              </div>');
		}
	}

	public function enum() {
		$id = trim($this->input->post('id'));
		$name = trim($this->input->post('name'));
		$alias = !$this->input->post('alias') ? '' : trim($this->input->post('alias'));
		$src = $this->Crud->search('enum', array('id' => $id))->num_rows();
		if ($src > 0) {
			$src_1 = $this->Crud->search('enum', array('id' => $id))->row_array();
			$this->Crud->update('enum', array('id' => $id), array('name' => $name, 'alias' => $alias));
			$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<h4><i class="icon fa fa-check"></i> Success!</h4>
			Name <b>"' . $src_1['name'] . '"</b> has been modif to "' . $name . '"!
			</div>');
		} else {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                Device <b>"' . $id . '/' . $name . '"</b> not ready on database!
              </div>');
		}
	}

	public function unit($dev='') {
		$old = $this->input->post('old') == '' ? '' : $this->input->post('old');
		$id = $this->input->post('id') == '' ? '' : $this->input->post('id');
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
			$src = $this->Crud->search('unit', array('id' => $old))->num_rows();
			if ($src > 0) {
				$src_new = $this->Crud->search('unit', array('id' => $id))->num_rows();
				if ($src_new == 0 || $old == $id) {
					$this->Crud->update('unit', array('id' => $old), array('id' => $id, 'series' => $series, 'type' => $type, 'code_unit' => $code_unit, 'description' => $description, 'position' => $position, 'sn_display' => $sn_display, 'sn_wb' => $sn_wb, 'sn_gps' => $sn_gps, 'antenna' => $antenna, 'status' => $status, 'poweroff' => $poweroff, 'locked' => $locked, 'explode' => $explode, 'location' => $location, 'explode' => $battery,'device_id' => $device_id));
					$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible">
		                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		                <h4><i class="icon fa fa-check"></i> Success!</h4>
		                <b>"' . $old . '"</b> has been modified!
		              </div>');
				} else {
					$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible">
		                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
		                <b>"' . $id . '"</b> is already on database</b>!
		              </div>');
				}
			} else {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible">
	                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
	                <b>"' . $old . '"</b> not found!
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

	public function report()
	{
		//print_r($_POST);
		$id 			= strtoupper(trim($this->input->post('id')));
		$date 			= trim($this->input->post('date'));
		$shift 			= trim($this->input->post('shift'));
		$unit 			= strtoupper(trim($this->input->post('unit')));
		$bd 			= trim($this->input->post('bd'));
		$startwait 		= trim($this->input->post('startwait'));
		$endwait 		= trim($this->input->post('endwait'));
		$startaction 	= trim($this->input->post('startaction'));
		$endaction 		= trim($this->input->post('endaction'));
		$location 		= trim($this->input->post('location'));
		$problem 		= trim($this->input->post('problem'));
		$analysis 		= trim($this->input->post('analysis'));
		$cause 			= trim($this->input->post('cause'));
		$action 		= trim($this->input->post('action'));
		$remark 		= trim($this->input->post('remark'));
		$bd_rec 		= trim($this->input->post('bd_rec'));
		$rfu_rec 		= trim($this->input->post('rfu_rec'));
		$status 		= trim($this->input->post('status'));
		$tproblem 		= $shift==1 ? '07:00' : '17:00';

		//for other activity
		$action_o 		= trim($this->input->post('action-o'));
		$remark_o 		= trim($this->input->post('remark-o'));
		$src = $this->Crud->search('report', array('id' => $id))->num_rows();
		$dev = $this->Crud->search('report', array('id' => $id))->row_array();
		if ($src > 0) {
			if ($dev['device_id'] == 3) {
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
						'other' => $other
					);
					$this->Crud->update('report', array('id'=> $id),$data);
					$this->db->trans_complete();
					//transaction end;
					$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible">
				                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				                <h4><i class="icon fa fa-ban"></i> Success!</h4>
				                Activity has been added!
				              </div>');
				} else {
					$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible">
		                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
		                Insert error, field cannot empty!
		              </div>');
				}
			} else {
				if (
					$unit != '' &&
					$location != '' &&
					$bd_rec != '' &&
					$rfu_rec != '' &&
					$startaction != '' &&
					$endaction != '' &&
					$problem != '' &&
					$analysis != '' &&
					$cause != '' &&
					$action != '' &&
					$remark != '' &&
					($status != ''|| $status == 1 || $status == 0)
				) {
					$src_unit = $this->Crud->search('unit', array('id' => $unit))->num_rows();
					if ($src_unit > 0) {
						$relation = $this->Crud->sql_query("SELECT * FROM `relations` WHERE `problem` = '{$problem}' AND `analysis` = '{$analysis}' AND `cause` = '{$cause}' AND `action` = '{$action}'")->row_array();
						if ($relation > 0) {
							$this->db->trans_start();
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
								'activity' => $action,
								'time_problem'	=> $tproblem,
								'start_waiting' => $startwait,
								'end_waiting' => $endwait,
								'start_action' => $startaction,
								'end_action' => $endaction,
								'bd_receiver' => $bd_rec,
								'rfu_receiver' => $rfu_rec,
								'status' => $status,
								'remark' => $remark,
								'other' => $action_o
							);
							$this->Crud->update('report', array('id' => $id),$data);
							$this->db->trans_complete();
							$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible">
				                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				                <h4><i class="icon fa fa-check"></i> Success!</h4>
				                Report has been modified!
				              </div>');
						} else {
							$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible">
				                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
				                Insert error, please check your data again!
				              </div>');	
						}
					} else {
						$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible">
			                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
			                <b>"' . $unit . '"</b> not found!
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
		} else {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible">
	                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
	                ID Report not found!
	              </div>');
		}
	}

	public function profile() {
		$username_ = $this->session->userdata('username');
		$name = trim($this->input->post('name'));
		$description = trim($this->input->post('description'));
		$src = $this->Crud->search('user', array('username' => $username_))->num_rows();
		if ($src > 0) {
			$data = array(
				'name' => $name,
				'description' => $description
			);
			$this->Crud->update('user', array('username' => $username_), $data);
			$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> Success!</h4>
            Hello <b>"' . $name . '"</b> your profile is up to date now!
          </div>');
		}
		
		redirect(base_url('Dash/profile'));
	}

	public function password() {
		$username_ = $this->session->userdata('username');
		$oldpass = trim($this->input->post('oldpass'));
		$newpass = trim($this->input->post('newpass'));
		$repass = trim($this->input->post('repass'));
		$src = $this->Crud->search('user', array('username' => $username_))->num_rows();
		if ($src > 0) {
			if ($newpass == $repass) {
				$data = $this->Crud->search('user', array('username' => $username_))->row_array();
				if (password_verify($oldpass, $data['password'])) {
					$data = array(
						'password' => password_hash($newpass, PASSWORD_DEFAULT)
					);
					$this->Crud->update('user', array('username' => $username_), $data);
					$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible">
		                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		                <h4><i class="icon fa fa-check"></i> Success!</h4>
		                Hello <b>"' . $name . '"</b> your profile is up to date now!
		              </div>');
				} else {
					$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible">
			                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
			                Password wrong!
			                </div>');
				}
			} else {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible">
		                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
		                Password does not match!
		              </div>');
				
			}
		}
		
		redirect(base_url('Dash/profile'));
	}
}

