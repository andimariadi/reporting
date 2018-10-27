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
        <li class="active">Unit</li>
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
              <div class="pull-right">
                <a href="<?php echo base_url("exports/report/{$dev}/{$year}/{$month}");?>"><i class="fa fa-file-excel-o"></i> Export</a> || 
                <a href="<?php echo base_url("dash/report/{$dev}/{$year}/{$month}/{$page}");?>">Simple Report</a>
              </div>
            </div>

            <div class="box-header clearfix">
              <ul class="pagination pagination-sm no-margin pull-left">
                <?php
                $paging_info = get_paging_info($page_total,1,$page); ?>
                <?php if($paging_info['curr_page'] > 1) : ?>
                  <li><a href='<?php echo base_url("dash/report_advanced/{$dev}/{$year}/{$month}/1");?>' title='Page 1'><i class="fa fa-angle-double-left"></i></a></li>
                  <li><a href='<?php echo base_url("dash/report_advanced/{$dev}/{$year}/{$month}/" . ($paging_info['curr_page'] - 1));?>' title='Page <?php echo ($paging_info['curr_page'] - 1); ?>'><i class="fa fa-angle-left"></i></a></li>
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
                  <li><a href='<?php echo base_url("dash/report_advanced/{$dev}/{$year}/{$month}/1");?>' title='Page 1'>1</a></li>
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
                      <li><a href='<?php echo base_url("dash/report_advanced/{$dev}/{$year}/{$month}/" . $i);?>' title='Page <?php echo $i; ?>'><?php echo $i; ?></a></li>
                    <?php endif; ?>
                  <?php endfor; ?>

                  <?php if($paging_info['curr_page'] < ($paging_info['pages'] - floor($max / 2))) : ?>
                    <li>..</li>
                    <li><a href='<?php echo base_url("dash/report_advanced/{$dev}/{$year}/{$month}/" . $paging_info['pages']);?>' title='Page <?php echo $paging_info['pages']; ?>'><?php echo $paging_info['pages']; ?></a></li>
                  <?php endif; ?>
                  <?php if($paging_info['curr_page'] < $paging_info['pages']) : ?>
                    <li><a href='<?php echo base_url("dash/report_advanced/{$dev}/{$year}/{$month}/" . ($paging_info['curr_page'] + 1));?>' title='Page <?php echo ($paging_info['curr_page'] + 1); ?>'><i class="fa fa-angle-right"></i></a></li>
                    <li><a href='<?php echo base_url("dash/report_advanced/{$dev}/{$year}/{$month}/" . $paging_info['pages']);?>' title='Page <?php echo $paging_info['pages']; ?>'><i class="fa fa-angle-double-right"></i></a></li>
                  <?php endif; ?>
                </ul>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <?php if ($year == '' && $month == ''): ?> <ul class="sidebar-menu" data-widget="tree" id="year_list"></ul> <?php endif; ?>
                <?php if ($year != '' && $month != ''): ?>
                  <?php foreach ($query as $data): ?>
                    <h5>Date : <b><?php echo $data['date'];?></b></h5>
                    <?php
                    $sql = $this->Crud->query("SELECT `report`.`id` as `id`, `date`, `shift`, `unit_id`, `location`, `time_problem`, `start_waiting`, `end_waiting`, `start_action`, `end_action`, `bd_receiver`, `rfu_receiver`, `status`, `enum`.`name` as `bd_type`, `prob`.`name` as `problem`, `category`.`name` as `category`, `analysis`.`name` as `analysis`, `cause`.`name` as `cause`, `activity`.`name` as `activity`, `remark`.`name` as `remark`, GROUP_CONCAT(`user`.`name` SEPARATOR ', ') as `pic`, `other` FROM `report` LEFT JOIN `enum` ON `report`.`bd_type` = `enum`.`id` LEFT JOIN `enum` as `prob` ON `report`.`problem` = `prob`.`id` LEFT JOIN `enum` as `category` ON `report`.`category` = `category`.`id` LEFT JOIN `enum` as `analysis` ON `report`.`analysis` = `analysis`.`id` LEFT JOIN `enum` as `cause` ON `report`.`cause` = `cause`.`id` LEFT JOIN `enum` as `activity` ON `report`.`activity` = `activity`.`id` LEFT JOIN `enum` as `remark` ON `report`.`remark` = `remark`.`id` LEFT JOIN `pic_report` ON `report`.`id` = `pic_report`.`report_id` LEFT JOIN `user` ON `pic_report`.`user_id` = `user`.`id` WHERE `report`.`device_id` = {$dev_id} AND `date` = '{$data['date']}'GROUP BY `pic_report`.`report_id`");
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
                              <th rowspan="2" style="vertical-align: middle;text-align: center;">Remark</th>
                              <th rowspan="2" style="vertical-align: middle;text-align: center;">Other Info</th>
                            <?php endif;?>
                            <th rowspan="2"></th>
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
                                <td nowrap><?php echo $value['activity'];?></td>
                              <?php endif;?>
                                <td nowrap><?php echo $value['start_action'];?></td>
                                <td nowrap><?php echo $value['end_action'];?></td>
                                <td nowrap><?php echo selisih($value['start_action'], $value['end_action']);?></td>
                              <?php if ($dev != 'other'):?>
                                <td nowrap><?php echo $value['bd_receiver'];?></td>
                                <td nowrap><?php echo $value['rfu_receiver'];?></td>
                                <td nowrap><?php echo $value['pic'];?></td>
                                <td nowrap><?php echo $value['status'] == 0 ? 'RFU' : 'NOT RFU';?></td>
                              <?php else:?>
                                <td nowrap><?php echo explode('[||]', $value['other'])[0];?></td>
                                <td nowrap><?php echo explode('[||]', $value['other'])[1];?></td>
                                <td nowrap><?php echo $value['status'] == 0 ? 'CLOSE' : 'OPEN';?></td>
                              <?php endif;?>
                              <?php if ($dev != 'other'):?>
                                <td nowrap><?php echo $value['remark'];?></td>
                                <td nowrap><?php echo $value['other'];?></td>
                              <?php endif;?>
                              <td nowrap>
                                <i class="fa fa-edit fa-lg" data-toggle="modal" data-target="#modal-default" id="edit" data-id="<?php echo $value['id']; ?>"></i>

                                <span id="delete" data-id="<?php echo $value['id']; ?>" data-toggle="tooltip" data-placement="left" title="Delete <?php echo $value['unit_id']; ?>" style="cursor: pointer">
                                  <i class="fa fa-trash-o fa-lg"></i>
                                </span>
                              <?php if ($dev != 'other'):?>
                                <a href="<?php echo base_url("dash/report_summary/{$value['unit_id']}");?>" data-toggle="tooltip" data-placement="left" title="Summary <?php echo $value['unit_id']; ?>" style="cursor: pointer">
                                  <i class="fa fa-arrow-right fa-lg"></i>
                                </a>
                              <?php endif;?>
                              </td>
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
                    <li><a href='<?php echo base_url("dash/report_advanced/{$dev}/{$year}/{$month}/1");?>' title='Page 1'><i class="fa fa-angle-double-left"></i></a></li>
                    <li><a href='<?php echo base_url("dash/report_advanced/{$dev}/{$year}/{$month}/" . ($paging_info['curr_page'] - 1));?>' title='Page <?php echo ($paging_info['curr_page'] - 1); ?>'><i class="fa fa-angle-left"></i></a></li>
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
                    <li><a href='<?php echo base_url("dash/report_advanced/{$dev}/{$year}/{$month}/1");?>' title='Page 1'>1</a></li>
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
                        <li><a href='<?php echo base_url("dash/report_advanced/{$dev}/{$year}/{$month}/" . $i);?>' title='Page <?php echo $i; ?>'><?php echo $i; ?></a></li>
                      <?php endif; ?>
                    <?php endfor; ?>

                    <?php if($paging_info['curr_page'] < ($paging_info['pages'] - floor($max / 2))) : ?>
                      <li>..</li>
                      <li><a href='<?php echo base_url("dash/report_advanced/{$dev}/{$year}/{$month}/" . $paging_info['pages']);?>' title='Page <?php echo $paging_info['pages']; ?>'><?php echo $paging_info['pages']; ?></a></li>
                    <?php endif; ?>
                    <?php if($paging_info['curr_page'] < $paging_info['pages']) : ?>
                      <li><a href='<?php echo base_url("dash/report_advanced/{$dev}/{$year}/{$month}/" . ($paging_info['curr_page'] + 1));?>' title='Page <?php echo ($paging_info['curr_page'] + 1); ?>'><i class="fa fa-angle-right"></i></a></li>
                      <li><a href='<?php echo base_url("dash/report_advanced/{$dev}/{$year}/{$month}/" . $paging_info['pages']);?>' title='Page <?php echo $paging_info['pages']; ?>'><i class="fa fa-angle-double-right"></i></a></li>
                    <?php endif; ?>
                  </ul>
                </div>


              </div>
            </div>

            <!-- /modal edit -->
            <div class="modal fade" id="modal-default" style="display: none;">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <form id="form-edit">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">Form Edit</h4>
                      </div>
                      <div class="modal-body" id="modal-body">

                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="submit">Save changes</button>
                      </div>
                    </form>
                  </div>
                </div>
                <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
            </div>

          </section>
          <!-- /.content -->
        </div>
        <?php $this->load->view('templates/footer');?>

      </div>
      <!-- ./wrapper -->
      <?php if ($year == '' && $month == ''): ?>
        <script type="text/javascript"> const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"]; var vPool = ''; $.getJSON('<?php echo base_url('Api/date_report/' . $dev_id);?>', function(jd) {$.each(jd.data, function(i, val){vPool += '<li class="treeview">' + '<a href="#" id="get_date" data-date="' + this['date'] + '">' + '<i class="fa fa-calendar-minus-o"></i> <span>' + this['date'] + '</span>' + '<span class="pull-right-container">' + '<i class="fa fa-angle-left pull-right"></i>' + '</span>' + '</a>' + '<ul class="treeview-menu" id="list_date_' + this['date'] + '">' + '</ul>' + '</li>'; }); $('#year_list').html(vPool); }); $(document).on('click', '#get_date', function(e) {var date = $(this).attr('data-date'); var vPool=""; $.getJSON('<?php echo base_url('Api/date_report/' . $dev_id);?>/' + date, function(jd) {$.each(jd.data, function(i, val){vPool += '<li>'+ '<a href="<?php echo $dev;?>/' + date + '/' + this['date'] + '"><i class="fa fa-angle-right"></i> ' + monthNames[this['date']-1] + '</a>'+ '</li>'; }); $('#list_date_' + date).html(vPool); }); }); </script>
        <?php else: ?>
          <script type="text/javascript">
            var problem = <?php
                  foreach ($problem as $value):
                    echo "'<option value=\"{$value['id']}\">{$value['name']} ({$value['alias']})</option>' +";
                  endforeach;
                  ?> '';
            $(document).on('click', '#edit', function(e){
              var id = $(this).attr('data-id');
              var vPool ='';
              $.getJSON('<?php echo base_url('Api/report');?>/' + id, function(jd) {
                $.each(jd.data, function(i, val){   
                  vPool += '<input class="form-control" name="id" type="hidden" value="' + this['id'] + '" />' +
                  '<div class="row">' +
                  '<div class="col-sm-3">' +
                  '<div class="form-group">' +
                  '<label>Date</label>' +
                  '<input class="form-control" name="date" id="datehidden" placeholder="YYYY-MM-DD" type="text" value="' + this['date'] + '">' +
                  '</div>' +
                  '</div>' +
                  '<div class="col-sm-3">' +
                  '<div class="form-group">' +
                  '<label>Shift</label>' +
                  '<input class="form-control" name="shift" placeholder="1" type="text" value="' + this['shift'] + '">' +
                  '</div>' +
                  '</div>';
                  <?php if ($dev != 'other'):?>
                    vPool += '<div class="col-sm-3">' +
                    '<div class="form-group">' +
                    '<label>ID Unit</label>' +
                    '<input class="form-control" name="unit" id="datehidden" placeholder="Enter Unit ID" type="text" value="' + this['unit_id'] + '">' +
                    '</div>' +
                    '</div>' +
                    <?php if ($dev == 'jigsaw'):?>
                      '<div class="col-sm-3">' +
                      '<div class="form-group">' +
                      '<label>BD Type</label>' +
                      '<select class="form-control" name="bd">' +
                      <?php
                      foreach ($bd as $value):
                        echo "'<option value=\"{$value['id']}\">{$value['name']}</option>' + ";
                      endforeach;
                      ?>
                      '</select>' +
                      '</div>' +
                      '</div>' +
                    <?php endif;?>
                  '</div>';
                  vPool += '<div class="row">';
                  <?php endif;?>
                  <?php if ($dev == 'jigsaw'):?>
                    vPool += '<div class="col-sm-3">' +
                    '<div class="form-group">' +
                    '<label id="labelstartaction">Start Waiting</label>' +
                    '<div class="input-group">' +
                    '<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>' +
                    '<input type="text" name="startwait" class="form-control" id="startwait" placeholder="HH:MM:SS" value="' + this['start_waiting'] + '" required>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-sm-3">' +
                    '<div class="form-group">' +
                    '<label id="labelendaction">End Waiting</label>' +
                    '<div class="input-group">' +
                    '<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>' +
                    '<input type="text" name="endwait" class="form-control" id="endwait" placeholder="HH:MM:SS" value="' + this['end_waiting'] + '" required>' +
                    '</div>' +
                    '</div>' +
                    '</div>';
                  <?php endif;?>
                  vPool += '<div class="col-sm-3">' +
                    '<div class="form-group">' +
                    '<label id="labelstartaction">Start Action</label>' +
                    '<div class="input-group">' +
                    '<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>' +
                    '<input type="text" name="startaction" class="form-control" id="startaction" placeholder="HH:MM:SS" value="' + this['start_action'] + '" required>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-sm-3">' +
                    '<div class="form-group">' +
                    '<label id="labelendaction">End Action</label>' +
                    '<div class="input-group">' +
                    '<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>' +
                    '<input type="text" name="endaction" class="form-control" id="endaction" placeholder="HH:MM:SS" value="' + this['end_action'] + '" required>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                  '</div>';
                  <?php if ($dev != 'other'):?>
                  vPool += '<div class="form-group">' +
                  '<label>Location</label>' +
                  '<input type="text" name="location" class="form-control" id="location" placeholder="Enter Location" value="' + this['location'] + '" required>' +
                  '</div>' +
                  '<div class="form-group" id="authors">' +
                  '<label>Problem</label>' +
                  '<select class="form-control" name="problem" id="change_problem">' +
                  problem +
                  '</select>' +
                  '</div>' +
                  '<div class="form-group">' +
                  '<label>Analysis</label>' +
                  '<select class="form-control" name="analysis">' +
                  '<option value="0">Change Analysis</option>' +
                  '</select>' +
                  '</div>';
                  vPool += '<div class="form-group">' +
                  '<label>Cause By Problem</label>' +
                  '<select class="form-control" name="cause">' +
                  '<option value="0">Change Cause By Problem</option>' +
                  '</select>' +
                  '</div>' +
                  '<div class="form-group">' +
                  '<label>Action</label>' +
                  '<select class="form-control" name="action" id="action_press">' +
                  '<option value="0">Change Action</option>' +
                  '</select>' +
                  '</div>' +
                  '<div class="form-group">' +
                  '<label>Remark</label>' +
                  '<select class="form-control" name="remark" id="remark_press">' +
                  '<option value="0">Change Remark</option>' +
                  '</select>' +
                  '</div>' +
                  '<div class="form-group">' +
                  '<label id="labelstartaction">Other Information</label>' +
                  '<textarea name="action-o" class="form-control">' + this['action-o'] + '</textarea>' +
                  '</div>';
                  <?php else:?>
                  vPool += '<div class="form-group">' +
                  '<label>Acitivy</label>' +
                  '<textarea class="form-control" name="action-o">' + this['action-o'] + '</textarea>' +
                  '</div>' +
                  '<div class="form-group">' +
                  '<label>Remark</label>' +
                  '<textarea class="form-control" name="remark-o">' + this['remark-o'] + '</textarea>' +
                  '</div>';
                  <?php endif;?>
                  vPool += '<div class="row">' +
                  <?php if ($dev != 'other'):?>
                  '<div class="col-sm-3">' +
                  '<div class="form-group">' +
                  '<label id="labelstartaction">BD Receiver</label>' +
                  '<div class="input-group">' +
                  '<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>' +
                  '<input type="text" name="bd_rec" class="form-control" id="bd_rec" placeholder="HH:MM:SS" value="' + this['bd_receiver'] + '" required>' +
                  '</div>' +
                  '</div>' +
                  '</div>' +
                  '<div class="col-sm-3">' +
                  '<div class="form-group">' +
                  '<label id="labelendaction">RFU Receiver</label>' +
                  '<div class="input-group">' +
                  '<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>' +
                  '<input type="text" name="rfu_rec" class="form-control" id="rfu_rec" placeholder="HH:MM:SS" value="' + this['rfu_receiver'] + '" required>' +
                  '</div>' +
                  '</div>' +
                  '</div>' +
                  <?php endif;?>
                  '<div class="col-sm-3">' +
                  '<div class="form-group">' +
                  '<label id="labelstartaction">Status</label>' +
                  '<select class="form-control" name="status">' +
                  '<option value="0">RFU</option>' +
                  '<option value="1">Not RFU</option>' +
                  '</select>' +
                  '</div>' +
                  '</div>' +
                  '</div>';
                });
  $('#modal-body').html(vPool);
  });
  $.getJSON('<?php echo base_url('Api/report');?>/' + id, function(jd) {
    $.each(jd.data, function(i, vals){ 
      $("select[name=problem]").val(this['problem']);
      var problem = this['problem'];
      var analysis = this['analysis'];
      var cause = this['cause'];
      var activity = this['activity'];
      var remark = this['remark'];
      $.getJSON('<?php echo base_url('Api/relations/');?>' + this['problem'], function(jd) {
        var vPool="";
        $.each(jd.data, function(){
          if (this['id'] == analysis) {
            vPool += '<option value="' + this['id'] + '" selected>' + this['name'] + '</option>';
          } else {
            vPool += '<option value="' + this['id'] + '">' + this['name'] + '</option>';
          }
        });
        $('[name=analysis]').html(vPool);
      });
      $.getJSON('<?php echo base_url('Api/relations/');?>' + this['problem'] + '/' + this['analysis'], function(jd) {
        var vPool="";
        $.each(jd.data, function(){
          if (this['id'] == cause) {
            vPool += '<option value="' + this['id'] + '" selected>' + this['name'] + '</option>';
          } else {
            vPool += '<option value="' + this['id'] + '">' + this['name'] + '</option>';
          }
        });
        $('[name=cause]').html(vPool);
      });
      $.getJSON('<?php echo base_url('Api/relations/');?>' + this['problem'] + '/' + this['analysis'] + '/' + this['cause'], function(jd) {
        var vPool="";
        $.each(jd.data, function(){
          if (this['id'] == activity) {
            vPool += '<option value="' + this['id'] + '" selected>' + this['name'] + '</option>';
          } else {
            vPool += '<option value="' + this['id'] + '">' + this['name'] + '</option>';
          }
        });
        $('#action_press').html(vPool);
      });

      $.getJSON('<?php echo base_url('Api/relations/');?>' + this['problem'] + '/' + this['analysis'] + '/' + this['cause'] + '/' + this['activity'], function(jd) {
        var vPool="";
        $.each(jd.data, function(){
          vPool += '<option value="0"></option>';
          if (this['id'] == remark) {
            vPool += '<option value="' + this['id'] + '" selected>' + this['name'] + '</option>';
          } else {
            vPool += '<option value="' + this['id'] + '">' + this['name'] + '</option>';
          }
        });
        $('#remark_press').html(vPool);
      });
    }); 
  });
});

