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
        Time Periodic
        <small>Admin Control</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dash');?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Time Periodic</li>
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
              <h3 class="box-title">Periodic</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
                <tbody><tr>
                  <th style="width: 10px">#</th>
                  <th>Year</th>
                  <th>Month of Periodic</th>
                  <th style="width: 60px">Action</th>
                </tr>
                <?php
                $no = 0;
                foreach ($data as $val) {
                  $no++;
                  echo '<tr class="totodo">
                  <th>' . $no . '. </th>
                  <td>' . $val['year'] . '</td>
                  <td>' . substr($val['time_period'], 1, 1) . ' Month</td>
                  <td class="tools">
                  <i class="fa fa-trash-o" id="delete" data-id="' . $val['id'] . '"></i>
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
              <h3 class="box-title">Time Periodic</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" action="<?php echo base_url('Save/periodic');?>">
              <div class="box-body">
                <div class="form-group">
                  <label>Year</label>
                  <input class="form-control" name="year" placeholder="Type year" type="text" required autocomplete="off">
                </div>
                <div class="form-group">
                  <label>Month of Periodic</label>
                  <select class="form-control" name="month">
                    <?php
                      for ($i=1; $i <= 12; $i++) { 
                        echo '<option value="' . $i . '">' . $i . ' Month</option>';
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
          <!-- /.box -->

        </div>
      </div>

    </section>
    <!-- /.content -->
  </div>
  <?php $this->load->view('templates/footer');?>
</div>
<!-- ./wrapper -->
<script type="text/javascript">
  $(document).on('click', '#delete', function() {
      var ai = $(this).attr('data-id');
      $.ajax({
          type: "POST",
          data:'del=' + ai,
          url: "<?php echo base_url('Delete/periodic');?>",
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
