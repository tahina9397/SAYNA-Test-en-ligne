<?php if ( ! defined('BASEPATH')) exit('No direct script access
allowed');
 
class Utils_model extends CI_Model
{
	public function __construct()
	{
	    parent::__construct();
	    $this->load->model(array(
	        'global_model' => 'Global'
	    )) ;
	}

	public static function idx(array $array, $key, $default = null) {
	  	return array_key_exists($key, $array) ? ($array[$key]=='0' ? '' : $array[$key]) : $default;
	}

	/**
	 * Returns mysql datetime for current time
	 */
	public static function now()
	{
		return date('Y-m-d H:i:s', time());
	}

	public static function generate($length){

		$string = "";
		$chaine = "1234567890";
		srand((double)microtime()*1000000);
		for($i=0; $i<$length; $i++) {
			$string .= $chaine[rand()%strlen($chaine)];
		}
		return $string;
	}

	public function cleControleCodeBarre($cb)
	{
		$calcul = (($cb[1]+$cb[3]+$cb[5]+$cb[7]+$cb[9]+$cb[11])*3)+($cb[0]+$cb[2]+$cb[4]+$cb[6]+$cb[8]+$cb[10]);
		$unite = substr($calcul,-1, 1);
		if($unite!=0) $clef = 10-$unite;
		else $clef=0;
		$cbean = ($cb*10)+$clef; 
		return array("cle" => $clef , "full" => $cbean) ;
	}

	public function getNewUniqid($length = 8,$table)
	{
		$id = ($table == 'articles') ? "id_article" : "id_categorie" ;

		$chaine = "ABCDEFGHIJKLMN1234567890";
		srand((double)microtime()*1000000);
		$ok=false;
		while($ok===false){
			$string = "";
			for($i=0; $i<$length; $i++) {
				$string .= $chaine[rand()%strlen($chaine)];
			}
			$req=$this->Global->selectRow($table,$id,"uniqid = '$string'");
			if(empty($req)){
				$ok=true;
			}
		}
		return $string;
	}
}