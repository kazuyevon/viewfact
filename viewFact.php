<?php
include 'header.php';
include 'inc/misc.php';
include './class/ClientsManager.php';
include './class/FacturesManager.php';

if (isset($_GET['idclient'])) {
    $id_client = (int)$_GET['idclient'];
	
	try
	{
		$pdo = new PDO($dsn, $username, $password, $options);
		//sleep(5);
	}
	catch (Exception $e)
	{
        die('Erreur : ' . $e->getMessage());
	}
	
	$date;
	$somme;
	$nbAchats;
	$dates;
	$sommes;
	$recupmois;
	$arraymontant;
	$arraycumul;
	$arraymoyen;
	
	$managerFactures = new FacturesManager($pdo);
	
	//on s'assure que $annee contienne une annee sinon on met celle courante
	if (($_GET['annee'] != '0') && (!$managerFactures->existsAnnee($id_client, $_GET['annee']))){
		//sinon on recupère l'annee d'aujoud'hui;
		$annee = date("Y");
	}else
	{
		$annee = $_GET['annee'];
	}
	
	//utilise manager de client
	$managerClients = new ClientsManager($pdo);
	$client = $managerClients->getclients((int)$id_client);
	$id = $client->id();
	$nom = $client->nom();
	$prenom = $client->prenom();
	
	//recupère liste années existantes
	$annees = array();
	$annees = $managerFactures->arrayExistsAnnee($id_client);
	//var_dump($annees);

	echo '
				<nav aria-label="Page navigation">
					<ul class="pagination">
						<!--<li>
							<a href="#" aria-label="Previous">
								<span aria-hidden="true">&laquo;</span>
							</a>
						</li>-->';
	foreach ($annees as $an){
	echo '
						<li><a href="viewFact.php?idclient='.$id_client.'&annee='.$an.'">'.$an.'</a></li>';	
	}
	
	echo '
						<!--<li>
							<a href="#" aria-label="Next">
								<span aria-hidden="true">&raquo;</span>
							</a>
						</li>-->
					</ul>
				</nav>
				<div class="col-md-8">
					<h1>'.$nom.' '.$prenom.' année '.$annee.'</h1>';
					
	// recupere les factures du client id_client de l'annee demandé
	
	$factures = $managerFactures->getListClientAnnee($id_client, $annee);
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
		$m++;
	}
	
	$m=0;
	foreach($arraymontant as $unMontant){
		
		if ($m == 0 ){
			$arraycumul[] = $unMontant;
		}else {
			$arraycumul[] = $unMontant + $arraycumul[$m-1];
		}
		$m++;
	}
	
	

	// calcul la somme de l'annee du client
	// déjà calculé array_sum($arraymontant));
	/* $sommeTotal = $managerFactures->montantFact($id_client);*/
	
	//calcule le nb d'achat de l'année du client
	$nbAchats = $managerFactures->nbFactAnnee($id_client, $annee);
	
	
	//calcule le panier moyen arrondi au centime des achats pour l'afficher sur 12 mois
	for($j=0; $j<12; $j++){
		$arraymoyen[] = (float)round((array_sum($arraymontant)/$nbAchats),2);
	}
	
	// et maintenant, fermez la connexion!
	//$querydb->closeCursor();
	$pdo = null;
	echo'
					<canvas id="myChart" class="chartjs-render-monitor" style="display: block; width: 500px; height: 250px;"></canvas>';
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
					</p>';
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
										<td>'.$dates[$i].'</td>
										<td>'.$sommes[$i].'</td>
									</tr>';
	}	
	echo '
								</tbody>
							</table>
						</div>
					</div>';
echo '
				</div>
				<div class="col-md-4">
					<div class="alert alert-success" role="alert">
						<ul class="list-group">
							<li class="list-group-item">
								<span class="badge">'.$arraymoyen[0].'</span>
									Achats Moyen année '.$annee.'
							</li>
							<li class="list-group-item">
								<span class="badge">'.$nbAchats.'</span>
									Nombre d\'achats '.$annee.'
							</li>
							<li class="list-group-item">
								<span class="badge">'.min(array_filter($arraymontant)).'</span>
									Achat min '.$annee.'
							</li>
							<li class="list-group-item">
								<span class="badge">'.max($arraymontant).'</span>
									Achats max '.$annee.'
							</li>
							<li class="list-group-item">
								<span class="badge">'.$arraycumul[11].'</span>
									Achat Total '.$annee.'
							</li>
						</ul>
				
					</div>
					<div class="alert alert-info" role="alert">
						<ul class="list-group">
							<li class="list-group-item">
								<span class="badge">012345678</span>
									Téléphone
							</li>
							<li class="list-group-item">
								<span class="badge">1 rue des Peupliers,<br> 17000 La Rochelle</span>
									Adresse
							</li>
						</ul>
				
					</div>
				</div>
				';
	
include 'footer.php';
}
?>