<body class="hold-transition skin-blue sidebar-mini">
  <style type="text/css">
  .totodo .tools > i {
    color: #dd4b39;
    cursor: pointer;
    margin-left: 5px
  }
</style>
<div class="wrapper">
  <?php $this->load->view('templates/sidebar');?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Backlog Data
        <small>Report</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dash');?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Backlog</li>
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
              <h3 class="box-title"><?php echo strtoupper( $dev . ' Backlog');?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="unit" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th style="width: 10px">#</th>
                    <th>ID Unit</th>
                    <?php if ($dev != 'network'):?>
                      <th>Series Jigsaw</th>
                    <?php endif;?>
                    <th>Type Unit</th>
                    <th>Backlog</th>
                    <?php
                    if ($unit_id != '') {
                      echo '<th>Date Backlog</th>';
                      echo '<th>Status</th>';
                      echo '<th>PIC</th>';
                    }
                    ?>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 0; foreach ($unit as $value): $no++;?>
                  <tr>
                    <td><?php echo $no;?></td>
                    <?php
                    if ($unit_id != '') { ?>
                      <td><?php echo $value['id'];?></td>
                    <?php } else { ?>
                      <td><a href="<?php echo base_url('Dash/r_backlog/' . $dev . '/' . $value['id']);?>"><?php echo $value['id'];?></a></td>
                    <?php } ?>
                    <?php if ($dev != 'network'):?>
                      <td><?php echo $value['series_name'];?></td>
                    <?php endif;?>
                    <td><?php echo $value['code_name'];?></td>
                    <td>- <?php echo $value['backlog'];?></td>
                    <?php
                    if ($unit_id != '') {
                      echo '<td>' . $value['date'] . '</td>';
                      echo '<td>' . $value['value'] . '</td>';
                      echo '<td>' . $value['pic'] . '</td>';
                    }
                    ?>
                  </tr>
                <?php endforeach;?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
        <!-- /.modal-dialog -->
      </div>

    </section>
    <!-- /.content -->
  </div>
  <?php $this->load->view('templates/footer');?>
</div>
<!-- ./wrapper -->
<!-- DataTables -->
<script src="<?php echo base_url('___/bower_components/datatables.net/js/jquery.dataTables.min.js');?>"></script>
<script src="<?php echo base_url('___/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js');?>"></script>
<script type="text/javascript">
$(function () {
  $('#unit').DataTable()
});
</script>
</body>
</html>
