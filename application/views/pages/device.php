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
        Device
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dash');?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Device</li>
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
        <div class="col-md-8">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Data Device</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
                <tbody><tr>
                  <th style="width: 10px">#</th>
                  <th>Device Name</th>
                  <th>Total Report</th>
                  <th style="width: 40px">Value</th>
                  <th style="width: 60px">Action</th>
                </tr>
                <?php
                $no = 0;
                $total = array_sum(array(@$device[0]['total'], @$device[1]['total']));
                foreach ($device as $data) {
                  $no++;
                  if (strtolower($data['name']) == 'jigsaw') {
                    $bar = 'progress-bar-primary';
                    $bad = 'bg-light-blue';
                  } else {
                    $bar = 'progress-bar-success';
                    $bad = 'bg-green';
                  }
                  echo '<tr class="totodo">
                  <th>' . $no . '. </th>
                  <td>' . $data['name'] . '</td>
                  <td>
                  <div class="progress progress-xs progress-striped">
                  <div class="progress-bar ' . $bar . '" style="width: ' . @number_format($data['total']/$total*100, 2) . '%"></div>
                  </div>
                  </td>
                  <td><span class="badge ' . $bad . '">' . @number_format($data['total']/$total*100, 2) . '%</span></td>
                  <td class="tools">
                  <i class="fa fa-edit" data-toggle="modal" data-target="#modal-default" id="edit" data-id="' . $data['id'] . '"></i>
                  <i class="fa fa-trash-o" id="delete" data-id="' . $data['id'] . '"></i>
                  </td>
                  </tr>';
                }
                ?>
              </tbody></table>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Device Report</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" action="<?php echo base_url('Save/device');?>">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Device Name</label>
                  <input class="form-control" name="device" placeholder="Type device name" type="text" required autocomplete="off">
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary"><span class="fa fa-save"></span> Save</button>
              </div>
            </form>
          </div>
          <!-- /.box -->


          <!-- /modal edit -->
          <div class="modal fade" id="modal-default" style="display: none;">
            <div class="modal-dialog">
              <div class="modal-content">
                <form method="post" id="form-edit">
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
      </div>

    </section>
    <!-- /.content -->
  </div>
  <?php $this->load->view('templates/footer');?>
</div>
<!-- ./wrapper -->
<script type="text/javascript">
  $(document).on('click', '#edit', function(e) {
    var id = $(this).attr('data-id');
    var vPool="";
    $.getJSON('<?php echo base_url('Api/device');?>/' + id, function(jd) {
      $.each(jd.data, function(i, val){   
        vPool += '<div class="form-group">'+
                  '<label>Device Name</label>'+
                  '<input class="form-control" name="id" type="hidden" required autocomplete="off" value="' + this['id'] + '">'+
                  '<input class="form-control" name="device" id="device" placeholder="Type device here" type="text" required autocomplete="off" value="' + this['name'] + '">'+
                '</div>';
      });
      $('#modal-body').html(vPool);
    });
  });

  $(document).on('click', '#submit', function(e) {
    var data = $('#form-edit').serialize();
    $.ajax({
      type: "POST",
      data:data,
      url: "<?php echo base_url('Edit/device');?>",
      success: function(response) {
         location.reload();
      },
      error: function () {
        console.log("errr");
      }
    });
  });

  $(document).on('keypress', '#device', function(e) {
    if(e.which == 13) {
      $('#submit').click();
    }
  });

  $(document).on('click', '#delete', function() {
      var ai = $(this).attr('data-id');
      $.ajax({
          type: "POST",
          data:'del=' + ai,
          url: "<?php echo base_url('Delete/device');?>",
          success: function(response) {
            location.reload();
          },
          error: function () {
            console.log("errr");
          }
      });
    });

</script>
</body>
</html>
