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
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo @number_format($count[0]['Jigsaw']);?></h3>

              <p>Monthly Jigsaw Activity</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="<?php echo base_url('Dash/report/jigsaw');?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo @number_format($count[0]['Network']);?></h3>

              <p>Monthly Network Activity</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="<?php echo base_url('Dash/report/network');?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php echo @number_format(($count[0]['Jigsaw']+$count[0]['Network'])/$total_unit, 2);?><sup style="font-size: 20px">%</sup></h3>

              <p>Average Monthly Activity</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <div class="small-box-footer">Jigsaw and Network</div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php echo @number_format($count[0]['Jigsaw']+$count[0]['Network']);?></h3>

              <p>Total Activity</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <div class="small-box-footer">Jigsaw and Network</div>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-7 connectedSortable">
          <!-- Custom tabs (Charts with tabs)-->
          <div class="nav-tabs-custom">
            <!-- Tabs within a box -->
            <ul class="nav nav-tabs pull-right">
              <li class="active"><a href="#revenue-chart" data-toggle="tab">Activity</a></li>
              <li><a href="#sales-chart" data-toggle="tab">Top 5 Jigsaw Activity</a></li>
              <li><a href="#network-chart" data-toggle="tab">Top 5 Network Activity</a></li>
              <li class="pull-left header"><i class="fa fa-inbox"></i> Activity Report <?php echo date('Y');?></li>
            </ul>
            <div class="tab-content no-padding">
              <!-- Morris chart - Sales -->
              <div class="chart tab-pane active" id="revenue-chart">
                <canvas id="areaChart" style="height:300px"></canvas>
              </div>
              <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;"></div>
              <div class="chart tab-pane" id="network-chart" style="position: relative; height: 300px;"></div>
            </div>
          </div>
          <!-- /.nav-tabs-custom -->


          <!-- Calendar -->
          <div class="box box-solid bg-green-gradient">
            <div class="box-header">
              <i class="fa fa-user"></i>

              <h3 class="box-title">Employee Performance</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">


            </div>
            <!-- /.box-body -->
            <div class="box-footer text-black">
              <div id="chart_div" style="height: 500px;"></div>
            </div>
          </div>
          <!-- /.box -->

        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-5 connectedSortable">

          <!-- Map box -->
          <div class="box box-solid bg-teal-gradient" style="background: -moz-linear-gradient(center bottom, #cc3939 0, #dd7a7a 100%) !important;">
            <div class="box-header">
              <i class="fa fa-th"></i>

              <h3 class="box-title">Activity Network Graph</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn bg-teal btn-sm" data-widget="collapse" style="background-color: #dd2727 !important;"><i class="fa fa-minus"></i>
                </button> 
                <button type="button" class="btn bg-teal btn-sm" data-widget="remove" style="background-color: #dd2727 !important;"><i class="fa fa-times"></i>
                </button>
              </div>
            </div>
            <div class="box-body border-radius-none">
              <div class="chart" id="line-chart2" style="height: 250px;"></div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer no-border">
              <div class="row">
                <?php
                $count = $this->Crud->sql_query("SELECT * FROM `report` WHERE YEAR(`date`) = '" . date('Y') . "' AND MONTH(`date`) = '" . date('m') . "' AND `report`.`device_id`= 2")->num_rows();
                $graph = $this->Crud->query("SELECT `enum`.`name`, COUNT(`problem`) as `count` FROM `report` LEFT JOIN `enum` ON `report`.`problem` = `enum`.`id` WHERE YEAR(`date`) = '" . date('Y') . "' AND MONTH(`date`) = '" . date('m') . "' AND `report`.`device_id`= 2 GROUP BY `report`.`problem` ORDER BY `count` DESC LIMIT 0, 3");
                foreach ($graph as $value) {
                   echo '<div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                  <input type="text" class="knob" data-readonly="true" value="' . @number_format(($value['count']/$count)*100, 1) . '" data-width="60" data-height="60"
                         data-fgColor="#39CCCC">

                  <div class="knob-label">' . $value['name'] . '</div>
                </div>';
                }
                ?>
                <!-- ./col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->

          <!-- solid sales graph -->
          <div class="box box-solid bg-teal-gradient">
            <div class="box-header">
              <i class="fa fa-th"></i>

              <h3 class="box-title">Activity Jigsaw Graph</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn bg-teal btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn bg-teal btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                </button>
              </div>
            </div>
            <div class="box-body border-radius-none">
              <div class="chart" id="line-chart" style="height: 250px;"></div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer no-border">
              <div class="row">
                <?php
                $count = $this->Crud->sql_query("SELECT * FROM `report` WHERE YEAR(`date`) = '" . date('Y') . "' AND MONTH(`date`) = '" . date('m') . "' AND `report`.`device_id`= 1")->num_rows();
                $graph = $this->Crud->query("SELECT `enum`.`name`, COUNT(`problem`) as `count` FROM `report` LEFT JOIN `enum` ON `report`.`problem` = `enum`.`id` WHERE YEAR(`date`) = '" . date('Y') . "' AND MONTH(`date`) = '" . date('m') . "' AND `report`.`device_id`= 1 GROUP BY `report`.`problem` ORDER BY `count` DESC LIMIT 0, 3");
                foreach ($graph as $value) {
                   echo '<div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                  <input type="text" class="knob" data-readonly="true" value="' . @number_format(($value['count']/$count)*100, 1) . '" data-width="60" data-height="60"
                         data-fgColor="#39CCCC">

                  <div class="knob-label">' . $value['name'] . '</div>
                </div>';
                }
                ?>
                <!-- ./col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </section>
        <!-- right col -->


        <!-- Left col -->
        <section class="col-lg-12">
          <!-- Calendar -->
          <div class="box box-solid">
            <div class="box-header">
              <i class="fa fa-bullhorn"></i>
              <h3 class="box-title">Last Billing Jigsaw</h3>
            </div>
            <!-- /.box-body -->
            <div class="box-footer text-black">
              <table class="table table-striped">
                <thead class="table-header">
                  <tr>
                    <td style="width: 5px;">No.</td>
                    <td style="width: 80px;">Date</td>
                    <td style="width: 80px;">ID Unit</td>
                    <td style="width: 150px;">Type Unit</td>
                    <td style="width: 250px;">Problem</td>
                    <td style="width: 250px;">Activity</td>
                    <td style="">PIC</td>
                    <td style="width: 80px;">Status</td>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 0;
                  foreach ($last_jigsaw as $value):
                    $no++;
                    if ($value['status'] == 0) {
                      $status = 'RFU';
                    } else {
                      $status = 'Not RFU';
                    }
                  ?>
                  <tr>
                    <td><?php echo $no;?></td>
                    <td><?php echo $value['date'];?></td>
                    <td><?php echo $value['unit_id'];?></td>
                    <td><?php echo $value['type'];?></td>
                    <td><?php echo $value['problem'];?></td>
                    <td><?php echo $value['activity'];?></td>
                    <td><?php echo $value['pic'];?></td>
                    <td><?php echo $status;?></td>
                  </tr>
                <?php endforeach;?>
                </tbody>
              </table>
            </div>
          </div>
          <!-- /.box -->

        </section>
        <!-- /.Left col -->


        <!-- Left col -->
        <section class="col-lg-12">
          <!-- Calendar -->
          <div class="box box-solid">
            <div class="box-header">
              <i class="fa fa-bullhorn"></i>
              <h3 class="box-title">Last Billing Network</h3>
            </div>
            <!-- /.box-body -->
            <div class="box-footer text-black">
              <table class="table table-striped">
                <thead class="table-header">
                  <tr>
                    <td style="width: 5px;">No.</td>
                    <td style="width: 80px;">Date</td>
                    <td style="width: 80px;">ID Unit</td>
                    <td style="width: 150px;">Type Unit</td>
                    <td style="width: 250px;">Problem</td>
                    <td style="width: 250px;">Activity</td>
                    <td style="">PIC</td>
                    <td style="width: 80px;">Status</td>
                  </tr>
		</thead>
                <tbody>
                  <?php
                  $no = 0;
                  foreach ($last_network as $value):
                    $no++;
                    if ($value['status'] == 0) {
                      $status = 'RFU';
                    } else {
                      $status = 'Not RFU';
                    }
                  ?>
                  <tr>
                    <td><?php echo $no;?></td>
                    <td><?php echo $value['date'];?></td>
                    <td><?php echo $value['unit_id'];?></td>
                    <td><?php echo $value['type'];?></td>
                    <td><?php echo $value['problem'];?></td>
                    <td><?php echo $value['activity'];?></td>
                    <td><?php echo $value['pic'];?></td>
                    <td><?php echo $status;?></td>
                  </tr>
                <?php endforeach;?>
                </tbody>
              </table>
            </div>
          </div>
          <!-- /.box -->

        </section>
        <!-- /.Left col -->
      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php $this->load->view('templates/footer');?>
