<?php 
	$article = $Global->selectRow('articles','nom_article','id_article='.$article_id) ;
?>

<div id="main-container">
	<div id="breadcrumb">
		<ul class="breadcrumb">
			 <li><i class="fa fa-home"></i><a href="<?php echo BASE_URL ?>">&nbsp;Accueil</a></li>
			 <li><a href="<?php echo BASE_URL?>/articles">Articles</a></li>
			 <li class="active"><?php echo $article->nom_article ?></li> 
		</ul>
	</div>
	<div class="padding-md">
		<div class="panel panel-default table-responsive">
			<div class="padding-md clearfix">
				<table class="table table-striped" id="dataTable" data-article_id="<?php echo $article_id ?>">
					<thead>
						<tr>
							<th>ID</th>
							<th>Action</th>
							<th>Quantité</th>
							<th>Facture</th>
							<th>Date création</th>
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
