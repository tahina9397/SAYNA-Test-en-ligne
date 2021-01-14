<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Taille extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'user_model' => 'Users'
			,'taille_model' => 'Taille'
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
		$this->layout->set('title', 'Taille');
		$this->layout->set('headLink', '');
		$this->layout->set('headScript', array(THEMES_URL."js/scripts/taille/index.js"));
		$this->layout->load('default', 'contents' , 'taille/index');
	}

	public function getAllSize()
	{
		$aColumns = 
			array(
				't.nom_taille'
				,'t.date_taille'
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
				SQL_CALC_FOUND_ROWS t.id_taille
				,t.nom_taille
				,IF(t.date_taille='0000-00-00 00:00:00' OR t.date_taille IS NULL, '', DATE_FORMAT(t.date_taille,'%d %b %Y %Hh %imn')) AS date_taille
			FROM taille t
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
		 	 	$id = $item->id_taille ;

		 	 	$row[] = $item->nom_taille;
		 	 	$row[] = $item->date_taille;

		 	 	$actions = "<span class='cpointer' title='Modifier' onclick='showModal(this)' data-resource_type='editTaille' data-resource_id='".$id."'><i class='fa fa-pencil fa-lg'></i></span>" ;
		 	 	$actions .= "<span class='ml-10 cpointer' title='Supprimer' onclick='deleteSize(this)' data-resource_id='".$id."'><i class='fa fa-trash-o fa-lg'></i></span>" ;
                    
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

		$nom_taille = "" ;

		if($resource_type == 'editTaille'){
			$get = $this->Taille->find($resource_id) ;
			$nom_taille = $get->nom_taille ;
		}
		

		$modal_title = ($resource_type == 'editTaille') ? "Taille : ".$nom_taille : "Ajouter une nouvelle taille" ;
		$action = ($resource_type == 'editTaille') ? "edit" : "add" ;

		$res['modal_title'] =  $modal_title ;

		$htmlWrapper = "" ;

		if($resource_type == 'editTaille'){
			$htmlWrapper .= "<input type='hidden' name='id_taille' value='".$get->id_taille."'>" ;
		}

		$htmlWrapper .= "<input type='hidden' name='action' value='".$action."'>" ;
		$htmlWrapper .= "<div class='form-group'>" ;
		$htmlWrapper .= 	"<label for='nom_taille'>Libellé</label>" ;
		$htmlWrapper .= 	"<input type='text' name='nom_taille' id='nom_taille' class='form-control input-sm' placeholder='Libellé' value='".$nom_taille."'>" ;
		$htmlWrapper .= "</div>" ;

        $res['htmlWrapper'] = $htmlWrapper ;

		echo json_encode($res) ;
	}

	public function modify()
	{
		$res = array() ;

		$action = $this->input->post('action') ;
		$id_taille = (int)$this->input->post('id_taille') ;
		$nom_taille = $this->input->post('nom_taille') ;
		
		if (empty($nom_taille)) {
			$res['state'] = 'empty_name' ;
			$res['msg'] = "Libellé de la taille" ;
		}
		else{
			$data = array(
				'nom_taille' => $nom_taille
			);

			switch ($action) {
				case 'edit':
						$this->Taille->update($data,$id_taille) ;
					break;

				case 'add':
						$this->Taille->insert($data) ;
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

		$id_taille = (int)$this->input->post('resource_id') ;
		$this->Taille->delete($id_taille) ;

		$res['msg'] = "Taille supprimée avec succès" ;
		echo json_encode($res);
	}
	
}
