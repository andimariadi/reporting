<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Delete extends CI_Controller {

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
		$username = $this->session->userdata('username');
		$level = $this->session->userdata('level');
		if(empty($username)){
			redirect(base_url("Auth"));
		}
		if($level == 'teknisi'){
			redirect(base_url("report"));
		}
	}

	public function index ($page = 'Homepage') {
		$data['title'] = $page;
		$this->load->view('templates/head', $data);
		$this->load->view('pages/home');
	}

	public function device()
	{
		$id = $this->input->post('del');
		$src = $this->Crud->search('device', array('id' => $id))->num_rows();
		if ($src > 0) {
			$this->Crud->delete('device', array('id' => $id));
			$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                Device has been deleted!
              </div>');
		} else {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                Device not ready on database!
              </div>');
		}
	}

	public function enum()
	{
		$id = $this->input->post('del');
		$src = $this->Crud->search('enum', array('id' => $id))->num_rows();
		if ($src > 0) {
			$this->Crud->delete('enum', array('id' => $id));
			$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                Data has been deleted!
              </div>');
		} else {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                Data not ready on database!
              </div>');
		}
	}

	public function unit()
	{
		$id = $this->input->post('del');
		$src = $this->Crud->search('unit', array('id' => $id))->num_rows();
		if ($src > 0) {
			$this->Crud->delete('unit', array('id' => $id));
			$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                Unit has been deleted!
              </div>');
		} else {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                Unit not found on database!
              </div>');
		}
	}

	public function periodic()
	{
		$id = $this->input->post('del');
		$src = $this->Crud->search('periodic_pm', array('id' => $id))->num_rows();
		if ($src > 0) {
			$this->Crud->delete('periodic_pm', array('id' => $id));
			$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                Data has been deleted!
              </div>');
		} else {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                Data not ready on database!
              </div>');
		}
	}

	public function people()
	{
		$id = $this->input->post('del');
		$src = $this->Crud->search('user', array('id' => $id))->num_rows();
		if ($src > 0) {
			$this->Crud->delete('user', array('id' => $id));
			$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                People has been deleted!
              </div>');
		} else {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                People not found on database!
              </div>');
		}
	}

	public function relations()
	{
		$id = $this->input->post('del');
		$src = $this->Crud->search('relations', array('id' => $id))->num_rows();
		if ($src > 0) {
			$this->Crud->delete('relations', array('id' => $id));
			$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                Relations has been deleted!
              </div>');
		} else {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                Relations not found on database!
              </div>');
		}
	}

	public function report()
	{
		$id = $this->input->post('del');
		$src = $this->Crud->search('report', array('id' => $id))->num_rows();
		if ($src > 0) {
			$this->Crud->delete('pic_report', array('report_id' => $id));
			$this->Crud->delete('report', array('id' => $id));
			$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                Relations has been deleted!
              </div>');
		} else {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                Relations not found on database!
              </div>');
		}
	}
}
