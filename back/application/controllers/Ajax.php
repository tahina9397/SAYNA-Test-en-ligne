<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'article_model' => 'Articles'
			,'categorie_model' => 'Categorie'
			,'global_model' => 'Global'
			,'historique_model' => 'Historique'
			,'options_model' => 'Options'
			,'string_model' => 'String'
			,'taille_model' => 'Taille'
			,'user_model' => 'Users'
			,'utils_model' => 'Utils'
		)) ;
	}

	public function generateCodeBarre()
	{
		$resource_type = $this->input->post('resource_type');

		switch ($resource_type) {
			case 'articles':
					$getAllOptions = $this->Options->getAllOptions() ;
					$code7 = $getAllOptions['codebarre'] ;
					$articleCode = $this->Utils->generate(5) ;

					$t = trim($code7.$articleCode) ;
					// $t = "313178193226" ;

					$getCleControleCodeBarre = $this->Utils->cleControleCodeBarre($t) ;
					$string = $getCleControleCodeBarre['full'] ;

					$res['string'] = $string ;
					$res['attribute'] = 'codebarre_article' ;
				break;
				
			default:
				break;
		}
		

		echo json_encode($res) ;
	}

	public function showModalFacture()
	{
		$res = array() ;

		$facture_id = (int)$this->input->post('resource_id') ;
		$resource_type = $this->input->post('resource_type') ;

		$facture = $this->Global->selectRow('factures','facture_numero','id_facture='.$facture_id) ;
		$getArticleByFactureId = $this->Historique->getArticleByFactureId($facture_id) ;

		$res['modal_title'] = "Détails ticket #".$facture->facture_numero ;

		$htmlWrapper = "<div class='pl-25 pr-25'>" ;

		if(!empty($getArticleByFactureId)){
			foreach ($getArticleByFactureId as $item) {
				$htmlWrapper .= "<span class='pull-left'>".$item->nom_article."</span>" ;
				$htmlWrapper .= "<span class='pull-right'>".$item->vente_quantite."</span>" ;
				$htmlWrapper .= "<br>" ;
			}
		}

		$htmlWrapper .= "</div>" ;

		$res['htmlWrapper'] = $htmlWrapper ;
		// $res['modalFooter'] = '<span class="btn btn-danger btn-sm" onclick="printFacture(this)" data-resource_type="'.$resource_type.'" data-resource_id="'.$facture_id.'">Imprimer ticket de caisse</span>' ;
		$res['modalFooter'] = '<a href="javascript:void(0)" target="_blank"><span class="btn btn-danger btn-sm" data-resource_type="'.$resource_type.'" data-resource_id="'.$facture_id.'">Imprimer ticket de caisse</span></a>' ;


		echo json_encode($res) ;
	}
}
