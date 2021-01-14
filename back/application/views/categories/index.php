<div id="main-container">
	<div id="breadcrumb">
		<ul class="breadcrumb">
			 <li><i class="fa fa-home"></i><a href="<?php echo BASE_URL ?>">&nbsp;Accueil</a></li>
			 <li class="active">Catégories</li>	 
		</ul>
	</div>
	<div class="padding-md">
		<div class="panel panel-default table-responsive">
			<div class="panel-body">
				<div class="row">
					<div class="col-md-4 col-sm-4">
						<a class="btn btn-info btn-md" onclick="showModal(this)" data-resource_type="addCategorie">Ajouter une nouvelle catégorie</a>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div>

			<hr class="mt-0 mb-0">

			<div class="padding-md clearfix">
				<table class="table table-striped" id="dataTable">
					<thead>
						<tr>
							<th>Nom</th>
							<th>Ref</th>
							<th>Déscriptions</th>
							<th>Date création</th>
							<th width="25px">Action</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td colspan="5" class="text-center">
								Chargement des données...
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div><!-- /panel -->
	</div><!-- /.padding-md -->
</div><!-- /main-container -->
