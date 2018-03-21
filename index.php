<?php
include 'header.php';
include 'inc/misc.php';
include 'class/ClientsManager.php';
include 'class/FacturesManager.php';
echo'
	    <script src="js/Chart.2.7.2.bundle.min.js"></script>';
try
	{
		$pdo = new PDO($dsn, $username, $password, $options);
	}
	catch (Exception $e)
	{
        die('Erreur : ' . $e->getMessage());
	}

	$managerClient = new ClientsManager($pdo);
	$facturesManager = new FacturesManager($pdo);
	$nbClients = $managerClient->count();
	$totaFactures = $facturesManager->count();
	$sommeTotalFactures = round($facturesManager->somme(), 2);
	$minSommeTotal = round($facturesManager->minSomme(), 2);
	$maxSommeTotal = round($facturesManager->maxSomme(), 2);

echo'
			
				<div class="col-md-12">
					<div class="col-md-6">
						<div class="alert alert-info" role="alert">
							<ul class="list-group">
								<li class="list-group-item">
									<span class="badge">'.$nbClients.'</span>
									Nombre de Clients
								</li>
								<li class="list-group-item">
									<span class="badge">'.$totaFactures.'</span>
									Nombre de Factures
								</li>
								<li class="list-group-item">
									<span class="badge">'.$sommeTotalFactures.'</span>
									Somme des  Factures
								</li>
								<li class="list-group-item">
									<span class="badge">'.$minSommeTotal.'</span>
									Minimum des  Factures
								</li>
								<li class="list-group-item">
									<span class="badge">'.$maxSommeTotal.'</span>
									Maximum des  Factures
								</li>
							</ul>
						</div>
					</div>
					<div class="col-md-6">
						<div class="alert alert-info" role="alert">
							<ul class="list-group">
								<li class="list-group-item">
									<span class="badge"></span>
									
								</li>
								<li class="list-group-item">
									<span class="badge"></span>
									
								</li>
								<li class="list-group-item">
									<span class="badge"></span>
									
								</li>
								<li class="list-group-item">
									<span class="badge"></span>
									
								</li>
								<li class="list-group-item">
									<span class="badge"></span>
									
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-pause="hover">
						<ol class="carousel-indicators">
							<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
							<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
							<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
						</ol>
						<div class="carousel-inner" id="carousel" style="width: 75%; margin: auto;">
							<div class="item active">
								<canvas id="myAreaChart" class="d-block w-100"" alt="First slide"></canvas>
								<div class="carousel-caption">
									<!--<h1 class="super-heading">Exemple</h1>-->
									<p class="super-paragraph">Exemple</p>
								</div>
							</div>
							<div class="item">
								<canvas id="myPieChart" class="d-block w-100" alt="Second slide"></canvas>
								<div class="carousel-caption">
									<!--<h1 class="super-heading">Exemple</h1>-->
									<p class="super-paragraph">Exemple</p>
								</div>
							</div>
							<div class="item">
								<canvas id="myBarChart" class="d-block w-100" alt="Third slide">></canvas>
								<div class="carousel-caption">
									<!--<h1 class="super-heading">Exemple</h1>-->
									<p class="super-paragraph">Exemple</p>
								</div>
							</div>
						</div>
					</div>
				</div>
				';

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

	$pdo = null;

	require 'footer.php';
?>