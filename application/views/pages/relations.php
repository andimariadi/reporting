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
        Relations
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dash');?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Relations</li>
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
        <?php foreach ($device as $value):
          $category = $this->Crud->search('enum', array('type' => 'category', 'device_id' => $value['id']))->result_array();
          $problem = $this->Crud->search('enum', array('type' => 'problem', 'device_id' => $value['id']))->result_array();
          $analysis = $this->Crud->search('enum', array('type' => 'analysis', 'device_id' => $value['id']))->result_array();
          $cause = $this->Crud->search('enum', array('type' => 'cause', 'device_id' => $value['id']))->result_array();
          $action = $this->Crud->search('enum', array('type' => 'action', 'device_id' => $value['id']))->result_array();
          $remark = $this->Crud->search('enum', array('type' => 'remark', 'device_id' => $value['id']))->result_array();
          ?>
          <div class="col-md-6">
            <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title"><?php echo strtoupper($value['name']);?></h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <table id="<?php echo $value['name'];?>" class="table table-bordered">
                  <thead>
                  <tr>
                    <th style="width: 10px">#</th>
                    <th>Category</th>
                    <th>Problem</th>
                    <th>Analysis</th>
                    <th>Cause By</th>
                    <th>Action</th>
                    <th>Remark</th>
                    <th style="width: 40px"></th>
                  </tr>
                </thead>
                  <tbody>
                  <?php
                  $no = 0;
                  $sql = $this->Crud->multijoinwhere('relations as pr', array('enum as cat' => 'pr.category = cat.id', 'enum as prob' => 'pr.problem = prob.id', 'enum as ana' => 'pr.analysis = ana.id', 'enum as cau' => 'pr.cause = cau.id', 'enum as act' => 'pr.action = act.id', 'enum as rem' => 'pr.remark = rem.id'), array('pr.device_id' => $value['id']),array('order' => 'pr.id', 'by' => 'asc'), array('cat.name as category', 'prob.name as problem', 'ana.name as analysis', 'cau.name as cause', 'act.name as action', 'rem.name as remark', 'pr.id'))->result_array();
                  foreach ($sql as $data) {
                    $no++;
                    echo '<tr class="totodo">
                    <td>' . $no . '. </td>
                    <td>' . $data['category'] . '</td>
                    <td>' . $data['problem'] . '</td>
                    <td>' . $data['analysis'] . '</td>
                    <td>' . $data['cause'] . '</td>
                    <td>' . $data['action'] . '</td>
                    <td>' . $data['remark'] . '</td>
                    <td class="tools">
                    <i class="fa fa-trash-o" id="delete" data-id="' . $data['id'] . '"></i>
                    </td>
                    </tr>';
                  }
                  ?>
                </tbody></table>

                <!-- form start -->
                <form role="form" method="post" action="<?php echo base_url('Save/relations');?>">
              <div class="box-body">
                <div class="form-group">
                  <input type="hidden" name="device" value="<?php echo $value['id'];?>">
                  <label for="exampleInputEmail1">Category</label>
                  <select class="form-control" name="category">
                    <?php
                    foreach ($category as $data) {
                      echo '<option value="' . $data['id'] . '">' . $data['name'] . '</option>';
                    }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Problem</label>
                  <select class="form-control" name="problem">
                    <?php
                    foreach ($problem as $data) {
                      echo '<option value="' . $data['id'] . '">' . $data['name'] . ' (' . $data['alias'] . ')</option>';
                    }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Analysis</label>
                  <select class="form-control" name="analysis">
                    <?php
                    foreach ($analysis as $data) {
                      echo '<option value="' . $data['id'] . '">' . $data['name'] . ' (' . $data['alias'] . ')</option>';
                    }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Cause By Problem</label>
                  <select class="form-control" name="cause">
                    <?php
                    foreach ($cause as $data) {
                      echo '<option value="' . $data['id'] . '">' . $data['name'] . ' (' . $data['alias'] . ')</option>';
                    }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Action</label>
                  <select class="form-control" name="action">
                    <?php
                    foreach ($action as $data) {
                      echo '<option value="' . $data['id'] . '">' . $data['name'] . ' (' . $data['alias'] . ')</option>';
                    }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Remark</label>
                  <select class="form-control" name="remark">
                    <?php
                    foreach ($remark as $data) {
                      echo '<option value="' . $data['id'] . '">' . $data['name'] . ' (' . $data['alias'] . ')</option>';
                    }
                    ?>
                  </select>
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary"><span class="fa fa-save"></span> Save</button>
              </div>
            </form>
              </div>
            </div>
          </div>
        <?php endforeach;?>
      </div>

    </section>
    <!-- /.content -->
  </div>
  <?php $this->load->view('templates/footer');?>
</div>
<!-- ./wrapper -->
<script src="<?php echo base_url('___/bower_components/datatables.net/js/jquery.dataTables.min.js');?>"></script>
<script src="<?php echo base_url('___/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js');?>"></script>
<script type="text/javascript">
  $(document).on('click', '#delete', function() {
      var ai = $(this).attr('data-id');
      $.ajax({
          type: "POST",
          data:'del=' + ai,
          url: "<?php echo base_url('Delete/relations');?>",
          success: function(response) {
            location.reload();
          },
          error: function () {
            console.log("errr");
          }
      });
    });
  $(function () {
    $('#Jigsaw').DataTable();
    $('#Network').DataTable();
  })
</script>
</body>
</html>
