<div class="navbar-default navbar-static-side" role="navigation">
	<div class="sidebar-collapse">
		<ul class="nav" id="side-menu">
			
			<li>
				<a href="<?php echo site_url('dashboard') ?>"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
			</li>
			<?php 
			$user = $this->session->userdata('logged_in'); 
			if($user['type'] == 1 ){
			?>
			<li>
				<a href="#"><i class="fa fa-user"></i> Users<span class="fa arrow"></span></a>
				<ul class="nav nav-second-level">
					<li data-toggle="tooltip" data-placement="top" title="View all Users">
						<a href="<?php echo site_url('users/all') ?>">All Users</a>
					</li>
					<li>
						<a href="<?php echo site_url('users') ?>">Add User</a>
					</li>
				</ul>
				<!-- /.nav-second-level -->
			</li>
			<li>
				<a href="#"><i class="fa fa-code"></i> API Settings<span class="fa arrow"></span></a>
				<ul class="nav nav-second-level">
					<li>
						<a href="<?php echo site_url('api') ?>"><i class="fa fa-code"></i> APIs</a>
					</li>
					<li>
						<a href="<?php echo site_url('api/video') ?>"><i class="fa fa-film"></i> APIs Video Playlist</a>
					</li>
				</ul>
			</li>
			
			<?php } ?>
			<li><a href="<?php echo site_url('tag') ?>"><i class="fa fa-code"></i> Tags</a></li>
			<li>
				<a href="<?php echo site_url('payment') ?>"><i class="fa fa-money"></i> Payments</a>
				
			</li>
			<?php if ($user['can_upload'] == 1) { ?>
			<li><a href="<?php echo site_url('video') ?>"><i class="fa fa-film"></i> Videos</a></li>
			<?php } ?>
		</ul>
		<!-- /#side-menu -->
	</div>
	<!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->