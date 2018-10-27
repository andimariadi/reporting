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
        Unit
        <small>Admin Control</small>
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
        <?php if ($level != 'report'):?>
        <div class="col-md-9">
        <?php else:?>
          <div class="col-md-12">
        <?php endif;?>
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo strtoupper( $dev . ' Population');?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="unit" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th style="width: 10px">#</th>
                    <th>ID Unit</th>
                    <?php if ($dev != 'network'):?>
                      <th>Series</th>
                      <th>Type</th>
                    <?php endif;?>
                    <th>Code Unit</th>
                    <th>Description</th>
                    <th>Position</th>
                    <th>Location</th>
                    <?php if ($dev != 'network'):?>
                      <th>S/N Display</th>
                      <th>S/N Router</th>
                      <th>S/N GPS</th>
                      <th>Antenna</th>
                    <?php endif;?>
                    <?php if ($dev == 'network'):?>
                      <th>Battery</th>
                    <?php endif;?>
                    <th>Backlog</th>
                    <th>Status</th>
                    <?php if ($dev != 'network'):?>
                      <th>Power Off</th>
                      <th>Locked</th>
                    <?php endif;?>
                    <?php if ($level != 'report'):?>
                    <th style="width: 60px">Action</th>
                    <?php endif;?>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 0; foreach ($unit as $value): $no++;
                  $key = empty(explode(';', $value['explode'])[0]) ? null : explode(';', $value['explode'])[0];
                  $battery = empty(explode(';', $value['explode'])[1]) ? null : explode(';', $value['explode'])[1];?>
                  <tr>
                    <td><?php echo $no;?></td>
                    <td><?php echo $value['id'];?></td>
                    <?php if ($dev != 'network'):?>
                      <td><?php echo $value['series_name'];?></td>
                      <td><?php echo $value['type_name'];?></td>
                    <?php endif;?>
                    <td><?php echo $value['code_name'];?></td>
                    <td><?php echo $value['description'];?></td>
                    <td><?php echo $value['position'];?></td>
                    <td><?php echo $value['location'];?></td>
                    <?php if ($dev != 'network'):?>
                      <td><?php echo $value['sn_display'];?></td>
                      <td><?php echo $value['sn_wb'];?></td>
                      <td><?php echo $value['sn_gps'];?></td>
                      <td><?php echo $value['antenna_name'];?></td>
                    <?php endif;?>
                    <?php if ($dev == 'network'):?>
                      <td><?php echo $battery;?></td>
                    <?php endif;?>
                    <td><?php echo $value['backlog'];?></td>
                    <td>
                      <?php
                      if ($value['status'] == 0) {
                        $status = '<span class="btn btn-success btn-flat btn-xs">Installed</span>';
                      } else {
                        $status = '<span class="btn btn-danger btn-flat btn-xs">Uninstall</span>';
                      }
                      echo trim($status);
                      ?>
                    </td>
                    <?php if ($dev != 'network'):?>
                      <td><?php echo $value['poweroff_name'];?></td>
                      <td>
                        <?php
                        if ($value['locked'] == 1) {
                          $locked = '<span class="btn btn-success btn-flat btn-xs">Locked</span>';
                        } else {
                          $locked = '<span class="btn btn-danger btn-flat btn-xs">Not Lock</span>';
                        }
                        echo trim($locked);
                        ?>
                      </td>
                    <?php endif;?>
                    <?php if ($level != 'report'):?>
                    <td>
                      <i class="fa fa-edit" data-toggle="modal" data-target="#modal-default" id="edit" data-id="<?php echo $value['id'];?>"></i>
                      <i class="fa fa-trash-o" id="delete" data-id="<?php echo $value['id'];?>"></i>
                    </td>
                    <?php endif;?>
                  </tr>
                <?php endforeach;?>
              </tbody>
            </table>
          </div>
        </div>


        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title"><?php echo strtoupper( 'Summary ' . $dev . ' Population');?></h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th width="20%"></th>
                  <th width="20%"></th>
                  <th width="20%" style="background-color: #00b10e; color: #fff;">Installed</th>
                  <th width="20%" style="background-color: #00b10e; color: #fff;">Un-Installed</th>
                  <th width="20%" style="background-color: #00b10e; color: #fff;">Total Installed</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($group as $key):?>
                  <tr class="header" style="background-color: #f0f0f0">
                    <td style="border-bottom: 1px solid #000;" colspan="2"><i class="fa fa-play" id="icon" style="margin-right: 10px"></i> <?php echo $key['location'];?></td>
                    <td style="border-bottom: 1px solid #000;"><?php echo $key['Installed'];?></td>
                    <td style="border-bottom: 1px solid #000;"><?php echo $key['Uninstalled'];?></td>
                    <td style="border-bottom: 1px solid #000;"><?php echo number_format($key['Percent'], 2) . ' %';?></td>
                  </tr>
                  <?php
                  if ($dev_id == 1) {
                    $sql = $this->Crud->query("SELECT `enum`.`name`, (COUNT(*)-SUM(IF(`status` = '1', `status`, 0))) as `Installed`, SUM(IF(`status` = 1, `status`, 0)) as `Uninstalled`, (COUNT(*)-SUM(IF(`status` = '1', `status`, 0)))/COUNT(`status`)*100 as `Percent`, `e2`.`name` as `type` FROM `unit` LEFT JOIN `enum` ON `unit`.`code_unit` = `enum`.`id` LEFT JOIN `enum` as `e2` ON `unit`.`type` = `e2`.`id` WHERE `location` = '{$key['location']}' AND `unit`.`device_id` = '{$dev_id}' GROUP BY `unit`.`type`,`code_unit`");
                  } else {
                    $sql = $this->Crud->query("SELECT `enum`.`name`, (COUNT(*)-SUM(IF(`status` = '1', `status`, 0))) as `Installed`, SUM(IF(`status` = 1, `status`, 0)) as `Uninstalled`, (COUNT(*)-SUM(IF(`status` = '1', `status`, 0)))/COUNT(`status`)*100 as `Percent`, `unit`.`id` as `type` FROM `unit` LEFT JOIN `enum` ON `unit`.`code_unit` = `enum`.`id` LEFT JOIN `enum` as `e2` ON `unit`.`type` = `e2`.`id` WHERE `location` = '{$key['location']}' AND `unit`.`device_id` = '{$dev_id}' GROUP BY `unit`.`id`, `code_unit`");
                  }
                  $sub_in[] = "";
                  $sub_un[] = "";
                  foreach ($sql as $value) {
                    echo '<tr style="display: none;">';
                    echo '<td style="border: 1px solid #999;">' . $value['type'] . '</td>';
                    echo '<td style="border: 1px solid #999;">' . $value['name'] . '</td>';
                    echo '<td style="border: 1px solid #999;">' . $value['Installed'] . '</td>';
                    echo '<td style="border: 1px solid #999;">' . $value['Uninstalled'] . '</td>';
                    echo '<td style="border: 1px solid #999;">' . number_format($value['Percent'], 2) . ' %</td>';
                    echo '</tr>';
                    $sub_in[] = $value['Installed'];
                    $sub_un[] = $value['Uninstalled'];
                  }
                  ?>
                <?php endforeach;?>
                <tr class="header" style="background-color: #00b10e">
                  <td style="border-bottom: 1px solid #000;" colspan="2">Sub Total</td>
                  <td style="border-bottom: 1px solid #000;"><?php echo array_sum($sub_in);?></td>
                  <td style="border-bottom: 1px solid #000;"><?php echo array_sum($sub_un);?></td>
                  <td style="border-bottom: 1px solid #000;"><?php echo number_format((array_sum($sub_in)/(array_sum($sub_in)+array_sum($sub_un)))*100, 2) . ' %';?></td>
                </tr>
              </tbody>
            </table>

          </div>
        </div>
      </div>

      <?php if ($level != 'report'):?>
      <div class="col-md-3">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Add Unit</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <!-- form start -->
            <form role="form" method="post" action="<?php echo base_url('Save/unit/'. $dev);?>">
              <div class="box-body">
                <div class="form-group">
                  <label>ID Unit</label>
                  <input type="hidden" name="device" value="<?php echo $dev_id;?>">
                  <input class="form-control" name="id" placeholder="Type here" type="text" required autocomplete="off">
                </div>
                <?php if ($dev != 'network'):?>
                  <div class="form-group">
                    <label>Series</label>
                    <select class="form-control" name="series">
                      <?php
                      foreach ($series as $data) {
                        echo '<option value="' . $data['id'] . '">' . $data['name'] . '</option>';
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Type</label>
                    <select class="form-control" name="type">
                      <?php
                      foreach ($unit_type as $data) {
                        echo '<option value="' . $data['id'] . '">' . $data['name'] . '</option>';
                      }
                      ?>
                    </select>
                  </div>
                <?php endif;?>
                <div class="form-group">
                  <label>Equipment Type</label>
                  <select class="form-control" name="code_unit">
                    <?php if ($dev != 'network') {
                      foreach ($code_unit as $data) {
                        echo '<option value="' . $data['id'] . '">' . $data['name'] . '</option>';
                      }
                    } else {
                      foreach ($unit_type as $data) {
                        echo '<option value="' . $data['id'] . '">' . $data['name'] . '</option>';
                      }
                    }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label>Description</label>
                  <textarea class="form-control" name="description" placeholder="Type description here" required></textarea>
                </div>
                <div class="form-group">
                  <label>Position</label>
                  <input class="form-control" name="position" placeholder="Type here" type="text" required autocomplete="off">
                </div>
                <div class="form-group">
                  <label>Location</label>
                  <select name="location" class="form-control">
                    <option value="Central">Central</option>
                    <option value="North-West">North-West</option>
                    <option value="Wara">Wara</option>
                  </select>
                </div>
                <?php if ($dev != 'network'):?>
                  <div class="form-group">
                    <label>S/N Display</label>
                    <input class="form-control" name="sn_display" placeholder="Type here" type="text" required autocomplete="off">
                  </div>
                  <div class="form-group">
                    <label>S/N Router</label>
                    <input class="form-control" name="sn_wb" placeholder="Type here" type="text" required autocomplete="off">
                  </div>
                  <div class="form-group">
                    <label>S/N GPS</label>
                    <input class="form-control" name="sn_gps" placeholder="Type here" type="text" required autocomplete="off">
                  </div>
                  <div class="form-group">
                    <label>Antenna</label>
                    <select class="form-control" name="antenna">
                      <?php
                      foreach ($antenna as $data) {
                        echo '<option value="' . $data['id'] . '">' . $data['name'] . '</option>';
                      }
                      ?>
                    </select>
                  </div>
                <?php endif;?>
                <?php if ($dev == 'network'):?>
                  <div class="form-group">
                    <label>Battery</label>
                    <input class="form-control" name="battery" placeholder="Type here" type="text" autocomplete="off">
                  </div>
                <?php endif;?>
                <div class="form-group">
                  <label>Status</label>
                  <select class="form-control" name="status">
                    <option value="0">Installed</option>
                    <option value="1">Uninstall</option>
                  </select>
                </div>
                <?php if ($dev != 'network'):?>
                  <div class="form-group">
                    <label>Power Off ?</label>
                    <select class="form-control" name="relay">
                      <?php
                      foreach ($poweroff as $data) {
                        echo '<option value="' . $data['id'] . '">' . $data['name'] . '</option>';
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Locked</label>
                    <select class="form-control" name="locked">
                      <option value="0">Not Locked</option>
                      <option value="1">Locked</option>
                    </select>
                  </div>
                </div>
              <?php endif;?>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary"><span class="fa fa-save"></span> Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <!-- /modal edit -->
      <div class="modal fade" id="modal-default" style="display: none;">
        <div class="modal-dialog">
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
        <?php endif;?>
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
<?php if ($level != 'report'):?>
<script type="text/javascript">
  $(document).on('click', '#edit', function(e) {
    var id = $(this).attr('data-id');
    var vPool="";
    $.getJSON('<?php echo base_url('Api/unit');?>/' + id, function(jd) {
      $.each(jd.data, function(i, val){   
        vPool += '<div class="form-group">'+
        '<label>Name</label>'+
        '<input class="form-control" name="old" type="hidden" required autocomplete="off" value="' + this['id'] + '">'+
        '<input class="form-control" name="device" type="hidden" required autocomplete="off" value="' + this['device_id'] + '">'+
        '<input class="form-control" name="id" type="text" required autocomplete="off" value="' + this['id'] + '">'+
        '</div>';
        vPool += <?php if ($dev != 'network'):?>
        '<div class="form-group">' +
        '<label>Series</label>' +
        '<select class="form-control" name="series" id="edit_series">' +
        <?php
        foreach ($series as $data) {
          echo '\'<option value="' . $data['id'] . '">' . $data['name'] . '</option>\'+';
        }
        ?>
        '</select>' +
        '</div>' +
        '<div class="form-group">' +
        '<label>Type</label>' +
        '<select class="form-control" name="type" id="edit_type">' +
        <?php
        foreach ($unit_type as $data) {
          echo '\'<option value="' . $data['id'] . '">' . $data['name'] . '</option>\'+';
        }
        ?>
        '</select>' +
        '</div>' +
      <?php endif;?>
      '<div class="form-group">' +
      '<label>Equipment Type</label>' +
      '<select class="form-control" name="code_unit" id="edit_code_unit">' +
      <?php if ($dev != 'network') {
        foreach ($code_unit as $data) {
          echo '\'<option value="' . $data['id'] . '">' . $data['name'] . '</option>\' + ';
        }
      } else {
        foreach ($unit_type as $data) {
          echo '\'<option value="' . $data['id'] . '">' . $data['name'] . '</option>\' + ';
        }
      }
      ?>
      '</select>' + 
      '</div>' + 
      '<div class="form-group">' + 
      '<label>Description</label>' + 
      '<textarea class="form-control" name="description" placeholder="Type description here" required>' + this['description'] + '</textarea>' + 
      '</div>' + 
      '<div class="form-group">' +
      '<label>Position</label>' +
      '<input class="form-control" name="position" placeholder="Type here" type="text" required autocomplete="off" value="' + this['position'] + '">' +
      '</div>' + 
      '<div class="form-group">' +
      '<label>Location</label>' +
      '<select name="location" class="form-control" id="editing-location">' +
        '<option value="Central">Central</option>' +
       ' <option value="North-West">North-West</option>' +
        '<option value="Wara">Wara</option>' +
      '</select>' +
      '</div>';
      <?php if ($dev != 'network'):?>
        vPool += '<div class="form-group">' +
        '<label>S/N Display</label>' +
        '<input class="form-control" name="sn_display" placeholder="Type here" type="text" required autocomplete="off" value="' + this['sn_display'] + '">' +
        '</div>' +
        '<div class="form-group">' +
        '<label>S/N Router</label>' +
        '<input class="form-control" name="sn_wb" placeholder="Type here" type="text" required autocomplete="off" value="' + this['sn_wb'] + '">' +
        '</div>' +
        '<div class="form-group">' +
        '<label>S/N GPS</label>' +
        '<input class="form-control" name="sn_gps" placeholder="Type here" type="text" required autocomplete="off" value="' + this['sn_gps'] + '">' +
        '</div>' +
        '<div class="form-group">' +
        '<label>Antenna</label>' +
        '<select class="form-control" name="antenna" id="edit_antenna">' +
        <?php
        foreach ($antenna as $data) {
          echo '\'<option value="' . $data['id'] . '">' . $data['name'] . '</option>\' + ';
        }
        ?>
        '</select>' +
        '</div>'
      <?php endif;?>
      ;
      <?php if ($dev == 'network'):?>
        vPool += '<div class="form-group">' +
          '<label>Battery</label>' +
          '<input class="form-control" name="battery" placeholder="Type here" type="text" autocomplete="off" value="' + this['battery'] + '">' +
        '</div>';
      <?php endif;?>
      vPool += '<div class="form-group">' +
      '<label>Status</label>' +
      '<select class="form-control" name="status" id="edit_status">' +
      '<option value="0">Installed</option>' +
      '<option value="1">Uninstall</option>' +
      '</select>' +
      '</div>';
      <?php if ($dev != 'network'):?>
        vPool += '<div class="form-group">' +
        '<label>Power</label>' +
        '<select class="form-control" name="poweroff" id="edit_poweroff">' +
        <?php
        foreach ($poweroff as $data) {
          echo '\'<option value="' . $data['id'] . '">' . $data['name'] . '</option>\' + ';
        }
        ?>
        '</select>' +
        '</div>' +
        '<div class="form-group">' +
        '<label>Locked</label>' +
        '<select class="form-control" name="locked"  id="edit_locked">' +
        '<option value="0">Not Locked</option>' +
        '<option value="1">Locked</option>' +
        '</select>' +
        '</div>';
      <?php endif;?>
    });
$('#modal-body').html(vPool);
$.each(jd.data, function(i, val){   
  $('#edit_antenna').val(this['antenna']);
  $('#edit_status').val(this['status']);
  $('#edit_locked').val(this['locked']);
  $('#edit_poweroff').val(this['poweroff']);
  $('#edit_series').val(this['series']);
  $('#edit_type').val(this['type']);
  $('#edit_code_unit').val(this['code_unit']);
  $("#editing-location").val(this['location']);
});
});
});

$(document).on('click', '#submit', function(e) {
  var data = $('#form-edit').serialize();
  $.ajax({
    type: "POST",
    data:data,
    url: "<?php echo base_url('Edit/unit');?>",
    success: function(response) {
      location.reload();
    },
    error: function () {
      console.log("errr");
    }
  });
});

$(document).on('keypress', '#name, #alias', function(e) {
  if(e.which == 13) {
    $('#submit').click();
  }
});

$(document).on('click', '#delete', function() {
  var ai = $(this).attr('data-id');
  $.ajax({
    type: "POST",
    data:'del=' + ai,
    url: "<?php echo base_url('Delete/unit');?>",
    success: function(response) {
      location.reload();
    },
    error: function () {
      console.log("errr");
    }
  });
});


</script>
<?php endif;?>
<script type="text/javascript">
  $(function () {
    $('#unit').DataTable()
  });
  $('.header').click(function(){
  $(this).toggleClass('has-added');
  if ($(this).hasClass('has-added')) {
    $(this).parent(".fa").html('fa-eject');
  } else {
    $(this).parent(".fa").html('fa-eject');
  }
    $(this).nextUntil('tr.header').slideToggle(100);
  });
</script>
</body>
</html>
