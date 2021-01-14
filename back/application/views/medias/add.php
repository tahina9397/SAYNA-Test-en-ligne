<div id="main-container">
	<div id="breadcrumb">
		<ul class="breadcrumb">
			 <li><i class="fa fa-home"></i><a href="<?php echo BASE_URL ?>">&nbsp;Accueil</a></li>
			 <li class="active">Ajout d'un nouveau média</li>	 
		</ul>
	</div>
	<div class="padding-md">

		<div class="panel panel-default">
			<div class="panel-heading">
				Outils de téléchargement d'image
			</div>
			<div class="panel-body">
				<fieldset class="form-horizontal form-border">
					<div class="form-group">
						<div class="col-md-12">
							<form action="<?php echo BASE_URL ?>/medias/multipleupload" class="dropzone">
								  <div class="fallback">
									<input name="file" type="file" multiple />
								  </div>
							</form>
						</div><!-- /.col -->
					</div><!-- /form-group -->
				</fieldset>			
			</div>
		</div><!-- /panel -->
	</div>
</div>

