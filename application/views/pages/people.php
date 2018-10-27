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
        People
        <small>Admin Control</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dash');?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">People</li>
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
              <h3 class="box-title">Data People</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
                <tbody><tr>
                  <th style="width: 10px">#</th>
                  <th>Username</th>
                  <th>Name</th>
                  <th>Description</th>
                  <th>Level</th>
                  <th>Status</th>
                  <th style="width: 100px">Action</th>
                </tr>
                <?php
                $no = 0;
                foreach ($user as $data) {
                  $no++;
                  echo '<tr class="totodo">
                  <th>' . $no . '. </th>
                  <td>' . $data['username'] . '</td>
                  <td>' . $data['name'] . '</td>
                  <td>' . $data['description'] . '</td>
                  <td>' . $data['level'] . '</td>';
                  if (strtotime(date('Y-m-d H:i:s')) >= strtotime($data['last_login'])) {
                    $status = '<i class="fa fa-circle text-danger"></i> Offline';
                  } else {
                    $status = '<i class="fa fa-circle text-success"></i> Online';
                  }
                  echo '<td id="td_user_' . $data['username'] . '">' . $status . '</td>
                  <td class="tools">
                  <i class="fa fa-edit" data-toggle="modal" data-target="#modal-default" id="edit" data-id="' . $data['id'] . '" title="Edit"></i>
                  <i class="fa fa-trash-o" id="delete" data-id="' . $data['id'] . '" title="Delete"></i>
                  <i class="fa fa-key" id="reset" data-id="' . $data['id'] . '" data-user="' . $data['username'] . '" title="Reset Password"></i>
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
              <h3 class="box-title">Add People</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" action="<?php echo base_url('Save/people');?>">
              <div class="box-body">
                <div class="form-group">
                  <label>Username</label>
                  <input class="form-control" name="username" placeholder="Type username here" type="text" required autocomplete="off">
                </div>
                <div class="form-group">
                  <label>Name</label>
                  <input class="form-control" name="name" placeholder="Type name here" type="text" required autocomplete="off">
                </div>
                <div class="form-group">
                  <label>Password</label>
                  <input class="form-control" name="pass" placeholder="Type password here" type="password" required autocomplete="off">
                </div>
                <div class="form-group">
                  <label>Description</label>
                  <textarea class="form-control" name="description" placeholder="Type description here" required></textarea>
                </div>
                <div class="form-group">
                  <label>Level</label>
                  <select class="form-control" name="level">
                    <?php
                    foreach ($level as $data) {
                      echo '<option value="' . $data['id'] . '">' . $data['name'] . '</option>';
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
    $.getJSON('<?php echo base_url('Api/people');?>/' + id, function(jd) {
      $.each(jd.data, function(i, val){   
        vPool += '<div class="form-group">'+
        '<label>Username</label>'+
        '<input class="form-control" name="id" type="hidden" required autocomplete="off" value="' + this['id'] + '">'+
        '<input class="form-control" name="username" id="name" placeholder="Type username here" type="text" required autocomplete="off" value="' + this['username'] + '">'+
        '</div>';
        vPool += '<div class="form-group">'+
        '<label>Name</label>'+
        '<input class="form-control" name="name" id="name" placeholder="Type name here" type="text" required autocomplete="off" value="' + this['name'] + '">'+
        '</div>';
        vPool += '<div class="form-group">'+
        '<label>Description</label>'+
        '<textarea class="form-control" name="description" placeholder="Type description here" required>' + this['description'] + '</textarea>'+
        '</div>';
        vPool += '<div class="form-group">'+
        '<label>Level</label>'+
        '<select class="form-control" name="level" id="edit_level">'+
        <?php
        foreach ($level as $data) {
          echo '\'<option value="' . $data['id'] . '">' . $data['name'] . '</option>\'+';
        }
        ?>
        '</select>'+
        '</div>';
      });
      $('#modal-body').html(vPool);
      $.each(jd.data, function(i, val){   
        $('#edit_level').val(this['level']);
      });
    });
  });

  $(document).on('click', '#submit', function(e) {
    var data = $('#form-edit').serialize();
    $.ajax({
      type: "POST",
      data:data,
      url: "<?php echo base_url('Edit/people');?>",
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
          url: "<?php echo base_url('Delete/people');?>",
          success: function(response) {
            location.reload();
          },
          error: function () {
            console.log("errr");
          }
      });
    });

  $(document).on('click', '#reset', function() {
      var id = $(this).attr('data-id');
      var username = $(this).attr('data-user');
      $.ajax({
          type: "POST",
          data:'id=' + id + '&username=' + username,
          url: "<?php echo base_url('edit/reset_password');?>",
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
