<div id="main-container">
	<div id="breadcrumb">
		<ul class="breadcrumb">
			 <li><i class="fa fa-home"></i><a href="<?php echo BASE_URL ?>">&nbsp;Accueil</a></li>
			 <li class="active">Utilisateurs</li>	 
		</ul>
	</div>
	<div class="padding-md">
		<div class="panel panel-default table-responsive">
			<div class="panel-body">
				<div class="row">
					<div class="col-md-4 col-sm-4">
						<a class="btn btn-success btn-md" onclick="showModal(this)" data-resource_type="addUser">Ajouter un nouvel utilisateur</a>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div>

			<hr class="mt-0 mb-0">

			<div class="padding-md clearfix">
				<table class="table table-striped" id="dataTable">
					<thead>
						<tr>
							<th>ID</th>
							<th>Nom d'utilisateur</th>
							<th>Email</th>
							<th>Role</th>
							<th>Date création</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td colspan="6" class="text-center">
								Chargement des données...
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div><!-- /panel -->
	</div><!-- /.padding-md -->
</div><!-- /main-container -->
