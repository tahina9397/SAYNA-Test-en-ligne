<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Articles extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'user_model' => 'Users'
			,'article_model' => 'Articles'
			,'categorie_model' => 'Categorie'
			,'global_model' => 'Global'
			,'historique_model' => 'Historique'
			,'taille_model' => 'Taille'
		)) ;
		
		if (!$this->Users->getData()) {
			redirect(BASE_URL."/login");
		}
		else{
			$role = $this->Users->getData()['role'] ;
		}
	}

	public function index()
	{	
		$tabHeadScript[] = THEMES_URL."js/jspdf.debug.js" ;
		$tabHeadScript[] = THEMES_URL."js/html2canvas.js" ;
		$tabHeadScript[] = THEMES_URL."js/scripts/articles/index.js" ;
		
		$this->layout->set('title', 'Articles');
		$this->layout->set('headLink', '');
		$this->layout->set('headScript',$tabHeadScript);
		$this->layout->load('default', 'contents' , 'articles/index');
	}

	public function getAllArticles()
	{
		$aColumns = 
			array(
				'a.uniqid'
				,'a.nom_article'
				,'a.codebarre_article'
				,'c.nom_categorie'
				,'t.nom_taille'
				,'a.prix_achat'
				,'a.pourcentage'
				,'a.prix_article'
				,'a.nbre_stock_article'
				,'a.date_article'
			);
		   		   		
		/* 
		 * Paging
		 */
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit = "LIMIT ".intval( $_GET['iDisplayStart'] ).", ". intval( $_GET['iDisplayLength'] );
		}
		
		/*
		 * Ordering
		 */
		$sOrder = "";
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ". ($_GET['sSortDir_0']==='asc' ? 'ASC' : 'DESC') .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}
		
		/* 
		 * Filtering
		 */
		$sWhere = "";
		if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= $aColumns[$i]." LIKE '%".$_GET['sSearch']."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		
		/* Individual column filtering */
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
			{
				if ( $sWhere == "" )
				{
					$sWhere = "WHERE ";
				}
				else
				{
					$sWhere .= " AND ";
				}
				$sWhere .= $aColumns[$i]." LIKE '%".$_GET['sSearch_'.$i]."%' ";
			}
		}

		$sQuery = "
			SELECT 
				SQL_CALC_FOUND_ROWS a.id_article
				,a.uniqid
				,a.id_categorie
				,a.nom_article
				,a.prix_article
				,a.prix_achat
				,a.pourcentage
				,a.nbre_stock_article
				,a.codebarre_article
				,c.nom_categorie
				,t.nom_taille
				,IF(a.date_article='0000-00-00 00:00:00' OR a.date_article IS NULL, '', DATE_FORMAT(a.date_article,'%d %b %Y %Hh %imn')) AS date_article
			FROM articles a
			LEFT JOIN categories c ON (a.id_categorie = c.id_categorie)
			LEFT JOIN taille t ON (a.id_taille = t.id_taille)
			$sWhere
			$sOrder
			$sLimit
		";

		$rResult        = $this->Global->query($sQuery);
		$total          = $this->Global->query("SELECT FOUND_ROWS() as FOUND_ROWS");
		$iFilteredTotal = $total[0]->FOUND_ROWS;
		$iTotal         = $total[0]->FOUND_ROWS;

		$output = array(
			"sEcho"                => intval($_GET['sEcho']),
			"iTotalRecords"        => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData"               => array()
		);

		if(!empty($rResult)){ 
		 	foreach ($rResult as $item) {
		 	 	$row = array();
		 	 	$id = $item->id_article ;

		 	 	$stockAlert = ($item->nbre_stock_article <= 5) ? "<span class='badge badge-danger pull-right'>!<span>" : "" ;

		 	 	$row[] = "<span>".$item->uniqid."&nbsp;".$stockAlert."</span>";
		 	 	$row[] = $item->nom_article;
		 	 	$row[] = "<span title='Imprimer' class='cpointer text-underline' onclick='ShowCB(this)' data-barcode='".$item->codebarre_article."' data-nom_article='".$item->nom_article."' data-uniqid='".$item->uniqid."' data-taille='".$item->nom_taille."' data-prix='".$item->prix_article."'>".$item->codebarre_article."</span>" ;
		 	 	$row[] = "<span class='text-warning'>".$item->nom_categorie."</span>";
		 	 	$row[] = "<span class='text-warning'>".$item->nom_taille."</span>";
		 	 	$row[] = number_format($item->prix_achat,0,',','.');
		 	 	$row[] = $item->pourcentage;
		 	 	$row[] = number_format($item->prix_article,0,',','.');
		 	 	$row[] = $item->nbre_stock_article;
		 	 	$row[] = $item->date_article;

				$actions = "<div class='btn-group'>" ;
				$actions .= 	"<button class='btn btn-default btn-sm dropdown-toggle' data-toggle='dropdown'>Action <span class='caret'></span></button>" ;
				$actions .= 	"<ul class='dropdown-menu'>" ;
				$actions .= 		"<li><a class='cpointer' onclick='showModal(this)' data-resource_type='addStock' data-resource_id='".$id."'>Ajouter stock</a></li>" ;
				$actions .= 		"<li><a class='cpointer' onclick='showModal(this)' data-resource_type='editArticle' data-resource_id='".$id."'>Modifier</a></li>" ;
				$actions .= 		"<li><a class='cpointer' onclick='deleteArticle(this)' data-resource_type='addArticle' data-resource_id='".$id."'>Supprimer</a></li>" ;
				$actions .= 		"<li><a href='".BASE_URL."/articles/historique/article_id/".$id."' target='_blank'>Historique</a></li>" ;
				$actions .= 	"</ul>" ;
				$actions .= "</div>" ;

		 	 	// $actions = "<span class='cpointer' title='Ajouter stock' onclick='showModal(this)' data-resource_type='addStock' data-resource_id='".$id."'><i class='fa fa-plus fa-lg'></i></span>" ;
		 	 	// $actions .= "<span class='ml-10 cpointer' title='Modifier' onclick='showModal(this)' data-resource_type='editArticle' data-resource_id='".$id."'><i class='fa fa-pencil fa-lg'></i></span>" ;
		 	 	// $actions .= "<span class='ml-10 cpointer' title='Supprimer' onclick='deleteArticle(this)' data-resource_type='addArticle' data-resource_id='".$id."'><i class='fa fa-trash-o fa-lg'></i></span>" ;
		 	 	// $actions .= "<span class='ml-10 cpointer' title='Historique'><a href='".BASE_URL."/articles/historique/article_id/".$id."'><i class='fa fa-bars fa-lg'></i></a></span>" ;
                    
		 	 	$row[] = $actions;

		 	 	$output['aaData'][] = $row;
		 	} 
		}
		
		echo json_encode($output);
	}

	public function showmodal()
	{
		$res = array() ;

		$resource_id = (int)$this->input->post('resource_id') ;
		$resource_type = $this->input->post('resource_type') ;

		$nom_article = $codebarre_article = $prix_article = $prix_achat = $pourcentage = $article_commentaire = "" ;
		$nbre_stock_article = 1 ;

		if($resource_type == 'editArticle' || $resource_type == 'addStock'){
			$get = $this->Articles->find($resource_id) ;
			$nom_article = $get->nom_article ;
			$codebarre_article = $get->codebarre_article ;
			$prix_article = $get->prix_article ;
			$prix_achat = $get->prix_achat ;
			$pourcentage = $get->pourcentage ;
			$nbre_stock_article = $get->nbre_stock_article ;
			$article_commentaire = $get->article_commentaire ;
		}

		$options = array(
		    'atfirst' => array(
		        'value'  => 1
		        ,'title' => "Au début"
		    )
		    ,'atend' => array(
		        'title' => "A la fin"   
		    )
		    ,'tablename' =>'articles'
		);

		$modal_title = ($resource_type == 'editArticle' || $resource_type == 'addStock') ? "Article : ".$nom_article : "Ajouter une nouvelle article" ;

		switch ($resource_type) {
			case 'editArticle':
					$action = 'edit' ;
				break;

			case 'addStock':
					$action = 'addStock' ;
				break;
			
			default:
					$action = 'add' ;
				break;
		}

		$hidden = ($resource_type == 'editArticle') ? "hidden" : "" ;

		$res['modal_title'] = $modal_title ;

		$getAllCategories = $this->Categorie->getAllCategories() ;
		$opt = $optSize = "" ;

		if (!empty($getAllCategories)) {
			foreach ($getAllCategories as $item) {
				$selectedCategorie = "" ;

				if($resource_type == 'editArticle'){
					$selectedCategorie = ($item->id_categorie == $get->id_categorie) ? " selected='selected' " : "" ;
				}
				
				$opt .= "<option value='".$item->id_categorie."' ".$selectedCategorie." >".$item->nom_categorie."</option>" ;
			}
		}

		$getAllSize = $this->Taille->getAllSize() ;

		if (!empty($getAllSize)) {
			$optSize .= "<option value='0'>Séléctionner une taille</option>" ;

			foreach ($getAllSize as $item) {
				$selectedSize = "" ;

				if($resource_type == 'editArticle'){
					$selectedSize = ($item->id_taille == $get->id_taille) ? " selected='selected' " : "" ;
				}
				
				$optSize .= "<option value='".$item->id_taille."' ".$selectedSize." >".$item->nom_taille."</option>" ;
			}
		}

		$htmlWrapper = "" ;

		if($resource_type == 'editArticle' || $resource_type == 'addStock'){
			$htmlWrapper .= "<input type='hidden' name='id_article' value='".$get->id_article."'>" ;
		}

		$htmlWrapper .= "<input type='hidden' name='action' value='".$action."'>" ;

		if($resource_type == 'addStock'){
			$htmlWrapper .= "<div class='form-group'>" ;
			$htmlWrapper .= 	"<label>Stock actuel</label>" ;
			$htmlWrapper .= 	"<input class='form-control' placeholder='Stock actuel' value='".$nbre_stock_article."' disabled>" ;
			$htmlWrapper .= "</div>" ;
			$htmlWrapper .= "<div class='form-group'>" ;
			$htmlWrapper .= 	"<label for='nbre_stock_article'>Quantité à ajouter</label>" ;
			$htmlWrapper .= 	"<input type='number' min='1' name='nbre_stock_article' id='nbre_stock_article' class='form-control' placeholder='1' value='1'>" ;
			$htmlWrapper .= "</div>" ;
		}
		else
		{
			$htmlWrapper .= "<div class='form-group'>" ;
			$htmlWrapper .= 	"<label for='nom_article'>Libellé</label>" ;
			$htmlWrapper .= 	"<input type='text' name='nom_article' id='nom_article' class='form-control' placeholder='Libellé' value='".$nom_article."'>" ;
			$htmlWrapper .= "</div>" ;

			$htmlWrapper .= "<div class='form-group'>" ;
			$htmlWrapper .= "<div class='input-group'>";
			$htmlWrapper .= 	"<input type='text' name='codebarre_article' id='codebarre_article' class='form-control' placeholder='Codebarre' value='".$codebarre_article."'>" ;
			$htmlWrapper .= 	"<span class='input-group-btn'>";
			$htmlWrapper .= 	"<button class='btn btn-default' type='button' onclick='generateCodeBarre(this)' data-resource_type='articles'>Générer code barre</button>";
			$htmlWrapper .= 	"</span>";
			$htmlWrapper .= "</div>";
			$htmlWrapper .= "</div>";
			

			$htmlWrapper .= "<div class='form-group row'>" ;
			$htmlWrapper .= 	"<div class='col-md-3'>" ;
			$htmlWrapper .= 		"<label for='prix_achat'>Prix d'achat de l'article</label>" ;
			$htmlWrapper .= 		'<input type="text" name="prix_achat" id="prix_achat" class="form-control" placeholder="Prix d\'achat" value='.$prix_achat.'>';
			$htmlWrapper .= 	"</div>" ;
			$htmlWrapper .= 	"<div class='col-md-3'>" ;
			$htmlWrapper .= 		"<label for='pourcentage'>Pourcentage</label>&nbsp;<span class='badge badge-danger alert_pourcentage hide'>!</span>" ;
			$htmlWrapper .= 		"<input type='text' name='pourcentage' id='pourcentage'  class='form-control' placeholder='Pourcentage' value='".$pourcentage."'>" ;
			$htmlWrapper .= 	"</div>" ;
			$htmlWrapper .= 	"<div class='col-md-3'>" ;
			$htmlWrapper .= 		"<label for='prix_article'>Prix unitaire</label>" ;
			$htmlWrapper .= 		"<input type='text' name='prix_article' id='prix_article'  class='form-control' placeholder='PU' value='".$prix_article."'>" ;
			$htmlWrapper .= 	"</div>" ;
			$htmlWrapper .= 	"<div class='col-md-3'>" ;
			$htmlWrapper .= 		"<label for='nbre_stock_article'>Nombre en stock</label>" ;
			$htmlWrapper .= 		"<input type='number' min='1' name='nbre_stock_article' id='nbre_stock_article'  class='form-control' placeholder='Quantité dans le stock' value='".$nbre_stock_article."'>" ;
			$htmlWrapper .= 	"</div>" ;
			$htmlWrapper .= "</div>" ;
			$htmlWrapper .= "<div class='form-group'>" ;
			$htmlWrapper .= 	"<label for='id_taille'>Taille</label>" ;
			$htmlWrapper .= 	"<select class='form-control' name='id_taille' id='id_taille'>" ;
			$htmlWrapper .= 		$optSize ;
			$htmlWrapper .= 	"</select>" ;
			$htmlWrapper .= "</div>" ;
			$htmlWrapper .= "<div class='form-group'>" ;
			$htmlWrapper .= 	"<label for='article_commentaire'>Descriptions</label>" ;
			$htmlWrapper .= 	"<textarea name='article_commentaire' id='article_commentaire' class='form-control'>".$article_commentaire."</textarea>" ;
			$htmlWrapper .= "</div>" ;
			$htmlWrapper .= "<div class='form-group'>" ;
			$htmlWrapper .= 	"<label for='id_categorie'>Catégorie</label>" ;
			$htmlWrapper .= 	"<select class='form-control' name='id_categorie' id='id_categorie'>" ;
			$htmlWrapper .= 		$opt ;
			$htmlWrapper .= 	"</select>" ;
			$htmlWrapper .= "</div>" ;
		}

        $res['htmlWrapper'] = $htmlWrapper ;

		echo json_encode($res) ;
	}

	public function modify()
	{
		$res = array() ;

		$action = $this->input->post('action') ;
		$id_article = (int)$this->input->post('id_article') ;
		$nom_article = $this->input->post('nom_article') ;
		$article_commentaire = $this->input->post('article_commentaire') ;
		$codebarre_article = $this->input->post('codebarre_article') ;
		$prix_article = $this->input->post('prix_article') ;
		$prix_achat = $this->input->post('prix_achat') ;
		$pourcentage = $this->input->post('pourcentage') ;
		$nbre_stock_article = $this->input->post('nbre_stock_article') ;
		$article_id_categorie = (int)$this->input->post('id_categorie') ;
		$article_id_taille = (int)$this->input->post('id_taille') ;

		if( (empty($nom_article) || empty($codebarre_article) || empty($prix_article) || empty($prix_achat) || empty($pourcentage)) && $action != 'addStock' ){
			$hidden_nom_article = (!empty($nom_article)) ? "hide" : "" ;
			$hidden_codebarre_article = (!empty($codebarre_article)) ? "hide" : "" ;
			$hidden_prix_article = (!empty($prix_article)) ? "hide" : "" ;
			$hidden_prix_achat = (!empty($prix_achat)) ? "hide" : "" ;
			$hidden_pourcentage = (!empty($pourcentage)) ? "hide" : "" ;

			$res['state'] = 'empty_condition' ;

			$msg = "<span>Un des ces champs est vide : </span>" ;
			$msg .= "<ul style='list-style-type: square;'>" ;
			$msg .= "<li class='".$hidden_nom_article."'><i class='fa fa-circle' style='font-size:5px'></i>&nbsp;Nom de l'article</li>" ;
			$msg .= "<li class='".$hidden_codebarre_article."'><i class='fa fa-circle' style='font-size:5px'></i>&nbsp;Code barre l'article</li>" ;
			$msg .= "<li class='".$hidden_prix_achat."'><i class='fa fa-circle' style='font-size:5px'></i>&nbsp;Le prix d'achat</li>" ;
			$msg .= "<li class='".$hidden_pourcentage."'><i class='fa fa-circle' style='font-size:5px'></i>&nbsp;Le pourcentage</li>" ;
			$msg .= "<li class='".$hidden_prix_article."'><i class='fa fa-circle' style='font-size:5px'></i>&nbsp;Le prix de vente</li>" ;
			$msg .= "</ul>" ;

			$res['msg'] = $msg ;
		}
		else{
			if( (strlen($codebarre_article) < 13) && $action != 'addStock'){
				$res['state'] = 'short_code_barre' ;
				$res['msg'] = 'Le code barre est de  13 chiffres maximum' ;
			}
			else{
				$notIn = ($action == 'edit') ? " AND id_article NOT IN ($id_article)" : "" ;

				$checkCB = $this->Global->Select('articles','id_article',"codebarre_article='$codebarre_article'".$notIn) ;

				if(!empty($checkCB)){
					$res['state'] = 'exist_codebarre' ;
					$res['msg'] = 'Code barre déja pris' ;
				}
				else{
					$data = array(
						'id_categorie' => $article_id_categorie
						,'id_taille' => ($article_id_taille != 0) ? $article_id_taille : NULL
						,'nom_article' => $nom_article
						,'codebarre_article' => $codebarre_article
						,'prix_article' => $prix_article
						,'prix_achat' => $prix_achat
						,'pourcentage' => $pourcentage
						,'nbre_stock_article' => $nbre_stock_article
						,'article_commentaire' => $article_commentaire
					);

					switch ($action) {
						case 'edit':
								$this->Articles->update($data,$id_article) ;
							break;

						case 'add':
								$this->Articles->insert($data) ;
							break;

						case 'addStock':
								$data_stock = array('nbre_stock_article' => $nbre_stock_article) ;
								$this->Articles->updateStock($data_stock,$id_article) ;
							break;
					}

					$res['state'] = 'success' ;
					$res['msg'] = 'Mise à jour avec succès' ;
				}
			}
		}

		echo json_encode($res) ;
	}

	public function delete()
	{
		$res = array() ;

		$id_article = (int)$this->input->post('resource_id') ;
		$this->Articles->delete($id_article) ;

		$res['msg'] = "Article supprimée avec succès" ;
		echo json_encode($res);
	}

	public function historique()
	{
		$article_id = (int)$this->uri->segment(4) ;
		$article = $this->Global->selectRow('articles','nom_article','id_article='.$article_id) ;

		$this->layout->set('title', $article->nom_article);
		$this->layout->set('headLink', '');
		$this->layout->set('headScript', array(THEMES_URL."js/scripts/articles/historique.js"));
		$this->layout->load('default', 'contents' , 'articles/historique',array("article_id"=>$article_id,"Global"=>$this->Global));
	}

	public function getHistorique()
	{
		$article_id  = (int)$this->uri->segment(4) ;
		
		$aColumns = 
			array(
				'h.id'
				,'h.type'
				,'h.quantite'
				,'f.facture_numero'
				,'h.create_time'
			);
		   		   		
		/* 
		 * Paging
		 */
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit = "LIMIT ".intval( $_GET['iDisplayStart'] ).", ". intval( $_GET['iDisplayLength'] );
		}
		
		/*
		 * Ordering
		 */
		$sOrder = "";
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ". ($_GET['sSortDir_0']==='asc' ? 'ASC' : 'DESC') .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}
		
		/* 
		 * Filtering
		 */
		$sWhere = "WHERE h.article_id = ".$article_id;

		if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
		{
			$sWhere .= " AND ( ";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= $aColumns[$i]." LIKE '%".$_GET['sSearch']."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		
		/* Individual column filtering */
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
			{
				if ( $sWhere == "" )
				{
					$sWhere = "WHERE ";
				}
				else
				{
					$sWhere .= " AND ";
				}
				$sWhere .= $aColumns[$i]." LIKE '%".$_GET['sSearch_'.$i]."%' ";
			}
		}

		// echo "<pre>";
		// print_r($sOrder) ;
		// echo "</pre>";
		// die() ;

		$sQuery = "
			SELECT 
				SQL_CALC_FOUND_ROWS h.id
				,h.quantite
				,h.type
				,f.id_facture
				,f.facture_numero
				,IF(h.create_time='0000-00-00 00:00:00' OR h.create_time IS NULL, '', DATE_FORMAT(h.create_time,'%d %b %Y %Hh %imn')) AS create_time
			FROM historique h
			LEFT JOIN factures f ON (f.id_facture = h.facture_id)
			$sWhere
			$sOrder
			$sLimit
		";

		$rResult        = $this->Global->query($sQuery);
		$total          = $this->Global->query("SELECT FOUND_ROWS() as FOUND_ROWS");
		$iFilteredTotal = $total[0]->FOUND_ROWS;
		$iTotal         = $total[0]->FOUND_ROWS;

		$output = array(
			"sEcho"                => intval($_GET['sEcho']),
			"iTotalRecords"        => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData"               => array()
		);

		if(!empty($rResult)){ 
		 	foreach ($rResult as $item) {
		 	 	$row = array();
		 	 	$id = $item->id ;

		 	 	$row[] = $id ;
		 	 	$row[] = "<span class='text-warning'>".strtoupper($item->type)."</span>";
		 	 	$row[] = $item->quantite;

		 	 	$row[] = ($item->type == 'vente') ? "<span class='cpointer text-success text-underline' title='Visualiser facture' onclick='showModalFacture(this)' data-resource_type='article' data-resource_id='".$item->id_facture."'>Ticket #".$item->facture_numero."</span>" : "" ;

		 	 	$row[] = $item->create_time;

		 	 	$output['aaData'][] = $row;
		 	} 
		}
		
		echo json_encode($output);
	}

	public function vente()
	{
		$pourcentage = $this->input->post('pourcentage') ;
		$prix_achat = $this->input->post('prix_achat') ;

		if(empty($prix_achat)){
			$res['state'] = 'empty_prix_achat' ;
			$res['msg'] = "Veuillez entrer le prix d'achat de l'article" ;
		}
		else{
			$benefice = ($prix_achat*$pourcentage) / 100 ;

			$prix_article = $benefice + $prix_achat ;

			$res['state'] = 'success' ;
			$res['prix_article'] = $prix_article ;
		}

		echo json_encode($res);
	}

	public function pourcentage()
	{
		$prix_article = $this->input->post('prix_article') ;
		$prix_achat = $this->input->post('prix_achat') ;

		if(empty($prix_achat)){
			$res['state'] = 'empty_prix_achat' ;
			$res['msg'] = "Veuillez entrer le prix d'achat de l'article" ;
		}
		else{
			$pourcentage = (100 * ($prix_article-$prix_achat) ) / $prix_achat ;

			if($pourcentage <= 0){
				$res['state'] = 'error_pourcentage' ;
			}
			else{
				$res['state'] = 'success' ;
				$res['pourcentage'] = $pourcentage ;
			}
		}

		echo json_encode($res);
		
	}

}
