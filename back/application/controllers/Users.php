<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller
{
	public function __construct()
	{
		// Obligatoire
		parent::__construct();
		// Maintenant, ce code sera exécuté chaque fois que ce contrôleur sera appelé.
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->model(array(
			'user_model' => 'Users'
			,'categorie_model' => 'Categories'
			,'global_model' => 'Global'
		)) ;
		
		if (!$this->Users->getData()) {
			redirect(BASE_URL."/login");
		}
		else{
			redirect(BASE_URL."/infos");

			$this->data = $data = $this->Users->getData() ;
			$role = $data['role'] ;
		}
	}

	public function index()
	{	
		// $data = array() ;
		// $data['js_to_load']= THEMES_URL."js/scripts/categories/index.js" ;
		
		$this->layout->set('title', 'Utilisateurs');
		$this->layout->set('headLink', '');
		$this->layout->set('headScript', array(THEMES_URL."js/scripts/users/index.js"));
		$this->layout->load('default', 'contents' , 'users/index');
	}


	public function getAllUsers()
	{
		$aColumns = 
			array(
				'u.id'
				,'u.username'
				,'u.email'
				,'u.password'
				,'u.role'
				,'u.create_time'
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

        $sWhere .= (trim($sWhere)!="") ? " AND u.id <> ".$this->data["id"] : " WHERE u.id <> ".$this->data["id"] ;

		$sQuery = "
			SELECT 
				SQL_CALC_FOUND_ROWS u.id
				,u.username
				,u.email
				,u.password
				,u.role
				,IF(u.create_time='0000-00-00 00:00:00' OR u.create_time IS NULL, '', DATE_FORMAT(u.create_time,'%d %b %Y %Hh %imn')) AS date_creation
			FROM users u
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
		 	 	$row[] = $item->username ;
		 	 	$row[] = $item->email;
		 	 	$row[] = strtoupper($item->role);
		 	 	$row[] = $item->date_creation;

		 	 	$actions = "<span class='cpointer' title='Modifier' onclick='showModal(this)' data-resource_type='editUser' data-resource_id='".$id."'><i class='fa fa-pencil fa-lg'></i></span>" ;
		 	 	$actions .= "<span class='ml-10 cpointer' title='Supprimer' onclick='deleteUser(this)' data-resource_type='addUser' data-resource_id='".$id."'><i class='fa fa-trash-o fa-lg'></i></span>" ;
                    
		 	 	$row[] = $actions;
		 	 	

		 	 	$output['aaData'][] = $row;
		 	} 
		}
		//var_dump($row);
		echo json_encode($output);
	}



	public function showmodal()
	{
		$res = array() ;

		$resource_id = (int)$this->input->post('resource_id') ;
		$resource_type = $this->input->post('resource_type') ;

		$username = $email = $password = $selectedAdmin = $selectedCaissier = "" ;

		if($resource_type == 'editUser'){
			$get = $this->Users->find($resource_id) ;
			$username = $get->username ;
			$email = $get->email ;
			$password = $get->password ;

			$selectedAdmin = ($get->role == 'admin') ? 'selected' : "" ;
			$selectedCaissier= ($get->role == 'caissier') ? 'selected' : "" ;
		}
		

		$options = array(
		    'atfirst' => array(
		        'value'  => 1
		        ,'title' => "Au début"
		    )
		    ,'atend' => array(
		        'title' => "A la fin"   
		    )
		    ,'tablename' =>'users'
		);

		$modal_title = ($resource_type == 'editUser') ? "Utilisateur #".(int)$get->id : "Ajouter un nouvel utilisateur" ;
		$action = ($resource_type == 'editUser') ? "edit" : "add" ;

		$res['modal_title'] =  $modal_title ;

		$htmlWrapper = "" ;

		if($resource_type == 'editUser'){
			$htmlWrapper .= "<input type='hidden' name='id' value='".$get->id."'>" ;
		}

		$htmlWrapper .= "<input type='hidden' name='action' value='".$action."'>" ;
		$htmlWrapper .= "<div class='form-group'>" ;
		$htmlWrapper .= 	"<label for='username'>Pseudo</label>" ;
		$htmlWrapper .= 	"<input type='text' name='username' id='username' class='form-control input-sm' placeholder='Pseudo' value='".$username."'>" ;
		$htmlWrapper .= "</div>" ;
		$htmlWrapper .= "<div class='form-group'>" ;
		$htmlWrapper .= 	"<label for='email'>Email</label>" ;
		$htmlWrapper .= 	"<input type='text' name='email' id='email' class='form-control input-sm' placeholder='Adresse mail' value='".$email."'>" ;
		$htmlWrapper .= "</div>" ;
		$htmlWrapper .= "<div class='form-group'>" ;
		$htmlWrapper .= 	"<label for='password'>Mot de passe</label>" ;
		$htmlWrapper .= 	"<input type='password' name='password' id='password' class='form-control input-sm' placeholder='' value='".$password."'>" ;
		$htmlWrapper .= "</div>" ;
		$htmlWrapper .= "<div class='form-group'>" ;
		$htmlWrapper .= 	"<label for='role'>Role</label>" ;
		$htmlWrapper .= 	"<select name='role' class='form-control input-sm'>" ;
		$htmlWrapper .= 		"<option value='admin' ".$selectedAdmin.">Admin</option>" ;
		$htmlWrapper .= 		"<option value='caissier' ".$selectedCaissier.">Caissier</option>" ;
		$htmlWrapper .=		"</select>" ;
		$htmlWrapper .= "</div>" ;

        $res['htmlWrapper'] = $htmlWrapper ;

		echo json_encode($res) ;
	}

	public function modify()
	{
		$res = array() ;

		$action = $this->input->post('action') ;
		$id = (int)$this->input->post('id') ;
		$username = $this->input->post('username') ;
		$email = $this->input->post('email') ;
		$password = $this->input->post('password') ;
		$role = $this->input->post('role') ;

		if (empty($username)) {
			$res['state'] = 'empty_name' ;
			$res['msg'] = "Nom d'utilisateur" ;
		}
		else{
			$data = array(
				'username' => $username
				,'email' => $email
				,'password' => md5($password)
				,'role' => $role
			);

			switch ($action) {
				case 'edit':
						$this->Users->update($data,$id) ;
					break;

				case 'add':
						$this->Users->insert($data) ;
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

		$id = (int)$this->input->post('resource_id') ;
		$this->Users->delete($id) ;

		$res['msg'] = "Utilisateur supprimée avec succès" ;
		echo json_encode($res);
	}

	public function showPassword()
	{
		$user_id = $this->input->post('user_id') ;

		$getUser = $this->Global->selectRow('users','password','id='.$user_id) ;

		echo $getUser->password ;
	}

}