<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <div class="container">
	<div class="navbar-header">
	  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
		<span class="sr-only">Toggle navigation</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	  </button>
	  <a class="navbar-brand" href="#">Hackathon</a>
	</div>
	<div class="collapse navbar-collapse">
	  <ul class="nav navbar-nav">
		<?php if ($this->session->userdata('user_id') != "") { ?>
			<li><a href="<?php echo base_url('login/logout'); ?>">Logout</a></li>
		<?php } else { ?>
			<li><a href="<?php echo base_url('login'); ?>">Login</a></li>
		<?php } ?>
	  </ul>
	</div><!--/.nav-collapse -->
  </div>
</div>