<body class="hold-transition login-page">
	<div class="login-box" style="width: 720px;">
		<div class="login-logo">
			<a href="#"><b>Backlog</b> <?php echo $unit;?></a>
		</div>
		<!-- /.login-logo -->
		<div class="login-box-body">
			<?php
			if ($this->session->flashdata('msg') != '') {
				echo $this->session->flashdata('msg');
			}

			$data = $this->crud->query("SELECT * FROM (SELECT `backlog`.`id`, `unit_id`,`backlog`.`backlog`, (SELECT `value` FROM `backlog` as a where a.unit_id = `backlog`.`unit_id` AND a.backlog = `backlog`.`backlog` ORDER BY `id` DESC LIMIT 1) as `value`, `enum`.`name` as `backlog_name` FROM `backlog` LEFT JOIN `enum` ON `backlog`.`backlog` = `enum`.`id`) as A WHERE `unit_id` = '{$unit}' AND `value`= 0 GROUP BY `unit_id`, `backlog`");
			foreach ($data as $value) {
				?>
				<form method="post" id="records" style="margin-bottom: 10px;">
					<div class="row">
						<div class="col-xs-8"><input type="hidden" name="id" value="<?php echo $value['id'];?>" /><input type="hidden" name="backlog" value="<?php echo $value['backlog'];?>" /><input type="text" class="form-control" value="<?php echo $value['backlog_name'];?>" readonly /></div>
						<div class="col-xs-2"><select class="form-control" name="val"><option value="0">Open</option><option value="1">Close</option></select></div>
						<div class="col-xs-2"><i class="fa fa-save btn btn-xs btn-primary" style="cursor: pointer;" id="save_backlog_old"></i></div>
					</div>
				</form>
			<?php } ?>
			<div id="html_backlog"></div>
			<a href="#" class="btn btn-primary" id="add_backlog"><i class="fa fa-plus"></i> Add Backlog</a>
			<br />
			<br />
			<p class="existing-user text-center pt-4 mb-0"><a href="<?php echo base_url('Report/restart');?>" style="color: #888">Restart</a> || <a href="<?php echo base_url('Report/finish');?>" style="color: #888">Finish</a></p><br />
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
		$(document).on('click', '#save_backlog_old', function(e) {
			var data = $(this).parents('#records').serialize();
			$.ajax({
		        type: "POST",
		        data:data,
		        url: "<?php echo base_url('Report/update_backlog');?>",
		        success: function(response) {
		          location.reload();
		        },
		        error: function () {
		          console.log("errr");
		        }
		    });
		});

		$(document).on('click', '#save_backlog', function(e) {
			var data = $(this).parents('#records').serialize();
			$.ajax({
		        type: "POST",
		        data:data,
		        url: "<?php echo base_url('Report/save_backlog');?>",
		        success: function(response) {
		          location.reload();
		        },
		        error: function () {
		          console.log("errr");
		        }
		    });
		});

		$(document).on('click', '#add_backlog', function(e) {
			$('#html_backlog').append('<form method="post" id="records" style="margin-bottom: 10px;"> <div class="row"> <div class="col-xs-8"> <select class="form-control" name="backlog"> <?php foreach ($backlog as $value) {echo '<option value="' . $value['id'] . '">' . $value['name'] . ' (' . $value['alias'] . ')</option>'; } ?> </select> </div> <div class="col-xs-2"><select class="form-control" name="val"><option value="0">Open</option><option value="1">Close</option></select></div> <div class="col-xs-2"> <i class="fa fa-save btn btn-xs btn-primary" style="cursor: pointer;" id="save_backlog"></i> <i class="fa fa-trash btn btn-xs btn-danger" style="cursor: pointer;" id="delete_backlog"></i> </div> </div></form>');
		});

		$(document).on('click', '#delete_backlog', function(e) {
			$(this).parents('#records').fadeOut();
			$(this).parents('#records').remove();
		});
	</script>
</body>
</html>