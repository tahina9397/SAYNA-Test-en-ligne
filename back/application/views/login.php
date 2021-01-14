<div class="login-wrapper">
	<div class="text-center">
		<h2 class="fadeInUp animation-delay8" style="font-weight:bold">
			<span class="text-success">Bazar</span>
		</h2>
	</div>
	<div class="login-widget animation-delay1">	
		<div class="panel panel-default">
			<?php /* ?>
			<div class="panel-heading clearfix">
				<div class="pull-left">
					<i class="fa fa-lock fa-lg"></i> Se connecter
				</div>

				<div class="pull-right">
					<span style="font-size:11px;">Don't have any account?</span>
					<a class="btn btn-default btn-xs login-link" href="register.html" style="margin-top:-2px;"><i class="fa fa-plus-circle"></i> Sign up</a>
				</div>
			</div>
			<?php */ ?>

			<div class="panel-body">
				<form class="form-login" method="POST">
					<div class="form-group">
						<label for="pseudo">Pseudo</label>
						<input type="text" placeholder="Pseudo" class="form-control input-sm bounceIn animation-delay2" name="pseudo" id="pseudo" value="<?php echo $Utils->idx($_COOKIE,"pseudo_user","") ?>">
					</div>
					<div class="form-group">
						<label for="password">Mot de passe</label>
						<input type="password" placeholder="Mot de passe" class="form-control input-sm bounceIn animation-delay4" name="password" id="password" value="<?php echo $Utils->idx($_COOKIE,"password_user","") ?>">
					</div>
					<div class="form-group">
						<label for="rememberme" class="label-checkbox inline cpointer">
							<input type="checkbox" class="regular-checkbox chk-delete" name="rememberme" id="rememberme" value="1" <?php if($Utils->idx($_COOKIE, "rememberme_user", "") == 1) echo 'checked="checked"'; ?>/>
							<span class="custom-checkbox info bounceIn animation-delay4"></span>
							Se souvenir de moi	
						</label>
					</div>
					
					<?php /* ?>
					<div class="seperator"></div>
					<div class="form-group">
						<a href="">Mot de passe oublié?</a>
					</div>
					<?php */ ?>
					
					<hr/>
						
					<input type="submit" class="btn btn-success btn-sm bounceIn animation-delay5 login-link pull-right" value="Se connecter">
				</form>
			</div>
		</div><!-- /panel -->
	</div><!-- /login-widget -->
</div><!-- /login-wrapper -->