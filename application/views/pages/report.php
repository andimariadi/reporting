<body class="hold-transition skin-blue sidebar-mini">
  <style type="text/css">
  #year_list > li.active > a, #year_list > li.menu-open > a {
    color: inherit;
    background-color: transparent;
  }
  #year_list > li > .treeview-menu {
    background: transparent;
  }
  #year_list .treeview-menu > li > a:hover {
    color: #333;
  }
  #year_list > li:hover > a {
    background: transparent;
    color: #333;
  }
  #year_list li > a > .pull-right-container {
    right: inherit;
    margin-left: 20px;
  }
  .table-header {
    color: #fff;
  }
  .skin-red .table-header, .skin-red-light .table-header {
    background-color: #dd4b39;
  }
  .skin-blue .table-header, .skin-blue-light .table-header {
    background-color: #3c8dbc;
  }
  .skin-black .table-header, .skin-black-light .table-header {
    color: #333;
    background-color: #fff;
  }
  .skin-purple .table-header, .skin-purple-light .table-header {
    background-color: #605ca8;
  }
  .skin-green .table-header, .skin-green-light .table-header {
    background-color: #00a65a;
  }
  .skin-yellow .table-header, .skin-yellow-light .table-header {
    background-color: #f39c12;
  }
  .table-striped > tbody > tr:nth-of-type(2n+1) {
    background-color: #ededed;
  }
