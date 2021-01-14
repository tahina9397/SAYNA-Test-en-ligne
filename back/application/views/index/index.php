<?php 
	$session = $this->session->userdata('logged_in');
	$pseudo = $session['username'] ;
?>

<div id="main-container">
	<div id="breadcrumb">
		<ul class="breadcrumb">
			 <li><i class="fa fa-home"></i><a href="<?php echo BASE_URL ?>">&nbsp;Accueil</a></li>
		</ul>
	</div>

	<div class="padding-md">
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="panel panel-default">
					<div class="panel-body">
						<h2 class="text-center">Bienvenue <?php echo "<strong>".ucfirst($pseudo)."</strong>" ?></h2>
					</div>
				</div><!-- /panel -->
			</div><!-- /.col -->
		</div>
	</div>
</div>

