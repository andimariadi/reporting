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
        User Profile
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Examples</a></li>
        <li class="active">User profile</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <?php if ($this->session->flashdata('msg') != '') {
        echo $this->session->flashdata('msg');
      }
      ?>

      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url('___/dist/img/avatar5.png');?>" alt="User profile picture">

              <h3 class="profile-username text-center"><?php echo $data['name'];?></h3>

              <p class="text-muted text-center"><?php echo strtoupper($data['level']);?></p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Jigsaw</b> <a class="pull-right"><?php echo $count_jigsaw;?></a>
                </li>
                <li class="list-group-item">
                  <b>Network</b> <a class="pull-right"><?php echo $count_network;?></a>
                </li>
              </ul>
              <?php if ($userprofile == $data['username']):?>
                <a href="#" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal-default"><i class="fa fa-key"></i> <b>Change Password</b></a>
              <?php endif;?>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- About Me Box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">About Me</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <p><?php echo $data['description'];?></p>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#timeline" data-toggle="tab" aria-expanded="false">Timeline</a></li>
              <?php if ($userprofile == $data['username']):?>
              <li><a href="#settings" data-toggle="tab" aria-expanded="true">Settings</a></li>
              <?php endif;?>
            </ul>
            <div class="tab-content">
              <!-- /.tab-pane -->
              <div class="tab-pane active" id="timeline">
                <!-- The timeline -->
                <ul class="timeline timeline-inverse" id="date-timeline">

                </ul>
              </div>
              <!-- /.tab-pane -->
              <?php if ($userprofile == $data['username']):?>
              <div class="tab-pane" id="settings">
                <form class="form-horizontal" method="post" action="<?php echo base_url('Edit/profile');?>">
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10">
                      <input class="form-control" placeholder="Name" name="name" type="text" value="<?php echo $data['name'];?>" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputExperience" class="col-sm-2 control-label">Description</label>

                    <div class="col-sm-10">
                      <textarea class="form-control" name="description" type="text" placeholder="Description"><?php echo $data['description'];?></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-danger">Submit</button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->
              <?php endif;?>
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- /modal edit -->
          <div class="modal fade" id="modal-default" style="display: none;">
            <div class="modal-dialog">
              <div class="modal-content">
                <form class="form-horizontal" method="post" action="<?php echo base_url('Edit/password');?>">
                  <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Change Password</h4>
                  </div>
                  <div class="modal-body">
                    <div class="form-group">
                      <label for="inputName" class="col-sm-4 control-label">Old Password</label>
                      <div class="col-sm-8">
                        <input class="form-control" placeholder="Old Password" name="oldpass" type="password" />
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputName" class="col-sm-4 control-label">New Password</label>
                      <div class="col-sm-8">
                        <input class="form-control" placeholder="New Password" name="newpass" id="newpass" type="password" />
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputName" class="col-sm-4 control-label">Re-type Password</label>
                      <div class="col-sm-8">
                        <input class="form-control" placeholder="Re-type Password" name="repass" id="repass" type="password" />
                        <span class="help-block" style="display: none"><i class="fa fa-ban"></i> Password does not match!</span>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Change Now</button>
                  </div>
                  </form>
                </div>
              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->

    </section>
    <!-- /.content -->
  </div>
    <?php $this->load->view('templates/footer');?>
  </div>
  <!-- ./wrapper -->
  <script type="text/javascript"> $(document).on('keyup', '#repass, #newpass', function() {var new_ = $('#newpass').val(); var repass = $('#repass').val(); if (new_ == repass) {$('#newpass').parent('.col-sm-8').removeClass('has-error'); $('#repass').parent('.col-sm-8').removeClass('has-error'); $('.help-block').css("display", "none"); } else {$('#newpass').parent('.col-sm-8').addClass('has-error'); $('#repass').parent('.col-sm-8').addClass('has-error'); $('.help-block').css("display", "block"); } }); 
    timeline(); function timeline() {var id = "<?php echo $username;?>"; var vPool=""; const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]; $.getJSON('<?php echo base_url('Api/date_timeline');?>/' + id, function(jd) {$.each(jd.data, function(i, val){var time = this['date']; var date = new Date(this['date']); var timeline=""; vPool += '<!-- timeline time label -->' + '<li class="time-label">' + '<span class="bg-green">' + date.getDate() + ' ' + monthNames[(date.getMonth())] + '. ' + date.getFullYear() + '</span>' + '</li>' + '<!-- /.timeline-label --><div id="date_' + time + '"></div>'; $.getJSON('<?php echo base_url('Api/timeline');?>/' + time + '/' + id, function(jd) {$.each(jd.data, function(i, val){if (this['category'] == 'Schedule') {var bg = 'bg-aqua'; } else {var bg = 'bg-red'; } timeline += '<!-- timeline time label -->' + '<li>' + '<i class="fa fa-book ' + bg + '"></i>' + '<div class="timeline-item">' + '<span class="time"><i class="fa fa-clock-o"></i> ' + this['updated_date'] + '</span>' + '<h3 class="timeline-header no-border"><a href="<?php echo base_url('Dash/report_summary/');?>' + this['unit_id'] + '">' + this['unit_id'] + '</a> <b>' + this['problem'] + '</b> analysis <i>' + this['analysis'] + '</i>' + '</h3>' + '</div>' + '</li>' + '<!-- /.timeline-label -->'; }); $('#date_' + time).after(timeline); }); }); vPool += '<li><i class="fa fa-clock-o bg-gray"></i></li>'; $('#date-timeline').html(vPool); }); }
  </script>
</body>
</html>