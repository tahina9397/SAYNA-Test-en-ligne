<?php 
	$session = $this->session->userdata('logged_in');
	$pseudo = $session['username'] ;
?>	
	
<div id="top-nav" class="fixed skin-6">
	<a href="/" class="brand">
		<span>Bazar</span>
	</a><!-- /brand -->					
	<button type="button" class="navbar-toggle pull-left" id="sidebarToggle">
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	</button>
	<button type="button" class="navbar-toggle pull-left hide-menu" id="menuToggle">
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	</button>
	<ul class="nav-notification clearfix">
		<li class="profile dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">
				<strong><?php echo $pseudo ?></strong>
				<span><i class="fa fa-chevron-down"></i></span>
			</a>
			<ul class="dropdown-menu">
				<li>
					<a class="clearfix" href="#">
						<div class="detail">
							<strong onclick="window.location.href='<?php echo BASE_URL ?>/infos'">Mon profil</strong>
						</div>
					</a>
				</li>
				<?php /* ?>
				<li><a tabindex="-1" href="<?php echo BASE_URL ?>/informations-de-connexion" class="main-link"><i class="fa fa-edit fa-lg"></i>&nbsp;Modifier mon profil</a></li>
				<li><a tabindex="-1" href="gallery.html" class="main-link"><i class="fa fa-picture-o fa-lg"></i> Photo Gallery</a></li>
				<li><a tabindex="-1" href="#" class="theme-setting"><i class="fa fa-cog fa-lg"></i> Setting</a></li>
				<?php */ ?>
				<li class="divider"></li>
				<li>
					<?php
						/*$session = $this->session->userdata('logged_in');
						$role = $session['role'] ;
						if ($role == 'admin') { ?>
							<a class="main-link" href="<?php echo BASE_URL ?>/users">
								<i class="fa fa-user fa-lg"></i>&nbsp;Utilisateurs
							</a>
					<?php } */?>

					<a class="main-link" href="<?php echo BASE_URL ?>/logout">
						<i class="fa fa-lock fa-lg"></i>&nbsp;Déconnexion
					</a>
				</li>
			</ul>
		</li>
	</ul>
</div><!-- /top-nav-->