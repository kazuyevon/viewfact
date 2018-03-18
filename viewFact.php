<?php
include 'header.php';
include 'inc/misc.php';
include './class/ClientsManager.php';
include './class/FacturesManager.php';

if (isset($_GET['idclient'])) {
    $id_client = $_GET['idclient'];
	
	$date;
	$somme;
	$nbAchats;
	$dates;
	$sommes;
	$recupmois;
	//recupère l'annee d'aujoud'hui;
	$annee = date("Y");
	$arraymontant;
	$arraycumul;
	$arraymoyen;
	
	try
	{
		$pdo = new PDO($dsn, $username, $password, $options);
		//sleep(5);
	}
	catch (Exception $e)
	{
        die('Erreur : ' . $e->getMessage());
	}
	
	//utilise manager de client
	$managerClients = new ClientsManager($pdo);
	$client = $managerClients->getclients((int)$id_client);
	$id = $client->id();
	$nom = $client->nom();
	$prenom = $client->prenom();
	
	echo '
	<html><body>
	<div class="container">';
	echo '
		<table class="table">
			<thead>
				<tr>
					<th colspan="2">
						<span class="badge badge-secondary">
							<h1>'.$nom.' '.$prenom.' année '.$annee.'</h1>
						</span>
					</th>
				</tr>
			</thead>
		</table>
		<div class="row">
			<div class="col-lg-10">';
   
	
	
	
	
	
	
	
	
	// recupere toutes les factures du client id_client
	/* $manager = new FacturesManager($pdo);
	$factures = $manager->getList($id_client);
	var_dump($factures);
	foreach ($factures as $uneFacture)
	{
		$date = $uneFacture->date();
		$somme = $uneFacture->somme();
		$dates[] = $date;
		$sommes[] = $somme;
		$mois = substr($date,5);
		$mois = substr($mois,0,2);
		$recupmois[] = (int)$mois;	
	} */
	
	// recupere les factures du client id_client de l'annee demandé
	$managerFactures = new FacturesManager($pdo);
	$factures = $managerFactures->getListAnnee($id_client, $annee);
	$nbAchats = $managerFactures->nbFactAnnee($id_client, $annee);
	foreach ($factures as $uneFacture)
	{
		
		$date = $uneFacture->date();
		$somme = $uneFacture->somme();
		$dates[] = $date;
		$sommes[] = $somme;
		$mois = substr($date,5);
		$mois = substr($mois,0,2);
		$recupmois[] = (int)$mois;
	}
	
	// cree un array de 12 mois de montant vide pour le graph
	for($i=0; $i<12; $i++){
		$arraymontant[] = 0;
		$arraycumul[] = 0;
	}
	
	//remplit l'annee
	$m=0;
	foreach($recupmois as $unMois){
		//on tente de remplir le calendrier de 12 mois avec les valeurs $sommes à leur bonne position $unMois
		//le probleme c'est que le calendrier commence à (1) alors qu'un array commence à (0).
		//-1 car decalage avec l'array qui commence à 0.
		//si la valeur n'est pas de 0, on admet qu'il y a deja une valeur, alors on les additionne
		if ($arraymontant[$unMois-1] != 0){ //$arraymontant[mois 3]
			$arraymontant[$unMois-1] = (double)round(($arraymontant[$unMois-1] + $sommes[$m]), 2);
		}else{
			$arraymontant[$unMois-1] = (double)round($sommes[$m], 2);
		}
		//on ajoute chaque valeur de chaque mois avec la précédente
		if(isset($arraycumul[$unMois-1]) && isset($arraycumul[$unMois-2])){
			$arraycumul[$unMois-1] = (double)round($arraymontant[$unMois-1] + $arraycumul[$unMois-2], 2);
			
		}elseif (isset($arraycumul[$unMois-1])){
			$arraycumul[$unMois-1] = (double)round($sommes[$m], 2);
		}
		$m++;
	}

	//calcule le panier moyen arrondi au centime des achats pour l'afficher sur 12 mois
	for($j=0; $j<12; $j++){
		$arraymoyen[] = (float)round((array_sum($arraymontant)/$nbAchats),2);
	}
	
	// et maintenant, fermez la connexion!
	//$querydb->closeCursor();
	$pdo = null;
	echo'
			<canvas id="myChart" class="chartjs-render-monitor" style="display: block; width: 955px; height: 477px;"></canvas>';
	echo '
			<script src="js/Chart.2.7.2.bundle.min.js" type="text/javascript"></script>
			<script type="text/javascript">
    
				new Chart(document.getElementById("myChart"),{
					"type":"line",
					"data":{
						"labels":["Janvier","Février","Mars","Avril","Mai","Juin","Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"],
						"datasets":[{
							"label":"Montant",
							"data":'.json_encode($arraymontant, JSON_NUMERIC_CHECK).',
							"fill":false,
							"borderColor":"#6b5b95",
							"lineTension":0.1},{
						
							"label":"Cumul",
							"data":'.json_encode($arraycumul, JSON_NUMERIC_CHECK).',
							"fill":false,
							"borderColor":"#d64161",
							"lineTension":0.1},{
					
							"label":"Moyenne",
							"data":'.json_encode($arraymoyen, JSON_NUMERIC_CHECK).',
							"fill":false,
							"borderColor":"#ff7b25",
							"lineTension":0.1}
						]
					},
					"options":{}
				});
	
			</script>';
	//bouton pour afficher les details
	echo '
			<p>
				<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
					Détails
				</button>
			</p>
		</div>'; //fin du col-lg-10
	echo '
		<div class="col-lg-2">ici sera un petit magnet avec infos general stats</div>
		</div>';//fin du row
	
	
	
	echo'
		<div class="collapse" id="collapseExample">
			<div class="card card-body">
				<table class="table">
					<thead class="thead-dark table-bordered">
					<tr>
						<th scope="col">Date</th>
						<th scope="col">Montant</th>
					</tr>
				</thead>
			<tbody>';
	for($i=0; $i<$nbAchats; $i++){
		echo '
				<tr>
					<td>
						'.$dates[$i].'
					</td>
					<td>
						'.$sommes[$i].'
					</td>
				</tr>';
	}	
		echo '
			</tbody>
		</table>
		</div>
	</div>';
echo '
</div>
</body>
</html>';
}
?>