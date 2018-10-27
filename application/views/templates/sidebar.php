<?php
$username   = $this->session->userdata('username');
$name   = $this->session->userdata('name');
$level    = $this->session->userdata('level');
?>
<header class="main-header">
    <!-- Logo -->
    <a href="<?php echo base_url('Dash');?>" class="logo">
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
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo base_url('___/dist/img/avatar5.png');?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo ucfirst(strtolower(explode(' ', $name)[0]));?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo base_url('___/dist/img/avatar5.png');?>" class="img-circle" alt="User Image">

                <p>
                  <?php echo $name;?>
                  <small><?php echo ucfirst($level);?></small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?php echo base_url('Dash/profile');?>" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo base_url('Auth/logout');?>" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo base_url('___/dist/img/avatar5.png');?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Hi, <?php echo ucfirst(strtolower(explode(' ', $name)[0]));?></p>
          <a href="#" id="status_user"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li>
          <a href="<?php echo base_url('Dash');?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <li></li>
        <?php if ($level != 'report' && $level != 'man power'): ?>
        <li class="treeview<?php if($this->uri->segment(2) == 'category' || $this->uri->segment(2) == 'problem' || $this->uri->segment(2) == 'analysis' || $this->uri->segment(2) == 'remark' || $this->uri->segment(2) == 'cause' || $this->uri->segment(2) == 'action' || $this->uri->segment(2) == 'backlog' || $this->uri->segment(2) == 'other') { echo ' active';}?>">
          <a href="#">
            <i class="fa fa-laptop"></i>
            <span>Admin Elements</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li<?php if($this->uri->segment(2) == 'category') { echo' class="active"';} ?>><a href="<?php echo base_url('dash/category');?>"><i class="fa fa-circle-o"></i> Category Report</a></li>
            <li<?php if($this->uri->segment(2) == 'problem') { echo' class="active"';} ?>><a href="<?php echo base_url('dash/problem');?>"><i class="fa fa-circle-o"></i> Problem</a></li>
            <li<?php if($this->uri->segment(2) == 'analysis') { echo' class="active"';} ?>><a href="<?php echo base_url('dash/analysis');?>"><i class="fa fa-circle-o"></i> Analysis</a></li>
            <li<?php if($this->uri->segment(2) == 'cause') { echo' class="active"';} ?>><a href="<?php echo base_url('dash/cause');?>"><i class="fa fa-circle-o"></i> Cause By</a></li>
            <li<?php if($this->uri->segment(2) == 'action') { echo' class="active"';} ?>><a href="<?php echo base_url('dash/action');?>"><i class="fa fa-circle-o"></i> Action</a></li>
            <li<?php if($this->uri->segment(2) == 'remark') { echo' class="active"';} ?>><a href="<?php echo base_url('dash/remark');?>"><i class="fa fa-circle-o"></i> Remark</a></li>
            <li<?php if($this->uri->segment(2) == 'backlog') { echo' class="active"';} ?>><a href="<?php echo base_url('dash/backlog');?>"><i class="fa fa-circle-o"></i> Backlog</a></li>
            <li<?php if($this->uri->segment(2) == 'other') { echo' class="active"';} ?>><a href="<?php echo base_url('dash/other');?>"><i class="fa fa-circle-o"></i> Other Element</a></li>
          </ul>
        </li>
        <?php endif;?>
        <?php if ($level != 'report' && $level != 'man power'): ?>
        <li class="treeview<?php if($this->uri->segment(2) == 'relations' || $this->uri->segment(2) == 'device' || $this->uri->segment(2) == 'people' || $this->uri->segment(2) == 'level' || $this->uri->segment(2) == 'periodic') { echo ' active';}?>">
          <a href="#">
            <i class="fa fa-gear"></i>
            <span>Admin Control</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li<?php if($this->uri->segment(2) == 'relations') { echo' class="active"';} ?>><a href="<?php echo base_url('dash/relations');?>"><i class="fa fa-circle-o"></i> Relations</a></li>
            <li<?php if($this->uri->segment(2) == 'device') { echo' class="active"';} ?>> <a href="<?php echo base_url('dash/device');?>"> <i class="fa fa-circle-o"></i> <span>Device</span> </a></li>
            <li<?php if($this->uri->segment(2) == 'periodic') { echo' class="active"';} ?>><a href="<?php echo base_url('dash/periodic');?>"><i class="fa fa-circle-o"></i> Time Periodic</a></li>
            <?php if ($level == 'supervisor'): ?>
            <li<?php if($this->uri->segment(2) == 'people') { echo' class="active"';} ?>><a href="<?php echo base_url('dash/people');?>"><i class="fa fa-circle-o"></i> People</a></li>
            <li<?php if($this->uri->segment(2) == 'level') { echo' class="active"';} ?>><a href="<?php echo base_url('dash/level');?>"><i class="fa fa-circle-o"></i> Level User</a></li>
            <?php endif;?>
          </ul>
        </li>
        <?php endif;?>
        <?php if ($level != 'man power'): ?>
        <li class="treeview<?php if($this->uri->segment(2) == 'unit') { echo ' active';}?>">
          <a href="#">
            <i class="fa fa-th"></i>
            <span>Population</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li<?php if($this->uri->segment(2) == 'unit' && $this->uri->segment(3) == 'jigsaw') { echo' class="active"';} ?>><a href="<?php echo base_url('dash/unit/jigsaw');?>"><i class="fa fa-circle-o"></i> Unit Jigsaw</a></li>
            <li<?php if($this->uri->segment(2) == 'unit' && $this->uri->segment(3) == 'network') { echo' class="active"';} ?>><a href="<?php echo base_url('dash/unit/network');?>"><i class="fa fa-circle-o"></i> Unit Network</a></li>
          </ul>
        </li>
        <?php endif;?>
        <li class="treeview<?php if($this->uri->segment(2) == 'report' || $this->uri->segment(2) == 'report_advanced' || $this->uri->segment(2) == 'report_summary' || $this->uri->segment(2) == 'battery' || $this->uri->segment(2) == 'r_backlog') { echo ' active';}?>">
          <a href="#">
            <i class="fa fa-pie-chart"></i> <span>Report</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="treeview<?php if($this->uri->segment(2) == 'r_backlog') { echo ' active';}?>">
              <a href="#">
                <i class="fa fa-circle-o"></i> Backlog
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li<?php if($this->uri->segment(2) == 'r_backlog' && $this->uri->segment(3) == 'jigsaw') { echo' class="active"';} ?>>
                  <a href="<?php echo base_url('dash/r_backlog/jigsaw');?>"><i class="fa fa-circle-o"></i> Jigsaw</a>
                </li>
                <li<?php if($this->uri->segment(2) == 'r_backlog' && $this->uri->segment(3) == 'network') { echo' class="active"';} ?>>
                  <a href="<?php echo base_url('dash/r_backlog/network');?>"><i class="fa fa-circle-o"></i> Network</a>
                </li>
              </ul>
            </li>
            <li<?php if($this->uri->segment(2) == 'battery') { echo' class="active"';} ?>><a href="<?php echo base_url('dash/battery');?>"><i class="fa fa-circle-o"></i> Battery</a></li>
            <li<?php if(($this->uri->segment(2) == 'report' || $this->uri->segment(2) == 'report_advanced' || $this->uri->segment(2) == 'report_summary') && $this->uri->segment(3) == 'jigsaw') { echo' class="active"';} ?>><a href="<?php echo base_url('dash/report/jigsaw');?>"><i class="fa fa-circle-o"></i> Jigsaw</a></li>
            <li<?php if(($this->uri->segment(2) == 'report' || $this->uri->segment(2) == 'report_advanced' || $this->uri->segment(2) == 'report_summary') && $this->uri->segment(3) == 'network') { echo' class="active"';} ?>><a href="<?php echo base_url('dash/report/network');?>"><i class="fa fa-circle-o"></i> Network</a></li>
            <li<?php if(($this->uri->segment(2) == 'report' || $this->uri->segment(2) == 'report_advanced' || $this->uri->segment(2) == 'report_summary') && $this->uri->segment(3) == 'other') { echo' class="active"';} ?>><a href="<?php echo base_url('dash/report/other');?>"><i class="fa fa-circle-o"></i> Other Activity</a></li>
          </ul>
        </li>
        <li class="treeview<?php if($this->uri->segment(2) == 'pm') { echo ' active';}?>">
          <a href="#">
            <i class="fa fa-sitemap"></i> <span>Summary</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="treeview">
              <a href="#">
                <i class="fa fa-circle-o"></i> Backlog
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li<?php if($this->uri->segment(2) == 'pm' && $this->uri->segment(3) == 'jigsaw') { echo' class="active"';} ?>><a href="<?php echo base_url('dash/pm/jigsaw');?>"><i class="fa fa-circle-o"></i> Jigsaw</a></li>
                <li<?php if($this->uri->segment(2) == 'pm' && $this->uri->segment(3) == 'network') { echo' class="active"';} ?>><a href="<?php echo base_url('dash/pm/network');?>"><i class="fa fa-circle-o"></i> Network</a></li>
              </ul>
            </li>
            <li class="treeview<?php if($this->uri->segment(2) == 'pm') { echo ' active';}?>">
              <a href="#">
                <i class="fa fa-circle-o"></i> Preventive Maintenance
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li<?php if($this->uri->segment(2) == 'pm' && $this->uri->segment(3) == 'jigsaw') { echo' class="active"';} ?>><a href="<?php echo base_url('dash/pm/jigsaw');?>"><i class="fa fa-circle-o"></i> Jigsaw</a></li>
                <li<?php if($this->uri->segment(2) == 'pm' && $this->uri->segment(3) == 'network') { echo' class="active"';} ?>><a href="<?php echo base_url('dash/pm/network');?>"><i class="fa fa-circle-o"></i> Network</a></li>
              </ul>
            </li>
          </ul>
        </li>
        <li class="treeview<?php if($this->uri->segment(2) == 'chart' || $this->uri->segment(2) == 'bandwith') { echo ' active';}?>">
          <a href="#">
            <i class="fa fa-line-chart"></i>
            <span>Charts</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li<?php if($this->uri->segment(2) == 'chart' && $this->uri->segment(3) == 'jigsaw') { echo' class="active"';} ?>><a href="<?php echo base_url('dash/chart/jigsaw');?>"><i class="fa fa-circle-o"></i> Jigsaw</a></li>
            <li<?php if($this->uri->segment(2) == 'chart' && $this->uri->segment(3) == 'network') { echo' class="active"';} ?>><a href="<?php echo base_url('dash/chart/network');?>"><i class="fa fa-circle-o"></i> Network</a></li>
            <li<?php if($this->uri->segment(2) == 'bandwith') { echo' class="active"';} ?>><a href="<?php echo base_url('dash/bandwith');?>"><i class="fa fa-circle-o"></i> Bandwith</a></li>
          </ul>
        </li>
        <li class="header">Settings</li>
        <li><a href="<?php echo base_url('Dash/profile');?>"><i class="fa fa-user"></i> <span>Profile</span></a></li>
        <li><a href="<?php echo base_url('Auth/logout');?>"><i class="fa fa-sign-out"></i> <span>Logout</span></a></li>
	<li class="header">Support Maintenance</li>
        <li><a href="http://192.168.211.10/nagios3"><i class="fa fa-forumbee"></i> <span>Nagios</span></a></li>
        <li><a href="http://192.168.211.20/cacti"><i class="fa fa-contao"></i> <span>Cacti</span></a></li>
	<li><a href="http://192.168.211.20/phpipam"><i class="fa fa-pinterest-p"></i> <span>IP Management</span></a></li>

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>