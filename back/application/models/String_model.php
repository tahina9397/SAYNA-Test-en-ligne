<?php

if ( ! defined('BASEPATH')) exit('No direct script access
allowed');

class String_model extends CI_Model{
	public function cutword($keyword,$column)
	{
		$mots = explode(" ",$keyword); //séparation des mots de la recherche à chaque espace grâce à explode
		$nombre_mots = count($mots);
		$str="";
	
		for($i=0;$i<$nombre_mots;$i++)
			{	
				$str .= " $column LIKE '%$mots[$i]%' ";
				if($i != $nombre_mots-1)
				 $str .= ' or ';
			}
		return $str;	
	}
		
   	public function text_cut($str, $no_words_ret)
	{
		$tags = array ('font', 'div', 'span', 'p', 'br', 'strong', 'b', 'u', 'i', 'a', 'ul', 'li');
	
		$word_count = 0;
		$pos = 0;
		$str_len = strlen($str);
		$str .= ' <';
		$open_tags = array ();
	
		while ($word_count <= $no_words_ret && $pos < $str_len) 
		{
			$pos = min(strpos($str, ' ', $pos), strpos($str, '<', $pos));
			if ($str[$pos] == '<') 
			{
				if ($str[$pos + 1] == '/') 
				{
					array_pop($open_tags);
				} 
				else 
				{
					$sub = substr($str, $pos + 1, min(strpos($str, ' ', $pos), strpos($str, '>', $pos)) - $pos - 1);
					if (in_array($sub, $tags)) 
					{
						array_push($open_tags, $sub);
					}
				}
				$pos = strpos($str, '>', $pos) + 1;
			} 
			else 
			{
				$pos++;
				if($str[$pos] != ' ')//Code ajout
					$word_count++;
			}
	
		}
	
		$str = substr($str, 0, $pos);
		if($word_count>$no_words_ret)
			$str = ($str)."...";
		if (count($open_tags) > 0) {
			foreach($open_tags as $value) {
				
				$str .= '</' . array_pop($open_tags) . '>';
			}
		}
	
		return($str);
	}

	public function noaccent($chaine)
	{
		$accents =  "ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ";
		$sans_accents = "AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy";
		$chaine = strtr(utf8_decode($chaine), utf8_decode($accents), $sans_accents);
		$chaine = preg_replace('/([^.a-z0-9]+)/i', '-', $chaine);
		$chaine = preg_replace('/([_]+)/i', '-', $chaine);   
		return $chaine;
	}
	
	public function valideChaine($chaineNonValide)
	{
		$chaineNonValide = preg_replace('`\s+`', '-', trim($chaineNonValide));
		$chaineNonValide = str_replace("'", "-", $chaineNonValide);
		$chaineNonValide = preg_replace('`_+`', '-', trim($chaineNonValide));
		$chaineValide=strtr($chaineNonValide,"ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ","aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn");
		return ($chaineValide);
	}
		
	public function cleanString($str)
	{
		return strtolower(self::valideChaine(self::noaccent($str)));
	}

	public function cutwords($string,$length)
	{
		return substr($string,0,$length).'...';
	}
	
	public function rand_string( $length ) 
	{
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";	
	
		$str = '';
	
		$size = strlen( $chars );
		for( $i = 0; $i < $length; $i++ ) {
			$str .= $chars[ rand( 0, $size - 1 ) ];
		}
	
		return $str;
	}
	
	public function createRandomPassword() 
	{
	
		$chars = "abcdefghijkmnopqrstuvwxyz023456789";
		srand((double)microtime()*1000000);
	
		$i = 0;
		$pass = '' ;
	
		while ($i <= 7) {
			$num = rand() % 33;
			$tmp = substr($chars, $num, 1);
			$pass = $pass . $tmp;
			$i++;
		}
	
		return $pass;
	}		

	public function contains($substring, $string) 
	{
	    $pos = strpos($string, $substring);

	    if($pos === false) {
	        // string needle NOT found in haystack
	        return false;
	    }
	    else {
	        // string needle found in haystack
	        return true;
	    }
	}

	public function formatFilename($full_filename)
	{ 
		$targetfilename_normalize = self::filterAccent($full_filename, 'utf-8');
		$targetfilename           = strtolower($targetfilename_normalize);	
		$targetfilename_formated  = str_replace(" ", "-", $targetfilename);
		return $targetfilename;
	}

	public function filterAccent($str, $charset='utf-8')
	{
		$str = htmlentities($str, ENT_NOQUOTES, $charset);

		$str = preg_replace('#\&([A-za-z])(?:acute|cedil|circ|grave|ring|tilde|uml)\;#', '\1', $str);
		$str = preg_replace('#\&([A-za-z]{2})(?:lig)\;#', '\1', $str); // pour les ligatures e.g. '&oelig;'
		$str = preg_replace('#\&[^;]+\;#', '', $str); // supprime les autres caractères
		$str = preg_replace('@[^a-zA-Z0-9_ -]@','',$str);
		return $str;
   	}
	
	 public function wd_remove_accents($str, $charset='utf-8'){
		  $str = htmlentities($str, ENT_NOQUOTES, $charset);
		  
		  $str = preg_replace('#&([A-za-z])(?:acute|cedil|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
		  $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. '&oelig;'
		  $str = preg_replace('#&[^;]+;#', '', $str); // supprime les autres caractères
		  
		  return $str;
   }

   public function noespace($str){
   		$res = str_replace("-", "", $str);
   		return $res;
   }
	
}