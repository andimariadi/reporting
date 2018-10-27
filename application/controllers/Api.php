<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

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

		if ($level == '') {
			redirect(base_url('Auth'));
		}
	}

	public function index ($page = 'Homepage') {
		$data['title'] = $page;
		$this->load->view('templates/head', $data);
		$this->load->view('pages/home');
	}

	public function device($id ='') {
		$sql = $this->Crud->search('device', array('id' => $id))->result_array();
		if(count($sql) > 0 ){
		  $response = array();
		  $response["data"] = array();
		  foreach ($sql as $x) {
		    $h['id'] = $x["id"];
		    $h['name'] = $x["name"];
		    array_push($response["data"], $h);
		  }
		}else {
		  $response["data"]="empty";  
		}
		echo json_encode($response);
	}

	public function enum($id ='') {
		$sql = $this->Crud->search('enum', array('id' => $id))->result_array();
		if(count($sql) > 0 ){
		  $response = array();
		  $response["data"] = array();
		  foreach ($sql as $x) {
		    $h['id'] = $x["id"];
		    $h['name'] = $x["name"];
		    $h['alias'] = $x["alias"];
		    $h['type'] = $x["type"];
		    $h['device_id'] = $x["device_id"];
		    array_push($response["data"], $h);
		  }
		}else {
		  $response["data"]="empty";  
		}
		echo json_encode($response);
	}

	public function people($id ='') {
		$sql = $this->Crud->search('user', array('id' => $id))->result_array();
		if(count($sql) > 0 ){
		  $response = array();
		  $response["data"] = array();
		  foreach ($sql as $x) {
		    $h['id'] = $x["id"];
		    $h['username'] = $x["username"];
		    $h['name'] = $x["name"];
		    $h['description'] = $x["description"];
		    $h['level'] = $x["level"];
		    $h['last_login'] = $x['last_login'];
		    array_push($response["data"], $h);
		  }
		}else {
		  $response["data"]="empty";  
		}
		echo json_encode($response);
	}

	public function status_user($user ='') {
		$sql = $this->Crud->search('user', array('username' => $user))->result_array();
		if(count($sql) > 0 ){
		  foreach ($sql as $x) {
			if (strtotime(date('Y-m-d H:i:s')) >= strtotime($x['last_login'])) {
				$status = '<i class="fa fa-circle text-danger"></i> Offline';
			} else {
				$status = '<i class="fa fa-circle text-success"></i> Online';
			}
		    $response = $status;
		  }

		}else {
		  $response="empty";  
		}
		echo($response);
	}

	public function unit($id ='') {
		$id = str_replace('%20', ' ', $id);
		$id = strtoupper($id);
		$sql = $this->Crud->search('unit', array('id' => $id))->result_array();
		if(count($sql) > 0 ){
		  $response = array();
		  $response["data"] = array();
		  foreach ($sql as $x) {
		  	$battery = empty(explode(';', $x['explode'])[1]) ? null : explode(';', $x['explode'])[1];
		  	$h['id'] = $x['id'];
			$h['series'] = $x['series'];
			$h['type'] = $x['type'];
			$h['code_unit'] = $x['code_unit'];
			$h['description'] = $x['description'];
			$h['position'] = $x['position'];
			$h['sn_display'] = $x['sn_display'];
			$h['sn_wb'] = $x['sn_wb'];
			$h['sn_gps'] = $x['sn_gps'];
			$h['antenna'] = $x['antenna'];
			$h['status'] = $x['status'];
			$h['poweroff'] = $x['poweroff'];
			$h['locked'] = $x['locked'];
			$h['explode'] = $x['explode'];
			$h['location'] = $x['location'];
			$h['battery'] = $battery;
			$h['device_id'] = $x['device_id'];
		    array_push($response["data"], $h);
		  }
		}else {
		  $response["data"]="empty";  
		}
		echo json_encode($response);
	}

	public function relations($problem = '', $analysis = '', $cause = '', $action = '', $remark = '') {
		$problem = !$problem ? '' : trim($problem);
		$analysis = !$analysis ? '' : trim($analysis);
		$cause = !$cause ? '' : trim($cause);
		$action = !$action ? '' : trim(urldecode($action));
		$remark = !$remark ? '' : trim($remark);
		if ($problem != '' && $analysis == '' && $cause == '' && $action == '' && $remark == '') {

			$sql = $this->Crud->sql_query("SELECT `enum`.`id`, `enum`.`name`, `enum`.`alias` FROM `relations` LEFT JOIN `enum` ON `relations`.`analysis` = `enum`.`id` WHERE `problem` = '{$problem}' GROUP BY `enum`.`id`");

		} elseif ($problem != '' && $analysis != '' && $cause == '' && $action == '' && $remark == '') {

			$sql = $this->Crud->sql_query("SELECT `enum`.`id`, `enum`.`name`, `enum`.`alias` FROM `relations` LEFT JOIN `enum` ON `relations`.`cause` = `enum`.`id` WHERE `problem` = {$problem} AND `analysis` = {$analysis} GROUP BY `enum`.`id`");

		} elseif ($problem != '' && $analysis != '' && $cause != '' && $action == '' && $remark == '') {

			$sql = $this->Crud->sql_query("SELECT `enum`.`id`, `enum`.`name`, `enum`.`alias` FROM `relations` LEFT JOIN `enum` ON `relations`.`action` = `enum`.`id` WHERE `problem` = {$problem} AND `analysis` = {$analysis} AND `cause` = {$cause} GROUP BY `enum`.`id`");

		} elseif ($problem != '' && $analysis != '' && $cause != '' && $action != '' && $remark == '') {
			$sql = $this->Crud->sql_query("SELECT `enum`.`id`, `enum`.`name`, `enum`.`alias` FROM `relations` LEFT JOIN `enum` ON `relations`.`remark` = `enum`.`id` WHERE `problem` = {$problem} AND `analysis` = {$analysis} AND `cause` = {$cause} AND `action` IN ({$action}) GROUP BY `enum`.`id`");

		} elseif($problem != '' && $analysis != '' && $cause != '' && $action != '' && $remark != '') {
			$sql = $this->Crud->sql_query("SELECT `enum`.`id`, `enum`.`name`, `enum`.`alias` FROM `relations` LEFT JOIN `enum` ON `relations`.`remark` = `enum`.`id` WHERE `problem` = {$problem} AND `analysis` = {$analysis} AND `cause` = {$cause} AND `action` IN ({$action}) AND `remark` = {$remark} GROUP BY `enum`.`id`");

		} else {
			$sql = $this->Crud->sql_query("SELECT `relations`.`id`, `relations`.`category`, `relations`.`problem`, `relations`.`analysis`, `relations`.`cause`, `relations`.`action`, `relations`.`remark`, `prob`.`name` as `prob_name`, `ana`.`name` as `ana_name`, `cau`.`name` as `cau_name`, `act`.`name` as `act_name`, `rem`.`name` as `rem_name` FROM `relations` LEFT JOIN `enum` as `prob` ON `relations`.`problem` = `prob`.`id` LEFT JOIN `enum` as `ana` ON `relations`.`analysis` = `ana`.`id` LEFT JOIN `enum` as `cau` ON `relations`.`cause` = `cau`.`id` LEFT JOIN `enum` as `act` ON `relations`.`action` = `act`.`id` LEFT JOIN `enum` as `rem` ON `relations`.`remark` = `rem`.`id`");
		}
		if($sql->num_rows() > 0 ){
		  $response = array();
		  $response["data"] = array();
		  foreach ($sql->result_array() as $x) {
		  	$h['id'] = $x["id"];
		  	$h['name'] = $x["name"];
		  	$h['alias'] = $x["alias"];
		    array_push($response["data"], $h);
		  }
		}else {
		  $response["data"]="empty";  
		}
		echo json_encode($response);
	}

	public function backlog($value='')
	{
		$id = trim(addslashes(strtoupper($value)));
		$sql = $this->Crud->query("SELECT `backlog`.`id`, `backlog`.`backlog`, `backlog`.`value`, `enum`.`name` as `backlog_name` FROM `backlog` LEFT JOIN `enum` ON `backlog`.`backlog` = `enum`.`id` WHERE `backlog`.`unit_id` = '{$id}' AND `backlog`.`value` = '0'");
		if(count($sql) > 0 ){
		  $response = array();
		  $response["data"] = array();
		  foreach ($sql as $x) {
		  	$h['id'] = $x['id'];
			$h['backlog'] = $x['backlog'];
			$h['value'] = $x['value'];
			$h['backlog_name'] = $x['backlog_name'];
		    array_push($response["data"], $h);
		  }
		}else {
		  $response["data"]="empty";  
		}
		echo json_encode($response);
	}

	public function date_report($dev_id = '', $year='')
	{
		$id = trim(addslashes(strtoupper($dev_id)));
		if ($year == '') {
			$sql = $this->Crud->query("SELECT YEAR(`date`) as `date` FROM `report` WHERE `device_id` = {$id} GROUP BY YEAR(`date`)");
		} else {
			$sql = $this->Crud->query("SELECT MONTH(`date`) as `date` FROM `report` WHERE `device_id` = {$id} AND  YEAR(`date`) = '{$year}' GROUP BY MONTH(`date`)");
		}
		if(count($sql) > 0 ){
		  $response = array();
		  $response["data"] = array();
		  foreach ($sql as $x) {
		  	$h['date'] = $x['date'];
		    array_push($response["data"], $h);
		  }
		}else {
		  $response["data"]="empty";  
		}
		echo json_encode($response);
	}

	public function report($id='')
	{
		$id = trim(addslashes(strtoupper($id)));
		$sql = $this->Crud->search('report', array('id' => $id))->result_array();
		if(count($sql) > 0 ){
		  $response = array();
		  $response["data"] = array();
		  foreach ($sql as $x) {
		  	$action_o = @!explode('[||]', $x['other'])[0] ? '' : explode('[||]', $x['other'])[0];
		  	$remark_o = @!explode('[||]', $x['other'])[1] ? '' : explode('[||]', $x['other'])[1];
		  	$h['id'] 			= $x['id'];
			$h['updated_date'] 	= $x['updated_date'];
			$h['date'] 			= $x['date'];
			$h['shift'] 		= $x['shift'];
			$h['unit_id'] 		= $x['unit_id'];
			$h['bd_type'] 		= $x['bd_type'];
			$h['problem'] 		= $x['problem'];
			$h['category'] 		= $x['category'];
			$h['location'] 		= $x['location'];
			$h['analysis'] 		= $x['analysis'];
			$h['cause'] 		= $x['cause'];
			$h['activity'] 		= $x['activity'];
			$h['time_problem'] 	= $x['time_problem'];
			$h['start_waiting'] = $x['start_waiting'];
			$h['end_waiting'] 	= $x['end_waiting'];
			$h['start_action'] 	= $x['start_action'];
			$h['end_action'] 	= $x['end_action'];
			$h['bd_receiver'] 	= $x['bd_receiver'];
			$h['rfu_receiver'] 	= $x['rfu_receiver'];
			$h['status'] 		= $x['status'];
			$h['remark'] 		= $x['remark'];
			$h['action-o'] 		= $action_o;
			$h['remark-o'] 		= $remark_o;
			$h['device_id'] 	= $x['device_id'];
		    array_push($response["data"], $h);
		  }
		}else {
		  $response["data"]="empty";  
		}
		echo json_encode($response);
	}

	public function old_chart($dev_id='', $data ='', $date = '') {
		$data = urldecode($data);
		if ($data == 1 || $data == '') {
			$data = "SELECT `id` FROM `enum` WHERE `type` = 'analysis' AND `device_id` = {$dev_id}";
		}
		if ($date == '7day') {
			$start_date = date('Y-m-d', strtotime('-7 day'));
			$end_date = date('Y-m-d');
		} elseif ($date == 'thismonth') {
			$start_date = date('Y-m-1');
			$end_date = date('Y-m-t');
		} elseif ($date == 'lastmonth') {
			$start_date = date('Y-m-1', strtotime('-1 month'));
			$end_date = date('Y-m-t', strtotime('-1 month'));
		} elseif ($date == '30day') {
			$start_date = date('Y-m-d', strtotime('-30 day'));
			$end_date = date('Y-m-d');
		} else {
			$start_date = date('Y-m-d', strtotime('-7 day'));
			$end_date = date('Y-m-d');
		}
		$dev = $this->Crud->search('device', array('id' => $dev_id))->row_array()['name'];
		
		?>
	    google.charts.load('current', {'packages':['line']});
	    google.charts.setOnLoadCallback(drawChart);

	    function drawChart() {

	      var data = new google.visualization.DataTable();
	      data.addColumn('number', 'Day');
	      <?php
	       	$query = $this->Crud->query("SELECT `date`, `enum`.`id`, `enum`.`name`, COUNT(`date`) `count` FROM `report`
	      	LEFT JOIN `enum` ON `report`.`analysis` = `enum`.`id`
	      	WHERE `analysis` IN ({$data}) AND `date` BETWEEN '{$start_date}' AND '{$end_date}' AND `report`.`device_id` = '{$dev_id}' GROUP BY `analysis`");
	      $val = "";
	      $no = 0;
	      foreach ($query as $value) {
	      	$no++;
	      	echo "data.addColumn('number', '{$value['name']}');";
	      	$val .= ", COUNT(IF(`enum`.`id` = '{$value['id']}', `analysis`, NULL)) AS name_$no";
	      }
	      ?>

	      data.addRows([
	      	<?php
	      	$data = $this->Crud->query("SELECT * FROM (SELECT `date`
	      		{$val}
	      		FROM `report` LEFT JOIN `enum` ON `report`.`analysis` = `enum`.`id` WHERE `analysis` IN ({$data}) AND `date` BETWEEN '{$start_date}' AND '{$end_date}' AND `report`.`device_id` = '{$dev_id}' GROUP BY `date`) a GROUP BY a.`date`");
	      	foreach ($data as $value) {
	      		$names = "";
	      		echo '[' . date('d', strtotime(($value['date']))) . ', ';
	      		for ($i=1; $i <= $no; $i++) { 
	      			$names .= $value['name_' . $i] . ", ";
	      		}
	      		echo rtrim($names, ', ') . '], ';
	      	}

	      	?>
	        ]);

	      var options = {
	        chart: { title: 'Chart <?php echo $dev;?> Problem', subtitle: 'data of <?php echo $start_date;?> to <?php echo $end_date;?>' },
	        height: 500
	      };

	      var chart = new google.charts.Line(document.getElementById('curve_chart'));

	      chart.draw(data, google.charts.Line.convertOptions(options));
	    }
	<?php }


	public function chart($dev_id='', $data ='', $date = '', $start = '', $end = '') {
		$data = urldecode($data);
		if ($data == 1 || $data == '') {
			$data = "SELECT `id` FROM `enum` WHERE `type` = 'analysis' AND `device_id` = {$dev_id}";
		}
		if ($date == '7day') {
			$start_date = date('Y-m-d', strtotime('-7 day'));
			$end_date = date('Y-m-d');
		} elseif ($date == 'thismonth') {
			$start_date = date('Y-m-1');
			$end_date = date('Y-m-t');
		} elseif ($date == 'lastmonth') {
			$start_date = date('Y-m-1', strtotime('-1 month'));
			$end_date = date('Y-m-t', strtotime('-1 month'));
		} elseif ($date == '30day') {
			$start_date = date('Y-m-d', strtotime('-30 day'));
			$end_date = date('Y-m-d');
		} elseif ($date == 'lastweek') {
			$start_date = date('Y-m-d', strtotime("-2 week +1 day"));
			$end_date = date('Y-m-d', strtotime("-1 week +1 day"));
		} else {
			$start_date = $start == '' ? date('Y-m-d', strtotime('-7 day')) : date('Y-m-d', strtotime($start));
			$end_date = $end == '' ? date('Y-m-d') : date('Y-m-d', strtotime($end));
		}
		
		?>
		var bar = new Morris.Bar({
	      element: 'chart_div',
	      resize: true,
	      data: [
	      <?php
	      $query = $this->Crud->sql_query("SELECT `date`, COUNT(`date`) `count` FROM `report`
	          LEFT JOIN `enum` ON `report`.`analysis` = `enum`.`id`
	          WHERE `analysis` IN ({$data}) AND `date` BETWEEN '{$start_date}' AND '{$end_date}' AND `report`.`device_id` = {$dev_id} GROUP BY `date`");
	         foreach ($query->result_array() as $value) {
	          echo "{y: '" .  ucfirst(strtolower($value['date'])) . "', a: {$value['count']}},";
	         }
	         ?>
	      ],
	      barColors: ['#3366cc'],
	      xkey: 'y',
	      ykeys: ['a'],
	      labels: ['Value'],
	      hideHover: 'auto'
	    });
	<?php }


	public function date_timeline($username='')
	{
		$level 	= $this->session->userdata('level');
		if ($level == 'supervisor' || $level == 'administrator') {
			$username = $username != '' ? $username : $this->session->userdata('username');
		} else {
			$username 	= $this->session->userdata('username');
		}
		$data = $this->Crud->search('user', array('username' => $username))->row_array();
		$sql = $this->Crud->query("SELECT `date` FROM `pic_report` LEFT JOIN `report` ON `pic_report`.`report_id` = `report`.`id` WHERE `pic_report`.`user_id` = '{$data['id']}' GROUP BY `report`.`date` ORDER BY `report`.`date` DESC limit 20");
		if(count($sql) > 0 ){
		  $response = array();
		  $response["data"] = array();
		  foreach ($sql as $x) {
			$h['date'] 	= $x['date'];
		    array_push($response["data"], $h);
		  }
		}else {
		  $response["data"]="empty";  
		}
		echo json_encode($response);
	}

	public function timeline($date, $username='')
	{
		$this->load->helper('penghitungan_helper');
		$date = urldecode($date);
		$level 	= $this->session->userdata('level');
		if ($level == 'supervisor' || $level == 'administrator') {
			$username = $username != '' ? $username : $this->session->userdata('username');
		} else {
			$username 	= $this->session->userdata('username');
		}
		$data = $this->Crud->search('user', array('username' => $username))->row_array();
		$sql = $this->Crud->query("SELECT `updated_date`, `report`.`unit_id`, `category`.`name` as `category`, `prob`.`name` as `problem`, `analysis`.`name` as `analysis` FROM `pic_report`
LEFT JOIN `report` ON `pic_report`.`report_id` = `report`.`id` 
LEFT JOIN `enum` as `prob` ON `report`.`problem` = `prob`.`id`
LEFT JOIN `enum` as `category` ON `report`.`category` = `category`.`id`
LEFT JOIN `enum` as `analysis` ON `report`.`analysis` = `analysis`.`id`
WHERE `pic_report`.`user_id` = '{$data['id']}' AND `date`= '{$date}' GROUP BY `date`, `shift`, `unit_id`, `bd_type`, `problem`, `category`,`analysis`,`cause`, `start_waiting`, `end_waiting`, `start_action`, `end_action` ORDER BY `report`.`date` DESC");
		if(count($sql) > 0 ){
		  $response = array();
		  $response["data"] = array();
		  foreach ($sql as $x) {
		  	$h['updated_date'] 	= time_elapsed_string($x['updated_date']);
			$h['unit_id'] 	= $x['unit_id'];
			$h['category'] 	= $x['category'];
			$h['problem'] 	= $x['problem'];
			$h['analysis'] 	= $x['analysis'];
		    array_push($response["data"], $h);
		  }
		}else {
		  $response["data"]="empty";  
		}
		echo json_encode($response);
	}

	public function bandwith($date = '') {
		if ($date == '7day') {
			$start_date = date('Y-m-d', strtotime('-7 day'));
			$end_date = date('Y-m-d');
		} elseif ($date == 'thismonth') {
			$start_date = date('Y-m-1');
			$end_date = date('Y-m-t');
		} elseif ($date == 'lastmonth') {
			$start_date = date('Y-m-1', strtotime('-1 month'));
			$end_date = date('Y-m-t', strtotime('-1 month'));
		} elseif ($date == '30day') {
			$start_date = date('Y-m-d', strtotime('-30 day'));
			$end_date = date('Y-m-d');
		} else {
			$start_date = date('Y-m-d', strtotime('-7 day'));
			$end_date = date('Y-m-d');
		}
		$data = $this->Crud->query("SELECT `date`, HOUR(`time`) as `time`,
		SUM( IF( `id_unit` = 'PT 01', `receive`, 0) ) AS 'PT 01',
		SUM( IF( `id_unit` = 'PT 02', `receive`, 0) ) AS 'PT 02',
		SUM( IF( `id_unit` = 'PT 03', `receive`, 0) ) AS 'PT 03',
		SUM( IF( `id_unit` = 'PT 04', `receive`, 0) ) AS 'PT 04',
		SUM( IF( `id_unit` = 'PT 05', `receive`, 0) ) AS 'PT 05',
		SUM( IF( `id_unit` = 'PT 06', `receive`, 0) ) AS 'PT 06',
		SUM( IF( `id_unit` = 'PT 07', `receive`, 0) ) AS 'PT 07',
		SUM( IF( `id_unit` = 'PT 08', `receive`, 0) ) AS 'PT 08',
		SUM( IF( `id_unit` = 'PT 09', `receive`, 0) ) AS 'PT 09',
		SUM( IF( `id_unit` = 'PT 10', `receive`, 0) ) AS 'PT 10',
		SUM( IF( `id_unit` = 'PT 11', `receive`, 0) ) AS 'PT 11',
		SUM( IF( `id_unit` = 'PT 12', `receive`, 0) ) AS 'PT 12',
		SUM( IF( `id_unit` = 'PT 13', `receive`, 0) ) AS 'PT 13',
		SUM( IF( `id_unit` = 'PT 14', `receive`, 0) ) AS 'PT 14',
		SUM( IF( `id_unit` = 'PT 15', `receive`, 0) ) AS 'PT 15',
		SUM( IF( `id_unit` = 'PT 16', `receive`, 0) ) AS 'PT 16',
		SUM( IF( `id_unit` = 'PT 17', `receive`, 0) ) AS 'PT 17',
		SUM( IF( `id_unit` = 'PT 18', `receive`, 0) ) AS 'PT 18',
		SUM( IF( `id_unit` = 'PT 19', `receive`, 0) ) AS 'PT 19',
		SUM( IF( `id_unit` = 'PT 20', `receive`, 0) ) AS 'PT 20',
		SUM( IF( `id_unit` = 'PT 21', `receive`, 0) ) AS 'PT 21',
		SUM( IF( `id_unit` = 'PT 22', `receive`, 0) ) AS 'PT 22',
		SUM( IF( `id_unit` = 'PT 23', `receive`, 0) ) AS 'PT 23',
		SUM( IF( `id_unit` = 'PT 24', `receive`, 0) ) AS 'PT 24',
		SUM( IF( `id_unit` = 'PT 25', `receive`, 0) ) AS 'PT 25',
		SUM( IF( `id_unit` = 'PT 26', `receive`, 0) ) AS 'PT 26',
		SUM( IF( `id_unit` = 'PT 27', `receive`, 0) ) AS 'PT 27',
		SUM( IF( `id_unit` = 'PT 28', `receive`, 0) ) AS 'PT 28',
		SUM( IF( `id_unit` = 'PT 29', `receive`, 0) ) AS 'PT 29',
		SUM( IF( `id_unit` = 'MIA4-MTLCT', `receive`, 0) ) AS 'MIA4-MTLCT',
		SUM( IF( `id_unit` = 'MIA4-MTLNT', `receive`, 0) ) AS 'MIA4-MTLNT',
		SUM( IF( `id_unit` = 'MIA4-SKID0', `receive`, 0) ) AS 'MIA4-SKID0',
		SUM( IF( `id_unit` = 'MIA4-VPNT', `receive`, 0) ) AS 'MIA4-VPNT',
		SUM( IF( `id_unit` = 'MTL J5', `receive`, 0) ) AS 'MTL J5',
		SUM( IF( `id_unit` = 'MTLCT-VPCT', `receive`, 0) ) AS 'MTLCT-VPCT'
		FROM `bandwith` WHERE `date` BETWEEN '{$start_date}' AND '{$end_date}' GROUP BY `date`, HOUR(`time`)");
		
		?>
	    google.charts.load('current', {'packages':['line']});
      google.charts.setOnLoadCallback(drawChart);

	    function drawChart() {

	      var data = new google.visualization.DataTable();
	      data.addColumn('string', 'Day');
	      data.addColumn('number', 'PT 01');
	      data.addColumn('number', 'PT 02');
	      data.addColumn('number', 'PT 03');
	      data.addColumn('number', 'PT 04');
	      data.addColumn('number', 'PT 05');
	      data.addColumn('number', 'PT 06');
	      data.addColumn('number', 'PT 07');
	      data.addColumn('number', 'PT 08');
	      data.addColumn('number', 'PT 09');
	      data.addColumn('number', 'PT 10');
	      data.addColumn('number', 'PT 11');
	      data.addColumn('number', 'PT 12');
	      data.addColumn('number', 'PT 13');
	      data.addColumn('number', 'PT 14');
	      data.addColumn('number', 'PT 15');
	      data.addColumn('number', 'PT 16');
	      data.addColumn('number', 'PT 17');
	      data.addColumn('number', 'PT 18');
	      data.addColumn('number', 'PT 19');
	      data.addColumn('number', 'PT 20');
	      data.addColumn('number', 'PT 21');
	      data.addColumn('number', 'PT 22');
	      data.addColumn('number', 'PT 23');
	      data.addColumn('number', 'PT 24');
	      data.addColumn('number', 'PT 25');
	      data.addColumn('number', 'PT 26');
	      data.addColumn('number', 'PT 27');
	      data.addColumn('number', 'PT 28');
	      data.addColumn('number', 'PT 29');
	      data.addColumn('number', 'MIA4-MTLCT');
	      data.addColumn('number', 'MIA4-MTLNT');
	      data.addColumn('number', 'MIA4-SKID0');
	      data.addColumn('number', 'MIA4-VPNT');
	      data.addColumn('number', 'MTL J5');
	      data.addColumn('number', 'MTLCT-VPCT');

	      data.addRows([
	        <?php foreach ($data as $value) {
	        echo "['{$value['date']} {$value['time']}:00',  {$value['PT 01']}, {$value['PT 02']}, {$value['PT 03']}, {$value['PT 04']}, {$value['PT 05']}, {$value['PT 06']}, {$value['PT 07']}, {$value['PT 08']}, {$value['PT 09']}, {$value['PT 10']}, {$value['PT 11']}, {$value['PT 12']}, {$value['PT 13']}, {$value['PT 14']}, {$value['PT 15']}, {$value['PT 16']}, {$value['PT 17']}, {$value['PT 18']}, {$value['PT 19']}, {$value['PT 20']}, {$value['PT 21']}, {$value['PT 22']}, {$value['PT 23']}, {$value['PT 24']}, {$value['PT 25']}, {$value['PT 26']}, {$value['PT 27']}, {$value['PT 28']}, {$value['PT 29']}, {$value['MIA4-MTLCT']}, {$value['MIA4-MTLNT']}, {$value['MIA4-SKID0']}, {$value['MIA4-VPNT']}, {$value['MTL J5']}, {$value['MTLCT-VPCT']}],"; }?>
	      ]);

	      var options = {
	        chart: {
	          title: 'The performance bandwith',
	          subtitle: 'data in kilobit/s'
	        },
	        height: 1500,
	        axes: {
	          x: {
	            0: {side: 'bottom'}
	          }
	        }
	      };

	      var chart = new google.charts.Line(document.getElementById('line_top_x'));

	      chart.draw(data, google.charts.Line.convertOptions(options));
	    }
	<?php }

	public function date_battery($year='')
	{
		if ($year == '') {
			$sql = $this->Crud->query("SELECT YEAR(`date`) as `date` FROM `battery` GROUP BY YEAR(`date`)");
		} else {
			$sql = $this->Crud->query("SELECT MONTH(`date`) as `date` FROM `battery` WHERE YEAR(`date`) = '{$year}' GROUP BY MONTH(`date`)");
		}
		if(count($sql) > 0 ){
		  $response = array();
		  $response["data"] = array();
		  foreach ($sql as $x) {
		  	$h['date'] = $x['date'];
		    array_push($response["data"], $h);
		  }
		}else {
		  $response["data"]="empty";  
		}
		echo json_encode($response);
	}

	public function date_pm($dev_id = '', $year='')
	{
		$id = trim(addslashes(strtoupper($dev_id)));
		if ($year == '') {
			$sql = $this->Crud->query("SELECT `year` as `date`, `time_period` FROM `periodic_pm`");
		} else {
			$sqlx = $this->Crud->sql_query("SELECT `year` as `date`, `time_period` FROM `periodic_pm` WHERE `year` = '{$year}'")->row_array();
			$begin = new DateTime( $sqlx['date'] . '-01-01' );
			$end = new DateTime( date('Y-m-t', strtotime($sqlx['date'] . '-12-01')) );
			$end = $end->modify( '+1 day' );

			if ($id == 1) {
				$interval = new DateInterval($sqlx['time_period']);
			} else {
				$interval = new DateInterval('P1M');
			}
			$sql = new DatePeriod($begin, $interval ,$end);
		}
		if($sql != '' ){
		  $response = array();
		  $response["data"] = array();
		  $no = 0;
		  foreach ($sql as $x) {
		  	if ($year == '') {
				$h['date'] = $x['date'];
			} else {
				$no++;
				$h['date'] = $no;				
			}
		    array_push($response["data"], $h);
		  }
		}else {
		  $response["data"]="empty";  
		}
		echo json_encode($response);
	}

	public function period_pm($dev_id = '', $year='', $period='')
	{
		$id = trim(addslashes(strtoupper($dev_id)));
		if ($year != '') {
			$sqlx = $this->Crud->sql_query("SELECT `year` as `date`, `time_period` FROM `periodic_pm` WHERE `year` = '{$year}'")->row_array();
		}
		if($sqlx != '' ){
		  $response = array();
		  $response["data"] = array();
		  $no = 0;
		  for ($i=((substr($sqlx['time_period'], 1,1)*$period)-substr($sqlx['time_period'], 1,1))+1, $a=1; $i <= substr($sqlx['time_period'], 1,1)*$period ; $i++, $a++) { 
		  	$h['date'] = $i;
		  	$h['loop'] = $a;
		  	array_push($response["data"], $h);
		  }
		}else {
		  $response["data"]="empty";  
		}
		echo json_encode($response);
	}
}
