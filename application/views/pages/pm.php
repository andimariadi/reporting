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
        <small>Preventive Maintenance</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dash');?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Preventive Maintenance</li>
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
              <h3 class="box-title"><?php echo strtoupper($dev . ' Preventive Maintenance');?></h3>
            </div>
            <div class="box-header clearfix">
              <div class="input-group" id="form-search">
                <input class="form-control" type="text" placeholder="Type unit id here" id="truck_id">
                    <span class="input-group-btn">
                      <button type="button" class="btn btn-info btn-flat" id="search">Search!</button>
                    </span>
              </div>
              <span class="help-block" id="id-search" style="display: none;"><i class="fa fa-times-circle-o"></i> Unit ID not found!</span>
              <!-- for search -->
            </div>
              <!-- /.box-header -->
              <div class="box-body">
                <?php if ($year == '' && $month == ''):?> <ul class="sidebar-menu" data-widget="tree" id="year_list"></ul> <?php endif; ?>
                <?php if ($year != '' && $month != ''): ?>
                    <h5>Preventive Maintenance <b><?php echo strtoupper($dev) . ' ' . $year . ' - ' . date('F', strtotime($year . '-' . $month . '-01'));?></b></h5>
                    <div  style="overflow: auto">
                      <table class="table table-striped">
                        <thead class="table-header">
                          <tr>
                            <th style="vertical-align: middle;text-align: center;" width="1%">No.</th>
                            <th style="vertical-align: middle;text-align: center;" width="10%">Type Unit</th>
                            <th style="vertical-align: middle;text-align: center;" width="10%">Unit</th>
                            <th style="vertical-align: middle;text-align: center;" width="10%">Date</th>
                            <th style="vertical-align: middle;text-align: center;" width="10%">S/N Screen</th>
                            <th style="vertical-align: middle;text-align: center;" width="10%">S/N Wifibox</th>
                            <th style="vertical-align: middle;text-align: center;" width="10%">S/N GPS</th>
                            <th style="vertical-align: middle;text-align: center;" width="39%">PIC</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php $no=0;foreach ($query as $value): $no++?>
                            <tr>
                              <td><?php echo $no;?></td>
                              <td><?php echo $value['type'];?></td>
                              <td><?php echo $value['unit_id'];?></td>
                              <td><?php echo $value['date'];?></td>
                              <td><?php echo $value['sn_display'];?></td>
                              <td><?php echo $value['sn_wb'];?></td>
                              <td><?php echo $value['sn_gps'];?></td>
                              <td><?php echo $value['pic'];?></td>
                            </tr>
                          <?php endforeach;?>
                        </tbody>
                      </table>
                    </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>

      </section>
      <!-- /.content -->
    </div>
    <?php $this->load->view('templates/footer');?>
  </div>
  <!-- ./wrapper -->
  <?php if ($year == '' && $month == ''): ?>
    <script type="text/javascript">
      const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
      var vPool = '';
      $.getJSON('<?php echo base_url('Api/date_pm/' . $dev_id);?>', function(jd) {
        $.each(jd.data, function(i, val){
          vPool += '<li class="treeview">' + '<a href="#" id="get_date" data-date="' + this['date'] + '">' + '<i class="fa fa-calendar-minus-o"></i> <span>' + this['date'] + '</span>' + '<span class="pull-right-container">' + '<i class="fa fa-angle-left pull-right"></i>' + '</span>' + '</a>' + '<ul class="treeview-menu" id="list_date_' + this['date'] + '">' + '</ul>' + '</li>';
        });
        $('#year_list').html(vPool);
      });
      $(document).on('click', '#get_date', function(e) {
        var date = $(this).attr('data-date');
        var dev_id = '<?php echo $dev_id;?>';
        var vPool=""; 
        $.getJSON('<?php echo base_url('Api/date_pm/' . $dev_id);?>/' + date, function(jd) {
          $.each(jd.data, function(i, val){
            if (dev_id == 2) {
              vPool += '<li>'+ 
              '<a href="<?php echo $dev;?>/' + date + '/' + this['date'] + '"><i class="fa fa-angle-right"></i> ' + monthNames[this['date']-1] + '</a>'+ '</li>';
            } else {
              vPool += '<li class="treeview">'+ 
              '<a href="#" id="get_periodic" data-date="' + date + '" data-id="' + this['date'] + '"><i class="fa fa-angle-right"></i> Periodic ' + this['date'] + '</a>'+
              '<ul class="treeview-menu" id="list_period_' + date + '_' + this['date'] + '">' + '</ul>' +
              '</li>';
            }
          });
          $('#list_date_' + date).html(vPool); 
        }); 
      });
      $(document).on('click', '#get_periodic', function(e) {
        var date = $(this).attr('data-date');
        var id = $(this).attr('data-id');
        var dev_id = '<?php echo $dev_id;?>';
        var vPool=""; 
        $.getJSON('<?php echo base_url('Api/period_pm/' . $dev_id . '/');?>' + date + '/' + id, function(jd) {
          $.each(jd.data, function(i, val){
            vPool += '<li>'+ 
              '<a href="<?php echo $dev;?>/' + date + '/' + this['date'] + '" id="periodic" data-id="' + this['date'] + '"><i class="fa fa-angle-right"></i> ' + monthNames[this['date']-1] + '</a>'+
              '</li>';
          });
          $('#list_period_' + date + '_' + id).html(vPool); 
        }); 
      });
      </script>
    <?php endif; ?>
    <script type="text/javascript">
      $(document).on('click', '#search', function() {var id = $('#truck_id').val(); window.location.assign("<?php echo base_url('Dash/pm_summary/');?>" + id); });
      $(document).on('keyup', '#truck_id', function(e) {var id = $(this).val(); $.getJSON('<?php echo base_url('Api/unit/');?>' + '/' + id, function(jd) {if (jd.data == 'empty' && id != '') {$('#form-search').addClass('has-error'); $('#id-search').css("display", "block"); } else {$('#form-search').removeClass('has-error'); $('#id-search').css("display", "none"); if(e.which == 13) {$('#search').click(); } } }); });
    </script>
  </body>
  </html>