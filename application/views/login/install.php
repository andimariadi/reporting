<body class="hold-transition login-page">
	<div class="login-box">
		<div class="login-logo">
			<a href="index2.html"><b>Reporting</b>MDI</a>
		</div>
		<!-- /.login-logo -->
		<div class="login-box-body">
			<?php
			if ($this->session->flashdata('msg') != '') {
				echo $this->session->flashdata('msg');
			}
			
?>

<form method="post" action="<?php echo base_url('Auth/install_action');?>">
	<div class="form-group has-feedback">
		<input type="text" class="form-control" placeholder="Username" name="username" autocomplete="off" />
		<span class="glyphicon glyphicon-fire form-control-feedback"></span>
	</div>
	<div class="form-group has-feedback">
		<input type="text" class="form-control" placeholder="Full name" name="name" autocomplete="off" />
		<span class="glyphicon glyphicon-user form-control-feedback"></span>
	</div>
	<div class="form-group has-feedback">
		<input type="password" class="form-control" placeholder="Password" name="password" autocomplete="off" />
		<span class="glyphicon glyphicon-lock form-control-feedback"></span>
	</div>
	<div class="form-group has-feedback" id="pass">
		<input type="password" class="form-control" placeholder="Re-Password" name="repassword" autocomplete="off" />
		<span class="glyphicon glyphicon-lock form-control-feedback"></span>
		<span class="help-block" style="display: none;"></span>
	</div>
	<div class="form-group has-feedback">
		<textarea class="form-control" name="description" placeholder="About Me"></textarea>
		<span class="glyphicon glyphicon-bookmark form-control-feedback"></span>
	</div>
	<div class="row">
		<div class="col-xs-4 col-xs-offset-8">
			<button type="submit" name="login" class="btn btn-primary btn-block btn-flat">Install Now</button>
		</div>
		<!-- /.col -->
	</div>
</form>
</div>
<!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="<?php echo base_url('___/bower_components/jquery/dist/jquery.min.js');?>"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url('___/bower_components/bootstrap/dist/js/bootstrap.min.js');?>"></script>
<!-- iCheck -->
<script src="<?php echo base_url('___/plugins/iCheck/icheck.min.js');?>"></script>
<script>
	$(function () {
		$('input').iCheck({
			checkboxClass: 'icheckbox_square-blue',
			radioClass: 'iradio_square-blue',
			increaseArea: '20%' /* optional */
		});
	});
</script>
<script type="text/javascript">
	$(document).on('keyup', '[name=repassword]', function() {
		var pass1 = $('[name=password]').val();
		var pass2 = $(this).val();
		if (pass1 != pass2) {
			$('#pass').addClass('has-error');
			$('#pass .help-block').css('display', 'block');
			$('#pass .help-block').html('Passwords do not match!');
		} else {
			$('#pass').removeClass('has-error');
			$('#pass .help-block').css('display', 'none');
			$('#pass .help-block').html('');
		}
	});
</script>
</body>
</html>