$(document).on('click', '[name=problem]', function() {
  var id = $(this).val()
  $.getJSON('<?php echo base_url('Api/relations/');?>' + id, function(jd) {
    var vPool="";
    $.each(jd.data, function(){
      vPool += '<option value="' + this['id'] + '">' + this['name'] + '</option>';
    });
    $('[name=analysis]').html(vPool);
    $('[name=analysis]').removeAttr('disabled');
    $('[name=cause]').prop('disabled', true);
    $('[name=cause]').html('<option value="0">Change Cause By Problem</option>');
    $('#action_press').prop('disabled', true);
    $('#action_press').html('<option value="0">Change Action</option>');
    $('#remark_press').prop('disabled', true);
    $('#remark_press').html('<option value="0">Change Remark</option>');
  });
});

$(document).on('click', '[name=analysis]', function() {
  var problem = $('[name=problem]').val();
  var id = $(this).val()
  $.getJSON('<?php echo base_url('Api/relations/');?>' + problem + '/' + id, function(jd) {
    var vPool="";
    $.each(jd.data, function(){
      vPool += '<option value="' + this['id'] + '">' + this['name'] + '</option>';
    });
    $('[name=cause]').html(vPool);
    $('[name=cause]').removeAttr('disabled');
    $('#action_press').prop('disabled', true);
    $('#action_press').html('<option value="0">Change Action</option>');
    $('#remark_press').prop('disabled', true);
    $('#remark_press').html('<option value="0">Change Remark</option>');
  });
});

