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
        Battery
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
              <h3 class="box-title">Result Battery Data </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <?php if ($year == '' && $month == ''): ?>
                <ul class="sidebar-menu" data-widget="tree" id="year_list"></ul> 
                <?php else: ?>

                  <!-- nganu -->
                  <div  style="overflow: auto">
                    <table class="table table-striped">
                      <thead class="table-header">
                        <tr>
                          <th rowspan="3" style="vertical-align: middle;">No.</th>
                          <th rowspan="3" style="vertical-align: middle;">Name Unit</th>
                          <th colspan="<?php echo (date('t', strtotime($year.'-'.$month.'-1'))*2);?>" style="text-align: center;"><?php echo date('F', strtotime($year.'-'.$month.'-1'));?></th>
                        </tr>
                        <tr>
                          <?php
                          for ($i=1; $i <= date('t', strtotime($year.'-'.$month.'-1')); $i++) { 
                            echo '<th colspan="2" style="text-align: center;">' . $i . '</th>';
                          }
                          ?>
                        </tr>
                        <tr>
                          <?php
                          for ($i=1; $i <= date('t', strtotime($year.'-'.$month.'-1')); $i++) { 
                            echo '<th>06</th>';
                            echo '<th>18</th>';
                          }
                          ?>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $no = 0;
                        foreach ($query as $data) {
                          $no++;
                          echo '<tr>';
                          echo '<th>' . $no . '</th> <th nowrap>' . $data['unit_id'] . '</th>';
                          for ($i=1; $i <= date('t', strtotime($year.'-'.$month.'-1')); $i++) { 
                            for ($a=1; $a <= 2; $a++) { 
                              if ($data[$i.'_'.$a] >= 20) {
                                echo '<td style="background-color: rgb(0, 166, 90, 0.2);">' . number_format($data[$i.'_'.$a], 2) . '</td>';
                              } elseif ($data[$i.'_'.$a] >= 12 && $data[$i.'_'.$a] < 20) {
                                echo '<td style="background-color: rgb(243, 156, 18, 0.2)">' . number_format($data[$i.'_'.$a], 2) . '</td>';
                              } elseif ($data[$i.'_'.$a] >= 1 && $data[$i.'_'.$a] < 12) {
                                echo '<td style="background-color: rgb(221, 75, 57, 0.1)">' . number_format($data[$i.'_'.$a], 2) . '</td>';
                              } else {
                                echo '<td>' . number_format($data[$i.'_'.$a], 2) . '</td>';
                              }
                            }
                          }
                          echo '</tr>';
                        }
                        ?>
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
  <script type="text/javascript">
    const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"]; 
    var vPool = ''; 
    $.getJSON('<?php echo base_url('Api/date_battery');?>', function(jd) {
      $.each(jd.data, function(i, val){
        vPool += '<li class="treeview">' + 
        '<a href="#" id="get_date" data-date="' + this['date'] + '">' + 
        '<i class="fa fa-calendar-minus-o"></i> <span>' + this['date'] + 
        '</span>' + 
        '<span class="pull-right-container">' + 
        '<i class="fa fa-angle-left pull-right"></i>' + 
        '</span>' + 
        '</a>' + 
        '<ul class="treeview-menu" id="list_date_' + this['date'] + '">' + 
        '</ul>' + 
        '</li>'; 
      }); 
      $('#year_list').html(vPool); 
    });
    $(document).on('click', '#get_date', function(e) {var date = $(this).attr('data-date'); var vPool=""; $.getJSON('<?php echo base_url('Api/date_battery');?>/' + date, function(jd) {$.each(jd.data, function(i, val){vPool += '<li>'+ '<a href="battery/' + date + '/' + this['date'] + '"><i class="fa fa-angle-right"></i> ' + monthNames[this['date']-1] + '</a>'+ '</li>'; }); $('#list_date_' + date).html(vPool); }); }); 
  </script>
</body>
</html>
