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
              <h3 class="box-title"><?php echo strtoupper('Summary Report');?></h3>
            </div>

            <div class="box-header clearfix">
              <ul class="pagination pagination-sm no-margin pull-left">
                <?php
                $paging_info = get_paging_info($page_total,1,$page); ?>
                <?php if($paging_info['curr_page'] > 1) : ?>
                  <li><a href='<?php echo base_url("dash/report_summary/{$unit}/1");?>' title='Page 1'><i class="fa fa-angle-double-left"></i></a></li>
                  <li><a href='<?php echo base_url("dash/report_summary/{$unit}/" . ($paging_info['curr_page'] - 1));?>' title='Page <?php echo ($paging_info['curr_page'] - 1); ?>'><i class="fa fa-angle-left"></i></a></li>
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
                  <li><a href='<?php echo base_url("dash/report_summary/{$unit}/1");?>' title='Page 1'>1</a></li>
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
                      <li><a href='<?php echo base_url("dash/report_summary/{$unit}/" . $i);?>' title='Page <?php echo $i; ?>'><?php echo $i; ?></a></li>
                    <?php endif; ?>
                  <?php endfor; ?>

                  <?php if($paging_info['curr_page'] < ($paging_info['pages'] - floor($max / 2))) : ?>
                    <li>..</li>
                    <li><a href='<?php echo base_url("dash/report_summary/{$unit}/" . $paging_info['pages']);?>' title='Page <?php echo $paging_info['pages']; ?>'><?php echo $paging_info['pages']; ?></a></li>
                  <?php endif; ?>
                  <?php if($paging_info['curr_page'] < $paging_info['pages']) : ?>
                    <li><a href='<?php echo base_url("dash/report_summary/{$unit}/" . ($paging_info['curr_page'] + 1));?>' title='Page <?php echo ($paging_info['curr_page'] + 1); ?>'><i class="fa fa-angle-right"></i></a></li>
                    <li><a href='<?php echo base_url("dash/report_summary/{$unit}/" . $paging_info['pages']);?>' title='Page <?php echo $paging_info['pages']; ?>'><i class="fa fa-angle-double-right"></i></a></li>
                  <?php endif; ?>
                </ul>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                    <h5>Summary <b><?php echo $unit;?></b></h5>
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
                          <?php foreach ($query as $value): ?>
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
                              <?php endif;?>
                            </tr>
                          <?php endforeach;?>
                        </tbody>
                      </table>
                    </div>
              </div>

              <div class="box-footer clearfix">
                <ul class="pagination pagination-sm no-margin pull-left">
                  <?php
                  $paging_info = get_paging_info($page_total,1,$page); ?>
                  <?php if($paging_info['curr_page'] > 1) : ?>
                    <li><a href='<?php echo base_url("dash/report_summary/{$unit}/1");?>' title='Page 1'><i class="fa fa-angle-double-left"></i></a></li>
                    <li><a href='<?php echo base_url("dash/report_summary/{$unit}/" . ($paging_info['curr_page'] - 1));?>' title='Page <?php echo ($paging_info['curr_page'] - 1); ?>'><i class="fa fa-angle-left"></i></a></li>
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
                    <li><a href='<?php echo base_url("dash/report_summary/{$unit}/1");?>' title='Page 1'>1</a></li>
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
                        <li><a href='<?php echo base_url("dash/report_summary/{$unit}/" . $i);?>' title='Page <?php echo $i; ?>'><?php echo $i; ?></a></li>
                      <?php endif; ?>
                    <?php endfor; ?>

                    <?php if($paging_info['curr_page'] < ($paging_info['pages'] - floor($max / 2))) : ?>
                      <li>..</li>
                      <li><a href='<?php echo base_url("dash/report_summary/{$unit}/" . $paging_info['pages']);?>' title='Page <?php echo $paging_info['pages']; ?>'><?php echo $paging_info['pages']; ?></a></li>
                    <?php endif; ?>
                    <?php if($paging_info['curr_page'] < $paging_info['pages']) : ?>
                      <li><a href='<?php echo base_url("dash/report_summary/{$unit}/" . ($paging_info['curr_page'] + 1));?>' title='Page <?php echo ($paging_info['curr_page'] + 1); ?>'><i class="fa fa-angle-right"></i></a></li>
                      <li><a href='<?php echo base_url("dash/report_summary/{$unit}/" . $paging_info['pages']);?>' title='Page <?php echo $paging_info['pages']; ?>'><i class="fa fa-angle-double-right"></i></a></li>
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
</body>
</html>