$(document).on('click', '[name=cause]', function() {
  var problem = $('[name=problem]').val();
  var analysis = $('[name=analysis]').val();
  var id = $(this).val()
  $.getJSON('<?php echo base_url('Api/relations/');?>' + problem + '/' + analysis + '/' + id, function(jd) {
    var vPool="";
    $.each(jd.data, function(){
      vPool += '<option value="' + this['id'] + '">' + this['name'] + '</option>';
    });
    $('#action_press').html(vPool);
    $('#action_press').removeAttr('disabled');
    $('#remark_press').prop('disabled', true);
    $('#remark_press').html('<option value="0">Change Remark</option>');
  });
});

$(document).on('click', '#action_press', function() {
  var problem = $('[name=problem]').val();
  var analysis = $('[name=analysis]').val();
  var cause = $('[name=cause]').val();
  var id = encodeURIComponent($(this).val());
  $.getJSON('<?php echo base_url('Api/relations/');?>' + problem + '/' + analysis + '/' + cause + '/' + id, function(jd) {
    var vPool="";
    $.each(jd.data, function(){
      vPool += '<option value="' + this['id'] + '">' + this['name'] + '</option>';
    });
    $('#remark_press').html(vPool);
    $('#remark_press').removeAttr('disabled');
  });
});
</script>
<script type="text/javascript">
  $(document).on('click', '#submit', function(e) {
    var data = $('#form-edit').serialize();
    $.ajax({
      type: "POST",
      data:data,
      url: "<?php echo base_url('Edit/report');?>",
      success: function(response) {
        location.reload();
      },
      error: function () {
        console.log("errr");
      }
    });
  });

  $(document).on('keypress', '#name', function(e) {
    if(e.which == 13) {
      $('#submit').click();
    }
  });

  $(document).on('click', '#delete', function() {
    var ai = $(this).attr('data-id');
    $.ajax({
      type: "POST",
      data:'del=' + ai,
      url: "<?php echo base_url('Delete/report');?>",
      success: function(response) {
        location.reload();
      },
      error: function () {
        console.log("errr");
      }
    });
  });
</script>
<?php endif; ?>
</body>
</html>