<div id="sidebar-left" class="enable-hover">
	<div class="sidebar-content">
		<form action="page_ready_search_results.html" method="post" class="sidebar-search">
			<input type="text" id="sidebar-search-term" name="sidebar-search-term" placeholder="Search..">
		</form>
		<div class="sidebar-left-scroll">
			<ul class="sidebar-nav">
				<li>
					<h2 class="sidebar-header">Welcome</h2>
				</li>
				<li>
					<a href="<?php echo base_url(); ?>accounting"><i class="icon-desktop"></i>Dashboard</a>
				</li>
			</ul>
		</div>
	</div>
</div>
<div id="sidebar-right">
	<div class="sidebar-content">
		<div class="user-info">
			<div class="user-details"><a href="profile.html">Sidogiri</a><br><em>Operator</em></div>
			<img src="<?php echo base_url(); ?>public/img/template/avatar.png" alt="Avatar">
		</div>
		<div class="sidebar-right-scroll">
			<ul class="sidebar-nav">
				<li>
					<h2 class="sidebar-header">Explore</h2>
				</li>
				<li>
					<a href="notification.html"><i class="icon-time"></i> Updates</a>
				</li>
				<li>
					<a href="profile.html"><i class="icon-edit-sign"></i> Profile</a>
				</li>
				<li>
					<a href="message.html"><i class="icon-envelope-alt"></i> Messages</a>
				</li>
				<li>
					<a href="index.html"><i class="icon-off"></i> Logout</a>
				</li>
			</ul>
			<div class="sidebar-section">
				<h2 class="sidebar-header">Notifications</h2>
				<div class="alert alert-success alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<small><em>2 hours ago</em></small><br>
					Product updated successfully on <a href="javascript:void(0)">Server #5</a>
				</div>
				<div class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<small><em>3 hours ago</em></small><br>
					<a href="javascript:void(0)">Server</a> crashed but restored!
				</div>
				<div class="alert alert-warning alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<small><em>5 hours ago</em></small><br>
					<a href="javascript:void(0)">Sync Failed</a> Please check your internet connection!
				</div>
			</div>
			<div class="sidebar-section">
				<h2 class="sidebar-header">Messages</h2>
				<div class="alert alert-info">
					<small><a href="page_special_user_profile.html">Claire</a>, 2 minutes ago</small><br>
					Silahkan lakukan stock opname. <a href="message.html">more</a>
				</div>
				<div class="alert alert-info">
					<small><a href="page_special_user_profile.html">Michael</a>, 5 minutes ago</small><br>
					Harap lakukan sinkron manual, dikarenakan workstation anda mengalami gangguan. <a href="message.html">more</a>
				</div>
			</div>
		</div>
	</div>
</div>