</div>
<!-- ./wrapper -->
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url('___/bower_components/jquery-ui/jquery-ui.min.js');?>"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Morris.js charts -->
<script src="<?php echo base_url('___/bower_components/raphael/raphael.min.js');?>"></script>
<script src="<?php echo base_url('___/bower_components/morris.js/morris.min.js');?>"></script>
<!-- Sparkline -->
<script src="<?php echo base_url('___/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js');?>"></script>
<!-- jvectormap -->
<script src="<?php echo base_url('___/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js');?>"></script>
<script src="<?php echo base_url('___/plugins/jvectormap/jquery-jvectormap-world-mill-en.js');?>"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url('___/bower_components/jquery-knob/dist/jquery.knob.min.js');?>"></script>
<!-- daterangepicker -->
<script src="<?php echo base_url('___/bower_components/moment/min/moment.min.js');?>"></script>
<script src="<?php echo base_url('___/bower_components/bootstrap-daterangepicker/daterangepicker.js');?>"></script>
<!-- datepicker -->
<script src="<?php echo base_url('___/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js');?>"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo base_url('___/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js');?>"></script>
<!-- Slimscroll -->
<script src="<?php echo base_url('___/bower_components/jquery-slimscroll/jquery.slimscroll.min.js');?>"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo base_url('___/dist/js/pages/dashboard.js');?>"></script>
<script src="<?php echo base_url('___/dist/js/loader.js');?>"></script>
<script src="<?php echo base_url('___/bower_components/chart.js/Chart.js');?>"></script>
<script type="text/javascript">
  var line = new Morris.Line({
    element          : 'line-chart',
    resize           : true,
    data             : [
    <?php 
    $data = $this->Crud->query("SELECT `date`, COUNT(`device_id`) as `count`, `device_id` FROM `report` WHERE `device_id` = 1 AND YEAR(`date`) = '" . date('Y') . "' AND MONTH(`date`) = '" . date('m') . "'  GROUP BY `date`");
    $val = '';
      foreach ($data as $value) {
        $val .= '{ y: \'' . $value['date'] . '\', jigsaw: ' . $value['count'] . ' },';
      }
      echo rtrim($val, ',')
      ?>
    ],
    xkey             : 'y',
    ykeys             : ['jigsaw'],
    labels            : ['Jigsaw'],
    lineColors       : ['#999', '#000000'],
    lineWidth        : 2,
    hideHover        : 'auto',
    gridTextColor    : '#fff',
    gridStrokeWidth  : 0.4,
    pointSize        : 4,
    pointStrokeColors: ['#efefef'],
    gridLineColor    : '#efefef',
    gridTextFamily   : 'Open Sans',
    gridTextSize     : 10
  });

  var line = new Morris.Line({
    element          : 'line-chart2',
    resize           : true,
    data             : [
    <?php 
    $data = $this->Crud->query("SELECT `date`, COUNT(`device_id`) as `count`, `device_id` FROM `report` WHERE `device_id` = 2 AND YEAR(`date`) = '" . date('Y') . "' AND MONTH(`date`) = '" . date('m') . "'  GROUP BY `date`");
    $val = '';
      foreach ($data as $value) {
        $val .= '{ y: \'' . $value['date'] . '\', network: ' . $value['count'] . ' },';
      }
      echo rtrim($val, ',')
      ?>
    ],
    xkey             : 'y',
    ykeys             : ['network'],
    labels            : ['Network'],
    lineColors       : ['#999', '#000000'],
    lineWidth        : 2,
    hideHover        : 'auto',
    gridTextColor    : '#fff',
    gridStrokeWidth  : 0.4,
    pointSize        : 4,
    pointStrokeColors: ['#efefef'],
    gridLineColor    : '#efefef',
    gridTextFamily   : 'Open Sans',
    gridTextSize     : 10
  });
  var donut = new Morris.Donut({
    element  : 'sales-chart',
    resize   : true,
    colors   : ['#3c8dbc', '#f56954', '#00a65a', '#f39c12', '#bc17d5'],
    data     : [
    <?php $query = $this->Crud->query("SELECT `enum`.`name`, COUNT(*) as count FROM `report` LEFT JOIN `enum` ON `report`.`analysis` = `enum`.`id` WHERE `report`.`device_id` = 1 GROUP BY `report`.`analysis` ORDER BY count DESC LIMIT 5");
    foreach ($query as $value) {
      echo '{ label: \'' . $value['name'] . '\', value: ' . $value['count'] . ' },';
    }
    ?>
    ],
    hideHover: 'auto'
  });
  var donut = new Morris.Donut({
    element  : 'network-chart',
    resize   : true,
    colors   : ['#3c8dbc', '#f56954', '#00a65a', '#f39c12', '#bc17d5'],
    data     : [
    <?php $query = $this->Crud->query("SELECT `enum`.`name`, COUNT(*) as count FROM `report` LEFT JOIN `enum` ON `report`.`analysis` = `enum`.`id` WHERE `report`.`device_id` = 2 GROUP BY `report`.`analysis` ORDER BY count DESC LIMIT 5");
    foreach ($query as $value) {
      echo '{ label: \'' . $value['name'] . '\', value: ' . $value['count'] . ' },';
    }
    ?>
    ],
    hideHover: 'auto'
  });

  $('.box ul.nav a').on('shown.bs.tab', function () {
    area.redraw();
    donut.redraw();
    line.redraw();
  });
  $('#calendar').datepicker();
