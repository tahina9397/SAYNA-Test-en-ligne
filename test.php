
<?php
 function test(){
 $question = (int)$this->_getParam("question") ;

	   	switch ($question) {
	   		/*Algorithme Somme*/
	   		case 1:
	   				$n = (int)$this->_getParam("n") ;

	   				$total = 0 ;

	   				for ($i=0; $i <=$n ; $i++) { 
	   					$total += $i ;
	   				}

	   				$res["Subject"] = "Algorithme Somme" ;
	   				$res["Entier"] = $n ;
	   				$res["Response"] = str_replace("#n#", $n, "La somme des #n# premiers nombres est : ".$total) ;
	   			break;

	   		/*"Algorithme MaxMin*/
	   		case 2:
	   				$n = $this->_getParam("n") ;

	   				$tabs = explode(",", $n) ;

	   				// $min = min($tabs) ;
	   				// $max = max($tabs) ;

	   				$max = $tabs[0] ;
	   				$min = $tabs[0] ;

	   				for ($i=1; $i <sizeof($tabs) ; $i++) { 
	   					if ($max < $tabs[$i]) {
	   						$max = $tabs[$i] ;
	   					}
	   					else if($min > $tabs[$i]){
	   						$min = $tabs[$i] ;
	   					}
	   				}

	   				$t = "Le minimum des valeurs est #min#. Le maximum des valeurs est #max#." ;
	   				$t = str_replace("#min#", $min, $t) ;
	   				$t = str_replace("#max#", $max, $t) ;

   					$res["Subject"] = "Algorithme MaxMin" ;
   					$res["Entier"] = $n ;
   					$res["Response"] = $t ;
   				break;

   			/*Algorithme QuotReste*/
   			case 3:
   					$a = (int)$this->_getParam("a") ;
   					$b = (int)$this->_getParam("b") ;

   					$q = 0 ;
   					$r = $a ;

   					while ( $r >= $b) {
   						$q = $q + 1; 
   						$r = $r - $b ;
   					}

   					$res["Subject"] = "Algorithme QuotReste" ;
   					$res["Entier"] =  "A = {$a} / B = {$b}" ;
   					$res["Response"] = "Le quotient de {$a}/{$b} est :{$q} . Le reste de {$a}/{$b} est :{$r}" ;
   				break;

   			/*Algorithme Produit*/
   			case 4:
   					$a = (int)$this->_getParam("a") ;
   					$b = (int)$this->_getParam("b") ;

   					$total = 0 ;

   					if ($a != 0 && $b != 0) {
   						if ($a > $b) {
   							$total = $a ;

   							for ($i=2; $i <=$b ; $i++) { 
   								$total = $total + $a;
   							}
   						}
   						else{
   							$total = $b ;

   							for ($i=2; $i <=$a ; $i++) { 
   								$total = $total + $b;
   							}
   						}
   					}

   					$res["Subject"] = "Algorithme Produit" ;
   					$res["Entier"] =  "A = {$a} / B = {$b}" ;
   					$res["Response"] = "Le produit de {$a}*{$b} est : {$total}" ;
   				break;

   			/*Algorithme AdivB*/
   			case 5:
   					$a = (int)$this->_getParam("a") ;
   					$b = (int)$this->_getParam("b") ;

   					$r = $a ;

   					while ( $r > 0) {
   						$r = $r - $b ;
   					}
   					
   					$res["Subject"] = "Algorithme AdivB" ;
   					$res["Entier"] =  "A = {$a} / B = {$b}" ;
   					$res["Response"] = ($r == 0) ? "{$a} est divisible par {$b}" : "{$a} n'est pas divisible par {$b}" ;
   				break;

   			/*Algorithme Diviseurs*/
   			case 6:
	   				$x = (int)$this->_getParam("x") ;

	   				$m = $x / 2 ;

	   				for ($i=1; $i <=$m ; $i++) { 

	   					if (($x % $i) == 0) {
	   						$tabs[] = $i ;
	   					}
	   				}

					$res["Subject"] = "Algorithme Diviseurs" ;
					$res["Entier"] = $x ;
					$res["Response"] = "Les diviseurs de {$x} sont : ".implode(", ", $tabs);
   				break;

   			/*Algorithme Premier*/
   			case 7:
	   				$n = (int)$this->_getParam("n") ;
   					$bool = true ;

   					if ($n <= 1) {
   						$bool = false ;
   					}
   					else{
   						$i = 2 ;
   						$m = $n / 2 ;

   						while ( ($i <= $m) && $bool) {
   							if ($n % $i == 0) {
					           $bool = false ;
   							}

   							$i += 1 ;
   						}
	   					// for ($i = 2; $i < $n; $i++) {
					    //     if ($n % $i == 0) {
					    //        $bool = false ;
					    //     }
					    // }
   					}

				    $text = ($bool) ? str_replace("#n#", $n, "#n# est premier") : str_replace("#n#", $n, "#n# n'est pas premier")  ;

   					$res["Subject"] = "Algorithme Premier" ;
   					$res["Entier"] = $n ;
   					$res["Response"] = $text ;
   				break;

   			/*Algorithme SommeChiff*/
   			// case 8:
	   		// 		$n = (int)$this->_getParam("n") ;

	   		// 		$s = 0 ;
	   		// 		$r = 0 ;

	   		// 		while ($r >= 0) {
	   		// 			$s += $n % 10 ;
	   		// 			$r = $n / 10 ;
	   		// 		}

   			// 		$res["Subject"] = "Algorithme SommeChiff" ;
   			// 		$res["Entier"] = $n ;
   			// 		$res["Response"] = "La somme des chiffres qui composent {$n} est : {$s}" ;
   			// 	break;
	   		
	   		default:
	   			break;
	   	}

	   	echo json_encode($res) ;
 }

?>
