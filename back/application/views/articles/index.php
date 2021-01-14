<div id="main-container">
	<div id="breadcrumb">
		<ul class="breadcrumb">
			 <li><i class="fa fa-home"></i><a href="<?php echo BASE_URL ?>">&nbsp;Accueil</a></li>
			 <li class="active">Articles</li>	 
		</ul>
	</div>
	<div class="padding-md">
		<div class="panel panel-default table-responsive">
			<div class="panel-body">
				<div class="row">
					<div class="col-md-4 col-sm-4">
						<a class="btn btn-warning btn-md" onclick="showModal(this)" data-resource_type="addArticle">Ajouter une nouvelle article</a>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div>

			<hr class="mt-0 mb-0">

			<div class="padding-md clearfix">
				<table class="table table-striped" id="dataTable">
					<thead>
						<tr>
							<th>REF</th>
							<th>Nom</th>
							<th>Code barre</th>
							<th width="2%">Catégorie</th>
							<th>Taille</th>
							<th>Prix d'achat</th>
							<th width="2%">Pourcentage</th>
							<th>Prix de vente</th>
							<th>Nbre en stock</th>
							<th>Date de modification</th>
							<th width="25px">Action</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td colspan="11" class="text-center">
								Chargement des données...
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div><!-- /panel -->
	</div><!-- /.padding-md -->
</div><!-- /main-container -->

<div class="modal fade" id="CB_Modal">
	<div class="modal-dialog  modal-sm">
		<div class="modal-content">
		    <div class="modal-body">
		    	<input type="hidden" id="CB_cache">
		    	<input type="hidden" id="nom_article">
		    	<input type="hidden" id="aritcle_uniqid">
		    	<input type="hidden" id="article_taille">
		    	<input type="hidden" id="article_prix">
		    	<div id="img_result">
					<img id="img_CB_modal">
		    	</div>
				<button class="btn btn-info btn-block mt-10" id="print_CB_modal" onclick="print_CB_modal()"><i class="fa fa-print"></i>&nbsp;	Imprimer</button>
		    </div>
	  	</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
