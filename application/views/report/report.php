<body class="hold-transition login-page">
	<div class="login-box">
		<div class="login-logo">
			<a href="index2.html"><b>Report</b>MDI</a>
		</div>
		<!-- /.login-logo -->
		<div class="login-box-body">
			<?php
			if (!$dev) {
				if (isset($submit)) {
					$value = $this->input->post('dev');
					$cookie = array(
						'name'   => 'dev',
						'value'  => $value,
						'expire' => $hour
					);
					$this->input->set_cookie($cookie);
					redirect(base_url('report'));
				}
								$data = $this->crud->view('device');
								foreach ($data as $value) {
									if ($value['id'] == 1) {
										$color = "btn-primary";
									} elseif($value['id'] == 2) {
										$color = "btn-success";
									} else {
										$color = "btn-warning";
									}
									?>
									<form method="post" action="">
										<div class="text-center">
											<input type="hidden" name="dev" value="<?php echo $value['id'];?>" />
											<button type="submit" name="submit" class="btn <?php echo $color;?> btn-block"><?php echo $value['name'];?></button>
										</div>
									</form>
									<br />
								<?php } ?>
			
			<?php } else {
				redirect(base_url('report/report'));
			} ?>
			<p class="existing-user text-center pt-4 mb-0"><a href="<?php echo base_url('Auth/logout');?>" style="color: #888">Log Out</a></p><br />
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
</body>
</html>