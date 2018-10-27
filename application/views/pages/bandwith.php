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
        Bandwith
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
              <h3 class="box-title">Chart Bandwith</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-xs-6">
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Sort By Date :</label>
                      <div class="col-sm-4">
                        <select class="form-control" name="date">
                          <option value="7day">Last 7 days</option>
                          <option value="thismonth">This month</option>
                          <option value="lastmonth">Last month</option>
                          <option value="30day">Last 30 Days</option>
                        </select>
                      </div>
                    </div>
                </div>
              </div>
              <br />
              <div id="line_top_x">
              </div>
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
<script type="text/javascript">
      $.getScript("<?php echo base_url('Api/bandwith/7day');?>");
    var options = [];
    $( '.dropdown-menu a' ).on( 'click', function( event ) {
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
      $.getScript("<?php echo base_url('Api/bandwith');?>/" + date);
      return false;
    });

    $( '[name=date]' ).on( 'change', function( event ) {
      var date = $(this).val();
      var data = encodeURIComponent(options.join());
      if (data == '') {data = 1;}
      $.getScript("<?php echo base_url('Api/bandwith');?>/" + date);
    });
  </script>

</body>
</html>
