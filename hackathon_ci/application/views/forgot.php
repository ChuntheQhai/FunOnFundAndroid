<?php $this->load->view('templates/head');?>

<body>
<?php $this->load->view('templates/header');?>

	<div class="container">
		<div class="row col-lg-6">
			<h2>Forgot Password</h2>
			<form id="forgot_form"  class="form-horizontal" action="" method="post">
				<div class="form-group">
					<label for="inputEmail" class="col-lg-2 control-label">Email Address</label>
					<div class="col-lg-10">
						<input type="text" class="form-control" id="inputEmail" placeholder="Email Address" value="">
					</div>
				</div>
				
				<button type="button" class="btn btn-success" id="submitBtn">Reset Password</button>
				
			</form>
			<div id="status"></div>
		</div>
    </div><!-- /.container -->
	
<?php $this->load->view('templates/footer');?>
<script src="<?php echo base_url(); ?>assets/js/sha256.js"></script>
<script>
	
	$("#submitBtn").click(function() {
		register();
	});
	
	function register() {
		
		var email = $("#inputEmail").val();
		
		if (email.length == 0) {
			$.jGrowl("Please enter email address", { header: "Missing Field" });
			return;
		}
		
		$.ajax({
		  type: "POST",
		  url: "<?php echo base_url('login/forgot_post'); ?>",
		  data: {email: email},
		  success: function(data) {
		  },
		  complete: function(e, xhr, settings) {
			var data = ($.parseJSON(e.responseText));
			if (e.status == 200) {
				if (data.success == 1) {
					$("#forgot_form").hide();
					$("#status").show().html('<div class="alert alert-success" role="alert">An email has been sent! Please check your inbox on how to reset your password.</div><a href="<?php echo base_url('login'); ?>" class="btn btn-primary">Back to Login</a>');
				}
			} else if (e.status == 400) {
				$.jGrowl(data.message, { header: data.error });
			}
		  },
		  dataType: 'json'
		});
	}
</script>

</body>
</html>