<body class="hold-transition login-page">
	<div class="login-box">
		<div class="login-logo">
			<a href="#"><b>Reporting</b>MDI</a>
		</div>
		<!-- /.login-logo -->
		<div class="login-box-body">
			<?php
			if ($this->session->flashdata('msg') != '') {
				echo $this->session->flashdata('msg');
			}
			$quotes = array(
				'Hanya aku yang bisa mengubah hidupku. Tak satu orang pun mampu melakukannya untukku.',
				'Hanya ada satu kebahagiaan dalam kehidupan ini, mencintai atau dicintai.',
				'Kita harus merelakan hidup yang telah kita rencanakan, supaya bisa menerima apa yang menanti kita.',
				'Karunia terbesar dalam hidup adalah persahabatan, dan aku telah mendapatkannya.',
				'Hidup adalah 10% yang terjadi padamu, dan 90% bagaimana reaksi kamu terhadapnya.',
				'Tersenyumlah di depan cermin. Lakukanlah itu setiap pagi, dan kamu akan mulai melihat perubahan besar dalam hidupmu.',
				'Hidup itu bukan tentang apa yang kau temukan untuk dirimu. Hidup adalah bagaimana kau menciptakannya untuk dirimu.',
				'Kematian bukanlah kerugian terbesar dalam hidup. Kehilangan terbesar adalah apa yang mati dalam diri kita saat masih hidup.',
				'Karena senyumanmu, kau telah menjadikan hidup lebih indah.',
				'Berbahagialah dengan momen ini. Momen ini adalah kehidupanmu.',
				'Ada dua hari besar dalam kehidupan seseorang, pada hari kita dilahirakan dan pada hari kita menemukan alasannya.',
				'Misi saya dalam hidup bukan hanya untuk bertahan hidup saja, tapi juga berkembang; dan melakukannya dangan penuh gairah, sedikit belas kasih, sedikit humor, dan sedikit gaya.',
				'Hidup itu bukan sekedar bisa memegang kartu dengan baik, tapi juga memainkannya dengan baik.',
				'Jangan terlalu serius menjalani hidup. Bisa-bisa Anda tidak keluar dari sana hidup-hidup.',
				'Awan datang melayang ke dalam hidupku, tidak lagi membawa hujan atau badai, tapi menambah warna langit matahari terbenamku.',
				'Jalanilah hidup sepenuhnya, dan fokuslah pada hal-hal yang positif.',
				'Pekerjaan akan mengisi sebagian besar hidup Anda, dan satu-satunya cara untuk benar-benar puas adalah melakukan apa yang Anda yakini sebagai pekerjaan hebat. Satu-satunya cara untuk melakukannya adalah mencintai apa yang Anda lakukan. Jika Anda belum menemukannya, teruslah mencari. Jangan mudah puas. Seperti halnya semua yang ada di hati, Anda akan tahu kapan Anda menemukannya.',
				'Hidup yang baik adalah saat seseorang terinspirasi oleh cinta dan dibimbing oleh pengetahuan.',
				'Jangan tinggal di masa lalu, jangan memimpikan masa depan. Fokuskan pikiran pada masa kini.',
				'Petualangan terbesar yang bisa Anda ambil adalah menjalani kehidupan yang Anda impikan.',
				'Perdamaian adalah keindahan hidup, layaknya sinar mentari. Damai adalah senyum seorang anak, cinta seorang ibu, sukacita seorang ayah, kebersamaan sebuah keluarga. Ini adalah kemajuan umat manusia, masa kejayaan keadilan, dan kemenangan bagi kebenaran.',
				'Jagalah cinta di hatimu. Hidup tanpa itu seperti taman tanpa sinar ketika bunga-bunganya mati.',
				'Pendidikan bukanlah persiapan untuk hidup; pendidikan adalah kehidupan itu sendiri.',
				'Jika Anda mencintai kehidupan, jangan sia-siakan waktu. Jangka waktu adalah kehidupan yang terbentuk.',
				'Pilih pekerjaan yang Anda cintai, dan Anda tidak perlu lagi bekerja seharian dalam hidup Anda.',
				'Tujuan hidup manusia adalah untuk melayani, menunjukkan belas kasihan, dan kemauan untuk membantu orang lain.',
				'Hidup itu seperti roller coaster, hiduplah, bahagia, dan nikmati kehidupan.',
				'Ikatan yang menghubungkan keluarga sejati Anda bukanlah dengan darah, tapi rasa hormat dan sukacita dalam kehidupan masing-masing.',
				'Hidup itu seperti mengendarai sepeda. Untuk menjaga keseimbangan, Anda harus tetap bergerak (mengayuh).',
				'Perubahan adalah hukum kehidupan. Dan mereka yang hanya melihat masa lalu atau masa kini pasti akan kehilangan masa depan.',
				'Aku diberkati untuk memiliki begitu banyak hal hebat dalam hidup - keluarga, teman, dan Tuhan. Semua akan ada dalam pikiranku setiap hari.',
				'Tuhan telah memberi kita karunia hidup; terserah kita bagaimana memberi hadiah diri kita sebuah kehidupan yang baik.',
				'Tepat ketika saya berpikir telah belajar cara untuk hidup, kehidupan telah berubah.',
				'Santai, nikmati saja hidup, tersenyumlah lebih banyak, tertawa lebih banyak, dan jangan terlalu memikirkan banyak hal.',
				'Tujuan seni adalah mencuci debu kehidupan sehari-hari dari jiwa kita.',
				'Saya beruntung karena telah menemukan pasangan yang sempurna untuk menghabiskan hidupku bersama.',
				'Kesepian membuat hidup Anda lebih indah. Ia dapat membuat efek bakar spesial saat matahari terbenam, dan membuat bau udara malam lebih baik.',
				'Hidup ini seperti kolam renang. Anda bisa menyelam ke dalam air, tapi Anda tidak bisa melihat seberapa dalamnya.',
				'Alih-alih mencoba membuat hidup Anda sempurna, berilah diri Anda sendiri kebebasan untuk berpetualang, dan pergi ke atas.',
				'Burung ini mendapatkan dukungan dari kehidupannya sendiri dan motivasinya.'
			);
$sum = count($quotes)-1;
?>
<p class="login-box-msg"><?php echo $quotes[rand(0, $sum)];?></p>

<form method="post" action="<?php echo base_url('Auth/action');?>">
	<div class="form-group has-feedback">
		<input type="text" class="form-control" placeholder="Username" name="username" autocomplete="off" />
		<span class="glyphicon glyphicon-user form-control-feedback"></span>
	</div>
	<div class="form-group has-feedback">
		<input type="password" class="form-control" placeholder="Password" name="password" autocomplete="off" />
		<span class="glyphicon glyphicon-lock form-control-feedback"></span>
	</div>
	<div class="row">
		<div class="col-xs-4 col-xs-offset-8">
			<button type="submit" name="login" class="btn btn-primary btn-block btn-flat">Sign In</button>
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
</body>
</html>
