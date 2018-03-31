<?php
		
		include 'inc/misc.php';
		include 'class/ClientsManager.php';
		include 'class/FacturesManager.php';
		
		
		
		function utf8json($inArray) { 
		/* Fonction utf8json($inArray) qui encode tout en UTF8 pour prendre en compte les accents des caractères*/
		/* source : http://php.net/manual/fr/function.json-encode.php#99837 */
			static $depth = 0; 

			/* our return object */ 
			$newArray = array(); 

			/* safety recursion limit */ 
			$depth ++; 
			if($depth >= '30') { 
				return false; 
			} 

			/* step through inArray */ 
			foreach($inArray as $key=>$val) { 
				if(is_array($val)) { 
				/* recurse on array elements */ 
				$newArray[$key] = utf8json($val); 
			} else { 
				/* encode string values */ 
				$newArray[$key] = utf8_encode($val); 
			} 
		} 

		/* return utf8 encoded array */ 
		return $newArray; 
		} 
		
		$keyword = strval($_POST['query']);
		$nomResult = array();
		
		if (isset($_POST['category'])) 
		{
			$category = strval($_POST['category']);
		}

		/* ---------------------PDO----------------------------- */
		try
		{
			$pdo = new PDO($dsn, $username, $password, $options);
		}
		catch (Exception $e)
		{
			die('Erreur : ' . $e->getMessage());
		}
		
		// echo 'categorie : '.$category.'<br> Recherche : '.$keyword.'<br>';
		if ($category == "nom" ||$category == "prenom") {
	
			$managerClients = new ClientsManager($pdo);
			$listeClients = $managerClients->getInconnu($keyword, $category);
			
			foreach ($listeClients as $unClient){
				if (($category == "nom"))
				{
					$nomResult[] = $unClient->nom().' '.$unClient->prenom();
				}
				elseif (($category == "prenom"))
				{
					$nomResult[] = $unClient->prenom().' '.$unClient->nom();
				}
				//echo var_dump($unClient).'<br>';
			}
			/* Fonction utf8json($inArray) qui encode tout en UTF8 */
			/* source http://php.net/manual/fr/function.json-encode.php#99837 */
			echo json_encode($nomResult);
			
		}
		elseif ($category == "num" || $category == "somme" || $category == "date") {
			$managerFactures = new FacturesManager($pdo);
			$listeFactures = $managerFactures->getInconnu($keyword, $category);
			foreach ($listeFactures as $uneFacture){
				if (($category == "num")){
					$nomResult[] = utf8_decode('n° ').$uneFacture->num().' '.$uneFacture->somme().' Euros '.$uneFacture->date();
				}
				elseif (($category == "somme")){
					/* utf8_decode(' Euros n°') juste pour décodé ° */
					$nomResult[] = $uneFacture->somme().utf8_decode(' Euros n°').$uneFacture->num().' '.$uneFacture->date();
				}
				elseif (($category == "date")){
					/* utf8_decode(' Euros n°') juste pour décodé ° */
					$nomResult[] = $uneFacture->date().utf8_decode(' n° ').$uneFacture->num().' '.$uneFacture->somme().' Euros';
				}
				// echo var_dump($uneFacture).'<br>';
			}
			// echo var_dump($nomResult).'<br>';
			/* Fonction utf8json($inArray) qui encode tout en UTF8 */
			/* source http://php.net/manual/fr/function.json-encode.php#99837 */
			echo json_encode(utf8json($nomResult));
		}
		$pdo = null;
?>

