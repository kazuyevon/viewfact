<?php
include 'header.php';
include 'inc/misc.php';
include './class/ClientsManager.php';
echo'
	    <script src="vendor/chart.js/Chart.min.js"></script>';

/* if (isset($_GET['idclient'])) {
    $something = $_GET['idclient'];
	echo $something;
} */

echo'
			<!--right-->
			<div class="col-md-9">
				<div class="col-md-4">
					<p class="text-center">Center aligned</p>
					<canvas id="myAreaChart" width="100%" height="30"></canvas>
				</div>
				<div class="col-md-4">
					<p class="text-center">Center aligned</p>
					<canvas id="myPieChart" width="100" height="50"></canvas>
				</div>
				<div class="col-md-4">
					<p class="text-center">Center aligned</p>
					<canvas id="myBarChart" width="100" height="50"></canvas>
				</div>
				<table class="table table-hover">
					<thead>
						<tr>
							<th scope="col">Nom</th>
							<th scope="col">Prénom</th>
						</tr>
					</thead>
					<tbody>';
	try
	{
		$pdo = new PDO($dsn, $username, $password, $options);
		//sleep(5);
	}
	catch (Exception $e)
	{
        die('Erreur : ' . $e->getMessage());
	}
	$id;
	$nom;
	$prenom;
	$nbClients;
	
	$managerClient = new ClientsManager($pdo);
	//var_dump($managerClient);
	$clients = $managerClient->getList();
	$nbClients = $managerClient->count();
	//var_dump($clients);
	foreach ($clients as $unClient)
	{
		//echo var_dump($unClient).'<br>';
		$id = $unClient->id();
		//echo $id;
		$nom = $unClient->nom();
		//echo $nom;
		$prenom = $unClient->prenom();
		//echo $prenom;
		/* $ids[] = $id;
		$noms[] = $nom;
		$prenoms[] = $prenom; */
		echo'
                            <form action="viewFact.php" method="GET">
                                    <input id="idform" name="idclient" type="hidden" value="'.$id.'">
                            <tr>
								<td>'.$nom.'</td>
								<td>'.$prenom.'</td>
								<td>
									<button type="submit" class="btn btn-default">Voir</button>
								</td>
							</tr>
                            </form>';
	}  
	echo '
							<tr class="table-active">
								<td>
									TB - Monthly
								</td>
								<td>
									Approved
								</td>
							</tr>
							<tr class="table-success">
								<td>
									TB - Monthly
								</td>
								<td>
									Declined
								</td>
							</tr>
							<tr class="table-warning">
								<td>
									TB - Monthly
								</td>
								<td>
									Pending
								</td>
							</tr>
							<tr class="table-danger">
								<td>
									TB - Monthly
								</td>
								<td>
									Call in to confirm
								</td>
							</tr>';
							
							
echo '
				</tbody>
            </table>';











































































echo '	
		<script type="text/javascript">
		var ctx = document.getElementById("myAreaChart");
		var myLineChart = new Chart(ctx, {
			type: "line",
			data: {
				labels: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"],
				datasets: [{
					label: "Achats",
					lineTension: 0.3,
					backgroundColor: "rgba(2,117,216,0.2)",
					borderColor: "rgba(2,117,216,1)",
					pointRadius: 5,
					pointBackgroundColor: "rgba(2,117,216,1)",
					pointBorderColor: "rgba(255,255,255,0.8)",
					pointHoverRadius: 5,
					pointHoverBackgroundColor: "rgba(2,117,216,1)",
					pointHitRadius: 20,
					pointBorderWidth: 2,
					data: [10000, 30162, 26263, 18394, 18287, 28682, 31274, 33259, 25849, 24159, 32651, 31984],
				},{
					label: "Achats Cumul",
					lineTension: 0.3,
					backgroundColor: "rgba(2,117,216,0.2)",
					borderColor: "rgba(5,117,216,1)",
					pointRadius: 5,
					pointBackgroundColor: "rgba(2,117,216,1)",
					pointBorderColor: "rgba(255,2,255,0.8)",
					pointHoverRadius: 5,
					pointHoverBackgroundColor: "rgba(2,117,216,1)",
					pointHitRadius: 20,
					pointBorderWidth: 2,
					data: [28682, 31274, 33259, 25849, 24159, 32651, 31984, 10000, 30162, 26263, 18394, 18287],
				}],
			},
			options: {
				scales: {
					xAxes: [{
						time: {
							unit: "date"
						},
						gridLines: {
							display: false
						},
						ticks: {
							maxTicksLimit: 7
						}
					}],
					yAxes: [{
						ticks: {
							min: 0,
							max: 40000,
							maxTicksLimit: 5
						},
						gridLines: {
							color: "rgba(0, 0, 0, .125)",
						}
					}],
				},
				legend: {
					display: false
				}
			}
		});
		</script>';

echo '
				<script type ="text/javascript">
					var ctx = document.getElementById("myBarChart");
					var myLineChart = new Chart(ctx, {
						type: "bar",
						data: {
							labels: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"],
							datasets: [{
								label: "Revenue",
								backgroundColor: "rgba(2,117,216,1)",
								borderColor: "rgba(2,117,216,1)",
								data: [4215, 5312, 6251, 7841, 9821, 14984, 4563, 7854, 1253, 2784, 2341, 2096],
							}],
						},
						options: {
							scales: {
								xAxes: [{
									time: {
										unit: "month"
									},
									gridLines: {
										display: false
									},
									ticks: {
										maxTicksLimit: 6
									}
								}],
								yAxes: [{
									ticks: {
										min: 0,
										max: 15000,
										maxTicksLimit: 5
									},
									gridLines: {
										display: true
									}
								}],
							},
							legend: {
								display: false
							}
						}
					});
				</script>';
echo '		
			<script type="text/javascript">
				var ctx = document.getElementById("myPieChart");
				var myPieChart = new Chart(ctx, {
				type: "pie",
				data: {
					labels: ["Printemps", "Eté", "Automne", "Hiver"],
					datasets: [{
						data: [12.21, 15.58, 11.25, 8.32],
						backgroundColor: ["#28a745", "#dc3545", "#ffc107", "#007bff"],
					}],
					},
				});
			</script>';

	
	// utiliser la connexion ici
	/* $querydb = $pdo->prepare('SELECT id, nom, prenom FROM clients ORDER BY nom ASC');
	$querydb->execute();
	$round = 1;
	while ($donnees = $querydb->fetch())
	{
		echo '
		<form action="viewClient.php" method="GET">
			<input id="idform" name="idclient" type="hidden" value="'.$donnees['id'].'">
			<tr>
				<td>
					'.$donnees['nom'].'
				</td>
				<td>
				'.$donnees['prenom'].'
				</td>
				<td>
					<button type="submit" class="btn btn-default">Voir</button>
				</td>
			</tr>
		</form>
		';
	} */

	//sleep(60);
	// et maintenant, fermez la connexion!
	//$querydb->closeCursor();
	$pdo = null;

	require 'footer.php';
?>