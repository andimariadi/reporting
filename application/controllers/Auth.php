<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

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
	}

	public function index ($err = '') {
		if ($err == 'session') {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible">
	                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
	                <b>Error!</b>. Session has expired! Please re-login :)
	                </div>');
			redirect(base_url('Auth'));
	    }
		$this->load->view('templates/head_login', array('title' => 'Login'));
		$this->load->view('login/login');
	}

	public function action()
	{
		$username = trim($this->input->post('username'));
		$password = trim($this->input->post('password'));
		$where = array('username' => $username);
		$data = $this->crud->sql_query("SELECT `user`.`username`, `user`.`password`, `user`.`name`,`enum`.`name` as `level` FROM `user` LEFT JOIN `enum` ON `user`.`level` = `enum`.`id` WHERE `user`.`username` = '" . $username . "'")->row_array();
		if (password_verify($password, $data['password'])) {
			$this->Crud->update('user', array('username' => $username), array('last_login' => date('Y-m-d H:i:s', strtotime('+ 10 minutes'))));
			$session_data = array('id' => $data['id'],'username' => $data['username'], 'name' => $data['name'], 'level' => $data['level']);
			$this->session->set_userdata($session_data);
			redirect(base_url('dash'));
		} else {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible">
	                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
	                Username or password wrong!
	                </div>');
			redirect(base_url('Auth'));
		}
		
	}

	public function logout($err = '')
	{
		$this->session->sess_destroy();
		$cookies = explode(';', $_SERVER['HTTP_COOKIE']);
	    foreach($cookies as $cookie) {
	        $parts = explode('=', $cookie);
	        $name = trim($parts[0]);
	        delete_cookie($name);
	        delete_cookie($name);
	    }
	    if ($err == 'session') {
	    	$err = '/index/session';
	    }
		redirect(base_url('Auth' . $err));
	}

	public function install()
	{
		$x = $this->Crud->search('enum', array('name' => 'supervisor', 'type' => 'level'))->row_array();
		$src = $this->Crud->sql_query("SELECT * FROM `user` WHERE `level` = {$x['id']}")->num_rows();
		if ($src > 0) {
			redirect(base_url('errors'));
		} else {
			$this->load->view('templates/head_login', array('title' => 'ReportingMDI | Install'));
			$this->load->view('login/install');
		}
	}

	public function install_action()
	{
		print_r($_POST);
		$username = trim($this->input->post('username'));
		$name = trim($this->input->post('name'));
		$password = password_hash(trim($this->input->post('password')), PASSWORD_DEFAULT);
		$description = trim($this->input->post('description'));
		$src = $this->Crud->search('user', array('username' => $username))->num_rows();
		if ( preg_match('/[^A-Za-z0-9]/',$username)) {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible">
	                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
	                Insert error, username only allowed number and alfabet!
	              </div>');
			redirect(base_url('Auth/install'));
		} else {
			if (trim($this->input->post('password')) == trim($this->input->post('repassword'))) {
				$this->db->trans_start();
				if ($src > 0) {
					$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible">
		                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
		                Username <b>"' . $username . '"</b> is already on database!
		              </div>');
					redirect(base_url('Auth/install'));
				} else {
					$src = $this->Crud->search('enum', array('name' => 'supervisor', 'type' => 'level'))->num_rows();
					if ($src > 0) {
						$x = $this->Crud->search('enum', array('name' => 'supervisor', 'type' => 'level'))->row_array();
						$data = array(
							'username' => $username,
							'name' => $name,
							'password' => $password,
							'description' => $description,
							'level' => $x['id']
						);
						$this->Crud->insert('user', $data);
					} else {
						$data = array(
							'name' => 'supervisor',
							'type' => 'level'
						);
						$this->Crud->insert('enum', $data);
						$level = $this->db->insert_id();
						$data = array(
							'username' => $username,
							'name' => $name,
							'password' => $password,
							'description' => $description,
							'level' => $level
						);
						$this->Crud->insert('user', $data);
					}
					$this->db->trans_complete();
					$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible">
		                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		                <h4><i class="icon fa fa-check"></i> Success!</h4>
		                <b>"' . $name . '"</b> is added on database!
		              </div>');
					redirect(base_url('Auth'));
				}
			} else {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible">
		                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
		                Passwords do not match!
		              </div>');
				redirect(base_url('Auth/install'));
			}
		}
	}
}