</script>
<script type="text/javascript">
    //BAR CHART
    var bar = new Morris.Bar({
      element: 'chart_div',
      resize: true,
      data: [
      <?php
         foreach ($employee as $value) {
          echo "{y: '" .  ucfirst(strtolower($value['name'])) . "', a: {$value['jigsaw']}, b: {$value['network']}},";
         }

         ?>
      ],
      barColors: ['#3366cc', '#dc3912'],
      xkey: 'y',
      ykeys: ['a', 'b'],
      labels: ['Jigsaw', 'Network'],
      hideHover: 'auto'
    });
    </script>

<script>
  $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    //--------------
    //- AREA CHART -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
    var areaChartCanvas = $('#areaChart').get(0).getContext('2d')
    // This will get the first returned node in the jQuery collection.
    var areaChart       = new Chart(areaChartCanvas)

    var areaChartData = {
      <?php 
      $data = $this->Crud->query("SELECT `date`, SUM( IF( device_id = 1, count, 0) ) AS jigsaw, 
      SUM( IF( device_id = 2, count, 0) ) AS network
      FROM (
      SELECT `date`, COUNT(`device_id`) as `count`, `device_id` FROM `report` WHERE `device_id` = 1 GROUP BY YEAR(`date`), MONTH(`date`)
      UNION
      SELECT `date`, COUNT(`device_id`) as `count`, `device_id` FROM `report` WHERE `device_id` = 2 GROUP BY YEAR(`date`), MONTH(`date`)) tb
      WHERE YEAR(`date`) = '" . date('Y') . "'
      GROUP BY MONTH(`date`)");
      $val = '';
      $jig = '';
      $net = '';
      foreach ($data as $value) {
        $val .= "'" . date('F', strtotime($value['date'])) . "',";
        $jig .= $value['jigsaw'] . ",";
        $net .= $value['network'] . ",";
      }
      ?>
      labels  : [<?php echo rtrim($val, ',');?>],
      datasets: [
        {
          label               : 'Jigsaw',
          fillColor           : 'rgba(210, 214, 222, 1)',
          strokeColor         : 'rgba(210, 214, 222, 1)',
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [<?php echo rtrim($jig, ',');?>]
        },
        {
          label               : 'Network',
          fillColor           : 'rgba(60,141,188,0.9)',
          strokeColor         : 'rgba(60,141,188,0.8)',
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [<?php echo rtrim($net, ',');?>]
        }
      ]
    }

    var areaChartOptions = {
      //Boolean - If we should show the scale at all
      showScale               : true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines      : false,
      //String - Colour of the grid lines
      scaleGridLineColor      : 'rgba(0,0,0,.05)',
      //Number - Width of the grid lines
      scaleGridLineWidth      : 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines  : true,
      //Boolean - Whether the line is curved between points
      bezierCurve             : true,
      //Number - Tension of the bezier curve between points
      bezierCurveTension      : 0.3,
      //Boolean - Whether to show a dot for each point
      pointDot                : false,
      //Number - Radius of each point dot in pixels
      pointDotRadius          : 4,
      //Number - Pixel width of point dot stroke
      pointDotStrokeWidth     : 1,
      //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
      pointHitDetectionRadius : 20,
      //Boolean - Whether to show a stroke for datasets
      datasetStroke           : true,
      //Number - Pixel width of dataset stroke
      datasetStrokeWidth      : 2,
      //Boolean - Whether to fill the dataset with a color
      datasetFill             : true,
      //String - A legend template
      legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].lineColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
      //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio     : true,
      //Boolean - whether to make the chart responsive to window resizing
      responsive              : true
    }

    //Create the line chart
    areaChart.Line(areaChartData, areaChartOptions)
});
</script>
</body>
</html>
