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
    color: #fff !important;
  }
  .skin-red .table-header, .skin-red-light .table-header {
    background-color: #dd4b39;
  }
  .skin-blue .table-header, .skin-blue-light .table-header {
    background-color: #3c8dbc;
  }
  .skin-black .table-header, .skin-black-light .table-header {
    color: #333 !important;
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
        <?php echo $dev;?>
        <small>Chart</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dash');?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Chart</li>
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
              <h3 class="box-title">Chart <?php echo $dev;?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-xs-6">
                  <div class="button-group">
                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-cog"></span> Checked Problem<span class="caret"></span></button>
                    <ul class="dropdown-menu">
                      <?php foreach ($data as $value):?>
                        <li><a href="#" class="small" data-value="<?php echo $value['id'];?>" tabIndex="-1"><input type="checkbox"/>&nbsp;<?php echo $value['name'];?> (<?php echo $value['alias'];?>)</a></li>
                      <?php endforeach;?>
                    </ul>
                  </div>
                </div>
                <div class="col-xs-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Sort By Date :</label>
                    <div class="col-sm-4">
                      <select class="form-control" name="date" id="custom-date">
                        <option value="7day">Last 7 days</option>
                        <option value="lastweek">Last Week</option>
                        <option value="thismonth">This month</option>
                        <option value="lastmonth">Last month</option>
                        <option value="30day">Last 30 Days</option>
                        <option value="custom">Custom..</option>
                      </select>
                    </div>
                  </div>
                  <div class="row" id="customize" style="display: none;">
                    <div class="col-xs-3 col-xs-offset-3">
                      <div class="form-group">
                        <label>Start Date</label>
                        <input type="date" name="start" id="startdate" placeholder="Start Date" class="form-control" style="line-height: inherit;"/>
                      </div>
                    </div>
                    <div class="col-xs-3">
                      <div class="form-group">
                        <label>End Date</label>
                        <input type="date" name="end" id="enddate" placeholder="End Date" class="form-control" style="line-height: inherit;" />
                      </div>
                    </div>

                    <div class="col-xs-3">
                      <label></label>
                      <div class="form-group">
                        <button type="button" class="btn btn-primary" id="result">Result</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <br />
              <div id="table-data" style="overflow: auto">
              <table class="table table-striped">
                <thead class="table-header" id="table-heading">
                </thead>
                <tbody id="table-bodying">
                </tbody>
              </table>
              </div>
              <br />
              <div id="chart_div" style="height: 500px;"></div>
              
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
<script src="<?php echo base_url('___/dist/js/loader.js');?>"></script>
<script src="<?php echo base_url('___/bower_components/raphael/raphael.min.js');?>"></script>
<script src="<?php echo base_url('___/bower_components/morris.js/morris.min.js');?>"></script>
<script src="<?php echo base_url('___/bower_components/chart.js/Chart.js');?>"></script>
<script type="text/javascript">
  $.getScript("<?php echo base_url('Api/chart/' . $dev_id . '/1/7day');?>");
  var options = [];
  $( '.dropdown-menu a' ).on( 'click', function( event ) {
    var start = $('#startdate').val();
    var end = $('#enddate').val();
    var date = $('[name=date]').val();
    var $target = $( event.currentTarget ),
    val = $target.attr( 'data-value' ),
    $inp = $target.find( 'input' ),
    idx;
    if ( ( idx = options.indexOf( val ) ) > -1 ) {
      options.splice( idx, 1 );
      setTimeout( function() { $inp.prop( 'checked', false ) }, 0);
    } else {
      options.push( val );
      setTimeout( function() { $inp.prop( 'checked', true ) }, 0);
    }
    $( event.target ).blur();
    var data = encodeURIComponent(options.join());
    $("#chart_div").empty();
    $.getScript("<?php echo base_url('Api/chart/' . $dev_id);?>/" + data + "/" + date + "/" + start + "/" + end);
    return false;
  });

  $( '[name=date]' ).on( 'change', function( event ) {
    var start = $('#startdate').val();
    var end = $('#enddate').val();
    var date = $(this).val();
    var data = encodeURIComponent(options.join());
    if (data == '') {data = 1;}
    $("#chart_div").empty();
    $.getScript("<?php echo base_url('Api/chart/' . $dev_id);?>/" + data + "/" + date + "/" + start + "/" + end);
  });
</script>
<script type="text/javascript">
  $(document).on('change', '#custom-date', function(e) {
    var val = $(this).val();
    if (val == 'custom') {
      $('#customize').show();
    } else {
      $('#customize').hide();
    }
  });
  $(document).on('click', '#result', function(e) {
    var start = $('#startdate').val();
    var end = $('#enddate').val();
    var date = $('[name=date]').val();
    if (start == '' || end == '') {alert('Date Result belum ditentukan!'); } else {
      var data = encodeURIComponent(options.join());
      if (data == '') {data = 1;}
      $("#chart_div").empty();
      $.getScript("<?php echo base_url('Api/chart/' . $dev_id);?>/" + data + "/" + date + "/" + start + "/" + end);
    }
  })
</script>
</body>
</html>
