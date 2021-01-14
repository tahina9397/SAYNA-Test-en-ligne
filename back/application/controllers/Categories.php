<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'user_model' => 'Users'
			,'categorie_model' => 'Categories'
			,'global_model' => 'Global'
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
		// $data = array() ;
		// $data['js_to_load']= THEMES_URL."js/scripts/categories/index.js" ;
		
		$this->layout->set('title', 'Catégories');
		$this->layout->set('headLink', '');
		$this->layout->set('headScript', array(THEMES_URL."js/scripts/categories/index.js"));
		$this->layout->load('default', 'contents' , 'categories/index');
	}

	public function getAllCategories()
	{

		// echo "<pre>" ;
		// print_r($_GET);
		// echo "</pre>" ;
		// die() ;

		$aColumns = 
			array(
				'c.nom_categorie'
				,'c.uniqid'
				,'c.commentaire_categorie'
				,'c.date_categorie'
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
				SQL_CALC_FOUND_ROWS c.id_categorie
				,c.uniqid
				,c.nom_categorie
				,c.commentaire_categorie
				,IF(c.date_categorie='0000-00-00 00:00:00' OR c.date_categorie IS NULL, '', DATE_FORMAT(c.date_categorie,'%d %b %Y %Hh %imn')) AS date_categorie
			FROM categories c
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
		 	 	$id = $item->id_categorie ;

		 	 	$row[] = $item->nom_categorie;
		 	 	$row[] = $item->uniqid ;
		 	 	$row[] = $item->commentaire_categorie;
		 	 	$row[] = $item->date_categorie;

		 	 	$actions = "<span class='cpointer' title='Modifier' onclick='showModal(this)' data-resource_type='editCategorie' data-resource_id='".$id."'><i class='fa fa-pencil fa-lg'></i></span>" ;
		 	 	$actions .= "<span class='ml-10 cpointer' title='Supprimer' onclick='deleteCategorie(this)' data-resource_type='addCategorie' data-resource_id='".$id."'><i class='fa fa-trash-o fa-lg'></i></span>" ;
                    
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

		$nom_categorie = $commentaire_categorie = "" ;

		if($resource_type == 'editCategorie'){
			$get = $this->Categories->find($resource_id) ;
			$nom_categorie = $get->nom_categorie ;
			$commentaire_categorie = $get->commentaire_categorie ;
		}
		

		$options = array(
		    'atfirst' => array(
		        'value'  => 1
		        ,'title' => "Au début"
		    )
		    ,'atend' => array(
		        'title' => "A la fin"   
		    )
		    ,'tablename' =>'categories'
		);

		$modal_title = ($resource_type == 'editCategorie') ? "Catégorie : ".$nom_categorie : "Ajouter une nouvelle catégorie" ;
		$action = ($resource_type == 'editCategorie') ? "edit" : "add" ;

		$res['modal_title'] =  $modal_title ;

		$htmlWrapper = "" ;

		if($resource_type == 'editCategorie'){
			$htmlWrapper .= "<input type='hidden' name='id_categorie' value='".$get->id_categorie."'>" ;
			$htmlWrapper .= "<input type='hidden' name='old_ordre_categorie' value='".$get->ordre_categorie."'>" ;
		}

		$htmlWrapper .= "<input type='hidden' name='action' value='".$action."'>" ;
		$htmlWrapper .= "<div class='form-group'>" ;
		$htmlWrapper .= 	"<label for='nom_categorie'>Libellé</label>" ;
		$htmlWrapper .= 	"<input type='text' name='nom_categorie' id='nom_categorie' class='form-control input-sm' placeholder='' value='".$nom_categorie."'>" ;
		$htmlWrapper .= "</div>" ;
		$htmlWrapper .= "<div class='form-group'>" ;
		$htmlWrapper .= 	"<label for='commentaire_categorie'>Descriptions</label>" ;
		$htmlWrapper .= 	"<textarea name='commentaire_categorie' id='commentaire_categorie' class='form-control input-sm' placeholder=''>".$commentaire_categorie."</textarea>" ;
		$htmlWrapper .= "</div>" ;
		$htmlWrapper .= "<div class='form-group'>" ;
		$htmlWrapper .= 	"<label for='ordre_categorie'>Ordre</label>" ;
		$htmlWrapper .= 	"<select class='form-control' name='ordre_categorie' id='ordre_categorie'>" ;
		$htmlWrapper .=	$this->Categories->optionsOrderItem($options); 
		$htmlWrapper .= 	"</select>" ;
		$htmlWrapper .= "</div>" ;

        $res['htmlWrapper'] = $htmlWrapper ;

		echo json_encode($res) ;
	}

	public function modify()
	{
		$res = array() ;

		$action = $this->input->post('action') ;
		$id_categorie = (int)$this->input->post('id_categorie') ;
		$nom_categorie = $this->input->post('nom_categorie') ;
		$commentaire_categorie = $this->input->post('commentaire_categorie') ;
		
		if (empty($nom_categorie)) {
			$res['state'] = 'empty_name' ;
			$res['msg'] = "Nom de la categorie" ;
		}
		else{
			$data = array(
				'nom_categorie' => $nom_categorie
				,'commentaire_categorie' => $commentaire_categorie
			);

			switch ($action) {
				case 'edit':
						if($this->input->post('ordre_categorie')):
							$ordre_categorie = (int)$this->input->post('ordre_categorie') ;
							$this->Global->updateOrderItem("categories", $ordre_categorie);
						else:
							$ordre_categorie = (int)$this->input->post('old_ordre_categorie') ;
						endif;

						$data['ordre_categorie'] = $ordre_categorie ;
						$this->Categories->update($data,$id_categorie) ;
					break;

				case 'add':
						if($this->input->post('ordre_categorie')):
							$ordre_categorie = (int)$this->input->post('ordre_categorie') ;
							$this->Global->updateOrderItem('categories', $ordre_categorie);
						else:
							$ordre_categorie = $this->Global->getMaxOrderItem("categories") + 1;
						endif;

						$data['ordre_categorie'] = $ordre_categorie ;
						$this->Categories->insert($data) ;
					break;
			}

			$res['state'] = 'success' ;
			$res['msg'] = 'Mise à jour avec succès' ;
		}

		echo json_encode($res) ;
	}

	public function delete()
	{
		$res = array() ;

		$id_categorie = (int)$this->input->post('resource_id') ;
		$this->Categories->delete($id_categorie) ;

		$res['msg'] = "Catégorie supprimée avec succès" ;
		echo json_encode($res);
	}
	
}
