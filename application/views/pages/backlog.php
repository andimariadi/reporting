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
        Backlog
        <small>Admin Elements</small>
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
        <?php foreach ($device as $value):?>
          <div class="col-md-6">
            <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title"><?php echo strtoupper($value['name']);?></h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <table class="table table-bordered">
                  <tbody><tr>
                    <th style="width: 10px">#</th>
                    <th>Name</th>
                    <th>Alias</th>
                    <th style="width: 60px">Action</th>
                  </tr>
                  <?php
                  $no = 0;
                  $sql = $this->Crud->query("SELECT * FROM `enum` WHERE `enum`.`type` = 'backlog' AND `enum`.`device_id` = '{$value['id']}' ORDER BY `alias`");
                  foreach ($sql as $data) {
                    $no++;
                    echo '<tr class="totodo">
                    <th>' . $no . '. </th>
                    <td>' . $data['name'] . '</td>
                    <td>' . $data['alias'] . '</td>
                    <td class="tools">
                    <i class="fa fa-edit" data-toggle="modal" data-target="#modal-default" id="edit" data-id="' . $data['id'] . '"></i>
                    <i class="fa fa-trash-o" id="delete" data-id="' . $data['id'] . '"></i>
                    </td>
                    </tr>';
                  }
                  ?>
                </tbody></table>

                <!-- form start -->
                <form role="form" method="post" action="<?php echo base_url('Save/enum/backlog');?>">
                  <div class="box-body">
                    <div class="form-group">
                      <label>Name</label>
                      <input type="hidden" name="device" value="<?php echo $value['id'];?>">
                      <input class="form-control" name="name" placeholder="Type here" type="text" required autocomplete="off">
                    </div>
                    <div class="form-group">
                      <label>Alias</label>
                      <input class="form-control" name="alias" placeholder="Type here" type="text" autocomplete="off">
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
          <!-- /.modal-dialog -->
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
      $.getJSON('<?php echo base_url('Api/enum');?>/' + id, function(jd) {
        $.each(jd.data, function(i, val){   
          vPool += '<div class="form-group">'+
          '<label>Name</label>'+
          '<input class="form-control" name="id" type="hidden" required autocomplete="off" value="' + this['id'] + '">'+
          '<input class="form-control" name="name" id="name" placeholder="Type here" type="text" required autocomplete="off" value="' + this['name'] + '">'+
          '</div>';
          vPool += '<div class="form-group">'+
          '<label>Alias</label>'+
          '<input class="form-control" name="alias" id="alias" placeholder="Type here" type="text" required autocomplete="off" value="' + this['alias'] + '">'+
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
        url: "<?php echo base_url('Edit/enum');?>",
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
        url: "<?php echo base_url('Delete/enum');?>",
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