</style>
<div class="wrapper">
  <?php $this->load->view('templates/sidebar');?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo ucfirst($dev);?>
        <small>Report</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dash');?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Report</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <?php if ($this->session->flashdata('msg') != '') {
        echo $this->session->flashdata('msg');
      }
      ?>

      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo strtoupper($dev . ' Report');?></h3>
              <?php if (($year != '' && $month != '') && $level != 'report' && $level != 'man power'): ?>
              <div class="pull-right">
                <a href="<?php echo base_url("dash/report_advanced/{$dev}/{$year}/{$month}/{$page}");?>">Advanced Menu Report</a>  (Edit / Delete)
              </div>
              <?php endif; ?>
            </div>

            <div class="box-header clearfix">
              <?php if ($dev != 'other'): ?>
              <div class="input-group" id="form-search">
                <input class="form-control" type="text" placeholder="Type unit id here" id="truck_id">
                    <span class="input-group-btn">
                      <button type="button" class="btn btn-info btn-flat" id="search">Search!</button>
                    </span>
              </div>
              <span class="help-block" id="id-search" style="display: none;"><i class="fa fa-times-circle-o"></i> Unit ID not found!</span>
              <!-- for search -->
              <?php endif; ?>
            </div>
              <!-- /.box-header -->
              <div class="box-body">
                <?php if ($year == '' && $month == ''): ?> <ul class="sidebar-menu" data-widget="tree" id="year_list"></ul> <?php endif; ?>
                <?php if ($year != '' && $month != ''): ?>
                  <?php foreach ($query as $data): ?>
                    <h5>Date : <b><?php echo $data['date'];?></b></h5>
                    <?php
                    $sql = $this->Crud->query("SELECT `date`, `shift`, `unit_id`, `location`, `time_problem`, `start_waiting`, `end_waiting`, `start_action`, `end_action`, `bd_receiver`, `rfu_receiver`, `status`, `enum`.`name` as `bd_type`, `prob`.`name` as `problem`, `category`.`name` as `category`, `analysis`.`name` as `analysis`, `cause`.`name` as `cause`, GROUP_CONCAT(DISTINCT `activity`.`name` separator '<br /> - ') as `activity`, GROUP_CONCAT(DISTINCT `remark`.`name` separator '<br /> - ') as `remark`, (SELECT GROUP_CONCAT(`user`.`name` SEPARATOR '<br /> - ') FROM `pic_report` LEFT JOIN `user` ON `pic_report`.`user_id` = `user`.`id` WHERE `pic_report`.`report_id` = `report`.`id` GROUP BY `pic_report`.`report_id`) as `pic`, (SELECT GROUP_CONCAT(DISTINCT `backlog_name` SEPARATOR '<br /> - ') as `backlog` FROM (SELECT `backlog`.`id`, `unit_id`,`backlog`.`backlog`, (SELECT `value` FROM `backlog` as a where a.unit_id = `backlog`.`unit_id` AND a.backlog = `backlog`.`backlog` ORDER BY `id` DESC LIMIT 1) as `value`, `enum`.`name` as `backlog_name`, `date` FROM `backlog` LEFT JOIN `enum` ON `backlog`.`backlog` = `enum`.`id`) as A WHERE `unit_id` = `report`.`unit_id` AND `value`= 0 AND `date` <= '{$data['date']}' GROUP BY `unit_id`) as `backlog`, `other` FROM `report` LEFT JOIN `enum` ON `report`.`bd_type` = `enum`.`id` LEFT JOIN `enum` as `prob` ON `report`.`problem` = `prob`.`id` LEFT JOIN `enum` as `category` ON `report`.`category` = `category`.`id` LEFT JOIN `enum` as `analysis` ON `report`.`analysis` = `analysis`.`id` LEFT JOIN `enum` as `cause` ON `report`.`cause` = `cause`.`id` LEFT JOIN `enum` as `activity` ON `report`.`activity` = `activity`.`id` LEFT JOIN `enum` as `remark` ON `report`.`remark` = `remark`.`id` WHERE `report`.`device_id` = {$dev_id} AND `date` = '{$data['date']}' GROUP BY `date`, `shift`, `unit_id`, `bd_type`, `problem`, `category`,`analysis`,`cause`, `start_waiting`, `end_waiting`, `start_action`, `end_action`");
                    ?>
                    <div  style="overflow: auto">
                      <table class="table table-striped">
                        <thead class="table-header">
                          <tr>
                            <th rowspan="2" style="padding: 0 30px;vertical-align: middle;text-align: center;">Date</th>
                            <th rowspan="2" style="padding: 0 20px;vertical-align: middle;text-align: center;">Shift</th>
                            <?php if ($dev != 'other'):?>
                              <th rowspan="2" style="padding: 0 30px;vertical-align: middle;text-align: center;">ID Unit</th>
                              <?php if ($dev == 'jigsaw'):?>
                                <th rowspan="2" style="vertical-align: middle;text-align: center;">BD Type</th>
                              <?php endif;?>
                              <th rowspan="2" style="vertical-align: middle;text-align: center;">Problem</th>
                              <th rowspan="2" style="vertical-align: middle;text-align: center;">Category</th>
                              <th rowspan="2" style="vertical-align: middle;text-align: center;">Work Location</th>
                              <th rowspan="2" style="vertical-align: middle;text-align: center;">Time Problem</th>
                              <?php if ($dev == 'jigsaw'):?>
                                <th colspan="3">Waiting</th>
                              <?php endif;?>
                              <th rowspan="2" style="vertical-align: middle;text-align: center;">Problem Analysis</th>
                              <th rowspan="2" style="vertical-align: middle;text-align: center;">Cause Of Problem</th>
                              <th rowspan="2" style="vertical-align: middle;text-align: center;">Activity Action</th>
                            <?php endif;?>
                              <th colspan="3">Action Time</th>
                            <?php if ($dev != 'other'):?>
                              <th rowspan="2" style="vertical-align: middle;text-align: center;">BD Receiver</th>
                              <th rowspan="2" style="vertical-align: middle;text-align: center;">RFU Receiver</th>
                              <th rowspan="2" style="vertical-align: middle;text-align: center;">PIC</th>
                            <?php endif;?>
                            <?php if ($dev == 'other'):?>
                              <th rowspan="2" style="vertical-align: middle;text-align: center;">Activity</th>
                              <th rowspan="2" style="vertical-align: middle;text-align: center;">Remark</th>
                              <th rowspan="2" style="vertical-align: middle;text-align: center;">Status</th>
                            <?php else:?>
                              <th rowspan="2" style="vertical-align: middle;text-align: center;">Status</th>
                              <th rowspan="2" style="vertical-align: middle;text-align: center;">Backlog</th>
                              <th rowspan="2" style="vertical-align: middle;text-align: center;">Remark</th>
                              <th rowspan="2" style="vertical-align: middle;text-align: center;">Other Info</th>
                              <th rowspan="2"></th>
                            <?php endif;?>
                          </tr>
                          <tr>
                            <?php if ($dev == 'jigsaw'):?>
                              <th>Start</th>
                              <th>End</th>
                              <th>Duration</th>
                            <?php endif;?>
                            <th>Start</th>
                            <th>End</th>
                            <th>Duration</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($sql as $value):?>
                            <tr>
                              <td><?php echo $value['date'];?></td>
                              <td>Shift <?php echo $value['shift'];?></td>
                              <?php if ($dev != 'other'):?>
                                <td><?php echo $value['unit_id'];?></td>
                                <?php if ($dev == 'jigsaw'):?>
                                  <td><?php echo $value['bd_type'];?></td>
                                <?php endif;?>
                                <td nowrap><?php echo $value['problem'];?></td>
                                <td nowrap><?php echo $value['category'];?></td>
                                <td nowrap><?php echo $value['location'];?></td>
                                <td nowrap><?php echo $value['time_problem'];?></td>
                                <?php if ($dev == 'jigsaw'):?>
                                  <td nowrap><?php echo $value['start_waiting'];?></td>
                                  <td nowrap><?php echo $value['end_waiting'];?></td>
                                  <td><?php echo selisih($value['start_waiting'], $value['end_waiting']);?></td>
                                <?php endif;?>
                                <td nowrap><?php echo $value['analysis'];?></td>
                                <td nowrap><?php echo $value['cause'];?></td>
                                <td nowrap>- <?php echo $value['activity'];?></td>
                              <?php endif;?>
                                <td nowrap><?php echo $value['start_action'];?></td>
                                <td nowrap><?php echo $value['end_action'];?></td>
                                <td nowrap><?php echo selisih($value['start_action'], $value['end_action']);?></td>
                              <?php if ($dev != 'other'):?>
                                <td nowrap><?php echo $value['bd_receiver'];?></td>
                                <td nowrap><?php echo $value['rfu_receiver'];?></td>
                                <td nowrap>- <?php echo $value['pic'];?></td>
                                <td nowrap><?php echo $value['status'] == 0 ? 'RFU' : 'NOT RFU';?></td>
                              <?php else:?>
                                <td nowrap><?php echo explode('[||]', $value['other'])[0];?></td>
                                <td nowrap><?php echo explode('[||]', $value['other'])[1];?></td>
                                <td nowrap><?php echo $value['status'] == 0 ? 'CLOSE' : 'OPEN';?></td>
                              <?php endif;?>
                              <?php if ($dev != 'other'):?>
                                <td nowrap>- <?php echo $value['backlog'];?></td>
                                <td nowrap>- <?php echo $value['remark'];?></td>
                                <td nowrap><?php echo $value['other'];?></td>
                                <td nowrap>
                                  <a href="<?php echo base_url("dash/report_summary/{$value['unit_id']}");?>" data-toggle="tooltip" data-placement="left" title="Summary <?php echo $value['unit_id']; ?>" style="cursor: pointer">
                                  <i class="fa fa-arrow-right fa-lg"></i>
                                </a>
                              </td>
                              <?php endif;?>
                            </tr>
                          <?php endforeach;?>
                        </tbody>
                      </table>
                    </div>
                  <?php endforeach;?>
                <?php endif; ?>
              </div>

              <div class="box-footer clearfix">
                <ul class="pagination pagination-sm no-margin pull-left">
                  <?php
                $paging_info = get_paging_info($page_total,1,$page); ?>
                <?php if($paging_info['curr_page'] > 1) : ?>
                  <li><a href='<?php echo base_url("dash/report/{$dev}/{$year}/{$month}/1");?>' title='Page 1'><i class="fa fa-angle-double-left"></i></a></li>
                  <li><a href='<?php echo base_url("dash/report/{$dev}/{$year}/{$month}/" . ($paging_info['curr_page'] - 1));?>' title='Page <?php echo ($paging_info['curr_page'] - 1); ?>'><i class="fa fa-angle-left"></i></a></li>
                  <?php
                endif; 
                $max = 7;
                if($paging_info['curr_page'] < $max)
                  $sp = 1;
                elseif($paging_info['curr_page'] >= ($paging_info['pages'] - floor($max / 2)) )
                  $sp = $paging_info['pages'] - $max + 1;
                elseif($paging_info['curr_page'] >= $max)
                  $sp = $paging_info['curr_page']  - floor($max/2);
                ?>

                <?php if($paging_info['curr_page'] >= $max) : ?>
                  <li><a href='<?php echo base_url("dash/report/{$dev}/{$year}/{$month}/1");?>' title='Page 1'>1</a></li>
                  <li>..</li>
                <?php endif; ?>
                <?php for($i = $sp; $i <= ($sp + $max -1);$i++) : ?>
                  <?php

                  if($i > $paging_info['pages'])
                    continue;
                  ?>
                  <?php if($paging_info['curr_page'] == $i) : ?>
                    <li class="page-item disabled"><a href="#"><?php echo $i; ?></a></li>
                    <?php else : ?>
                      <li><a href='<?php echo base_url("dash/report/{$dev}/{$year}/{$month}/" . $i);?>' title='Page <?php echo $i; ?>'><?php echo $i; ?></a></li>
                    <?php endif; ?>
                  <?php endfor; ?>

                  <?php if($paging_info['curr_page'] < ($paging_info['pages'] - floor($max / 2))) : ?>
                    <li>..</li>
                    <li><a href='<?php echo base_url("dash/report/{$dev}/{$year}/{$month}/" . $paging_info['pages']);?>' title='Page <?php echo $paging_info['pages']; ?>'><?php echo $paging_info['pages']; ?></a></li>
                  <?php endif; ?>
                  <?php if($paging_info['curr_page'] < $paging_info['pages']) : ?>
                    <li><a href='<?php echo base_url("dash/report/{$dev}/{$year}/{$month}/" . ($paging_info['curr_page'] + 1));?>' title='Page <?php echo ($paging_info['curr_page'] + 1); ?>'><i class="fa fa-angle-right"></i></a></li>
                    <li><a href='<?php echo base_url("dash/report/{$dev}/{$year}/{$month}/" . $paging_info['pages']);?>' title='Page <?php echo $paging_info['pages']; ?>'><i class="fa fa-angle-double-right"></i></a></li>
                  <?php endif; ?>
                </ul>
              </div>
            </div>
          </div>
        </div>

      </section>
      <!-- /.content -->
    </div>
    <?php $this->load->view('templates/footer');?>
  </div>
  <!-- ./wrapper -->
  <?php if ($year == '' && $month == ''): ?>
    <script type="text/javascript"> const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"]; var vPool = ''; $.getJSON('<?php echo base_url('Api/date_report/' . $dev_id);?>', function(jd) {$.each(jd.data, function(i, val){vPool += '<li class="treeview">' + '<a href="#" id="get_date" data-date="' + this['date'] + '">' + '<i class="fa fa-calendar-minus-o"></i> <span>' + this['date'] + '</span>' + '<span class="pull-right-container">' + '<i class="fa fa-angle-left pull-right"></i>' + '</span>' + '</a>' + '<ul class="treeview-menu" id="list_date_' + this['date'] + '">' + '</ul>' + '</li>'; }); $('#year_list').html(vPool); }); $(document).on('click', '#get_date', function(e) {var date = $(this).attr('data-date'); var vPool=""; $.getJSON('<?php echo base_url('Api/date_report/' . $dev_id);?>/' + date, function(jd) {$.each(jd.data, function(i, val){vPool += '<li>'+ '<a href="<?php echo $dev;?>/' + date + '/' + this['date'] + '"><i class="fa fa-angle-right"></i> ' + monthNames[this['date']-1] + '</a>'+ '</li>'; }); $('#list_date_' + date).html(vPool); }); }); </script> <?php endif; ?> <script type="text/javascript">
      $(document).on('click', '#search', function() {var id = $('#truck_id').val(); window.location.assign("<?php echo base_url('Dash/report_summary/');?>" + id); });
      $(document).on('keyup', '#truck_id', function(e) {var id = $(this).val(); $.getJSON('<?php echo base_url('Api/unit/');?>' + '/' + id, function(jd) {if (jd.data == 'empty' && id != '') {$('#form-search').addClass('has-error'); $('#id-search').css("display", "block"); } else {$('#form-search').removeClass('has-error'); $('#id-search').css("display", "none"); if(e.which == 13) {$('#search').click(); } } }); });
    </script>
  </body>
  </html>