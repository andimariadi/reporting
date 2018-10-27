<body class="hold-transition skin-blue sidebar-mini sidebar-collapse">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="../../index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>M</b>DI</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Reporting</b>MDI</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li><a href="<?php echo base_url('Auth/logout');?>"><i class="fa fa-sign-out text-red"></i> <span>Logout</span></a></li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $dev_name;?>
        <small>Report</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Report</a></li>
        <li class="active"><?php echo $dev_name;?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <?php if ($this->session->flashdata('msg') != '') {
        echo $this->session->flashdata('msg');
      }
      ?>
      <form method="POST" action="<?php echo base_url('Report/save');?>">
      <div class="row">
        <?php if ($dev_name != 'Other'):?>
        <!-- left column -->
        <div class="col-md-6">
          <!-- Form Information -->
          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Information</h3>
            </div>
            <div class="box-body">
              <div class="form-group" id="labelunit">
                  <label>ID Unit</label>
                  <input type="text" name="unit" class="form-control" id="unit" placeholder="Enter ID Unit" required>
                  <span class="help-block" style="display: none"><i class="fa fa-times-circle-o"></i> ID Unit not Found!</span>
                </div>
                <div class="form-group">
                  <label id="labelunit">Work Location</label>
                  <input type="text" name="location" class="form-control" id="location" placeholder="Enter Work Location" required>
                </div>
                <!-- select -->
                <?php if ($dev_name == 'Jigsaw'):?>
                <div class="form-group">
                  <label>BD Type</label>
                  <select class="form-control" name="bd">
                    <?php
                    foreach ($bd as $value):
                      echo "<option value=\"{$value['id']}\">{$value['name']}</option>";
                    endforeach;
                    ?>
                  </select>
                </div>
                <?php endif;?>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- form person -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Person</h3>
            </div>
            <!-- /.box-header -->
              <div class="box-body">
                <div class="form-group">
                  <label id="labelbd">BD Receiver</label>
                  <input type="text" name="bd_rec" class="form-control" id="bd_rec" placeholder="Enter BD Receiver" required>
                </div>
                <div class="form-group">
                  <label id="labelrfu">RFU Receiver</label>
                  <input type="text" name="rfu_rec" class="form-control" id="rfu_rec" placeholder="Enter RFU Receiver" required>
                </div>
                <!-- Select multiple-->
                <div class="form-group">
                  <label id="labelpic">Person in Charge</label>
                  <select multiple class="form-control" name="pic[]" required>
                    <?php
                    foreach ($pic as $value):
                      echo "<option value=\"{$value['id']}\">{$value['name']} ({$value['username']})</option>";
                    endforeach;
                    ?>
                  </select>
                  <p class="help-block"><i class="fa fa-question-circle"></i> Press CTRL for multiple select.</p>
                </div>
              </div>
              <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <?php if ($dev_name == 'Jigsaw'):?>
          <!-- Form Waiting Time -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Waiting Time</h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-xs-6">
                  <div class="form-group">
                    <label id="labelstartwait">Start Time</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                      <input type="text" name="startwait" class="form-control" id="startwait" placeholder="HH:MM:SS" required>
                    </div>
                  </div>
                </div>
                <div class="col-xs-6">
                  <div class="form-group">
                    <label id="labelendwait">End Time</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                      <input type="text" name="endwait" class="form-control" id="endwait" placeholder="HH:MM:SS" required>
                    </div>
                  </div>
                </div>
              </div>
              <p class="help-block"><i class="fa fa-question-circle"></i> Type time format HH:MM:SS. Ex: (<?php echo date('H');?>:00:00)</p>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          <?php endif;?>


          <!-- Form Waiting Time -->
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Action Time</h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-xs-6">
                  <div class="form-group">
                    <label id="labelstartaction">Start Time</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                      <input type="text" name="startaction" class="form-control" id="startaction" placeholder="HH:MM:SS" required>
                    </div>
                  </div>
                </div>
                <div class="col-xs-6">
                  <div class="form-group">
                    <label id="labelendaction">End Time</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                      <input type="text" name="endaction" class="form-control" id="endaction" placeholder="HH:MM:SS" required>
                    </div>
                  </div>
                </div>
              </div>
              <p class="help-block"><i class="fa fa-question-circle"></i> Type time format HH:MM:SS. Ex: (<?php echo date('H');?>:00:00)</p>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-6">

          

          <!-- form Data -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Data</h3>
            </div>
            <!-- /.box-header -->
              <div class="box-body">
                <div class="form-group">
                  <label>Problem</label>
                  <select class="form-control" name="problem">
                    <?php
                    foreach ($problem as $value):
                      echo "<option value=\"{$value['id']}\">{$value['name']} ({$value['alias']})</option>";
                    endforeach;
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label>Analysis</label>
                  <select class="form-control" name="analysis" disabled="disabled">
                    <option value="0">Change Analysis</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Cause By Problem</label>
                  <select class="form-control" name="cause" disabled="disabled">
                    <option value="0">Change Cause By Problem</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Action</label>
                  <select class="form-control" multiple name="action[]" id="action_press" disabled="disabled">
                    <option value="0">Change Action</option>
                  </select>
                  <p class="help-block"><i class="fa fa-question-circle"></i> Press CTRL for multiple select.</p>
                </div>
                <div class="form-group">
                  <label>Remark</label>
                  <select class="form-control" multiple name="remark[]" id="remark_press" disabled="disabled">
                    <option value="0">Change Remark</option>
                  </select>
                  <p class="help-block"><i class="fa fa-question-circle"></i> Press CTRL for multiple select.</p>
                </div>
              </div>
              <!-- /.box-body -->
          </div>


          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Other Info</h3>
            </div>
            <!-- /.box-header -->
              <div class="box-body">

                <div class="row">
                  <?php if ($dev_name == 'Jigsaw'):?>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label id="labelsn_display">Antenna</label>
                      <select class="form-control" name="antenna">
                        <?php
                        foreach ($antenna as $value):
                          echo "<option value=\"{$value['id']}\">{$value['name']}</option>";
                        endforeach;
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label id="labelpoweroff">Power Off ?</label>
                      <select class="form-control" name="poweroff">
                        <?php
                        foreach ($poweroff as $value):
                          echo "<option value=\"{$value['id']}\">{$value['name']}</option>";
                        endforeach;
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label id="labellocked">Locked ?</label>
                      <select class="form-control" name="locked">
                        <option value="0">Not Locked</option>
                        <option value="1">Locked</option>
                      </select>
                    </div>
                  </div>
                  <?php endif;?>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label id="labellocked">Status</label>
                      <select class="form-control" name="status">
                        <option value="0">RFU</option>
                        <option value="1">Not RFU</option>
                      </select>
                    </div>
                  </div>
                  <?php if ($dev_name == 'Network'):?>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label id="labellocked">Battery</label>
                      <input type="text" name="battery" class="form-control" id="battery" placeholder="Enter Battery" />
                    </div>
                  </div>
                  <?php endif;?>
                </div>

                <?php if ($dev_name == 'Jigsaw'):?>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label id="labelsn_display">S/N Display</label>
                      <input type="text" name="sn_display" class="form-control" id="sn_display" placeholder="Enter S/N Display" required>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label id="labelsn_router">S/N Router</label>
                      <input type="text" name="sn_wb" class="form-control" id="sn_wb" placeholder="Enter S/N Router" required>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label id="labelsn_gps">S/N GPS</label>
                      <input type="text" name="sn_gps" class="form-control" id="sn_gps" placeholder="Enter S/N GPS" required>
                    </div>
                  </div>
                </div>
                <?php endif;?>
                <div class="form-group">
                  <label id="labelstartaction">Other Information</label>
                  <textarea class="form-control" name="action-o"></textarea>
                </div>
              </div>
              <!-- /.box-body -->
          </div>
        </div>
        <?php else:?>

        <div class="col-md-12">
          <!-- Form Waiting Time -->
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Action Time</h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-xs-6">
                  <div class="form-group">
                    <label id="labelstartaction">Start Time</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                      <input type="text" name="startaction" class="form-control" id="startaction" placeholder="HH:MM:SS" required>
                    </div>
                  </div>
                </div>
                <div class="col-xs-6">
                  <div class="form-group">
                    <label id="labelendaction">End Time</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                      <input type="text" name="endaction" class="form-control" id="endaction" placeholder="HH:MM:SS" required>
                    </div>
                  </div>
                </div>
              </div>
              <p class="help-block"><i class="fa fa-question-circle"></i> Type time format HH:MM:SS. Ex: (<?php echo date('H');?>:00:00)</p>
            </div>
            <!-- /.box-body -->
          </div>

          <!-- Form Waiting Time -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Information</h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-xs-6">
                  <div class="form-group">
                    <label id="labelstartaction">Activity</label>
                    <textarea class="form-control" name="action-o"></textarea>
                  </div>
                </div>
                <div class="col-xs-6">
                  <div class="form-group">
                    <label id="labelstartaction">Remark</label>
                    <textarea class="form-control" name="remark-o"></textarea>
                  </div>
                </div>
              </div>
              <p class="help-block"><i class="fa fa-question-circle"></i> One Activity for one remark.</p>
            </div>
            <!-- /.box-body -->
          </div>
        </div>

        <?php endif;?>
        <div class="col-xs-12">
          <button type="submit" class="btn btn-primary btn-block">Save Now!</button>
        </div>
      </div>
      <!-- /.row -->
      </form>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.0
    </div>
    <strong>Copyright &copy; <?php
    $old = '2018';
    $now = date('Y');
    if ($old == $now) {
      echo $now;
    } else {
      echo $old . " - " . $now;
    }
    ?>
    <a href="https://github.com/andimariadi">Anak Magang Developers</a>.</strong> All rights reserved.
  </footer>
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="<?php echo base_url('___/bower_components/jquery/dist/jquery.min.js');?>"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url('___/bower_components/bootstrap/dist/js/bootstrap.min.js');?>"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo base_url('___/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js');?>"></script>
<!-- FastClick -->
<script src="<?php echo base_url('___/bower_components/fastclick/lib/fastclick.js');?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url('___/dist/js/adminlte.min.js');?>"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url('___/dist/js/demo.js');?>"></script>
<script type="text/javascript">
  $(document).on('click', '[name=problem]', function() {
    var id = $(this).val()
    $.getJSON('<?php echo base_url('Api/relations/');?>' + id, function(jd) {
      var vPool="";
      $.each(jd.data, function(){
        vPool += '<option value="' + this['id'] + '">' + this['name'] + ' (' + this['alias'] + ')</option>';
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
        vPool += '<option value="' + this['id'] + '">' + this['name'] + ' (' + this['alias'] + ')</option>';
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
        vPool += '<option value="' + this['id'] + '">' + this['name'] + ' (' + this['alias'] + ')</option>';
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
    if (id != '') {
      $.getJSON('<?php echo base_url('Api/relations/');?>' + problem + '/' + analysis + '/' + cause + '/' + id, function(jd) {
        var vPool="";
        $.each(jd.data, function(){
          vPool += '<option value="' + this['id'] + '">' + this['name'] + ' (' + this['alias'] + ')</option>';
        });
        $('#remark_press').html(vPool);
        $('#remark_press').removeAttr('disabled');
      });
    }
  });

  //for unit search
  $(document).on('change', '#unit', function(e) {
    var id = $(this).val();
    $.getJSON('<?php echo base_url('Api/unit/');?>' + '/' + id, function(jd) {
      if (jd.data == 'empty') {
        $('#labelunit').addClass('has-error');
        $('#labelunit .help-block').html('<b>"' + id + '"</b> not found on database!').css("display", "block");
        $('[name=location]').val('');
        $('[name=sn_display]').val('');
        $('[name=sn_wb]').val('');
        $('[name=sn_gps]').val('');
        $('[name=battery]').val('');
      } else {
        $.each(jd.data, function(){
          $('#labelunit').removeClass('has-error');
          $('#labelunit .help-block').css("display", "none");
          $('[name=location]').val(this['position']);
          $('[name=sn_display]').val(this['sn_display']);
          $('[name=sn_wb]').val(this['sn_wb']);
          $('[name=sn_gps]').val(this['sn_gps']);
          $('[name=poweroff]').val(this['poweroff']);
          $('[name=locked]').val(this['locked']);
          $('[name=antenna]').val(this['antenna']);
          $('[name=status]').val(this['status']);
          $('[name=battery]').val(this['battery']);
        });
      }
    });
  });
</script>
</body>
</html>
