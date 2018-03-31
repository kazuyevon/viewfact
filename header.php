<!DOCTYPE html>
<html lang="fr">

<head>
	
	<!-- Required meta tags -->
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
        
    <title>View Factures</title>

	<!-- Bootstrap core CSS-->
	<link href="css/bootstrap-3.3.7.min.css" rel="stylesheet">
	<link href="css/jquery-ui.min.css" rel="stylesheet">
	<!-- Custom styles for this template-->
	<link href="css/style.css" rel="stylesheet">

 
</head>

<body>
    
<?php
$keyword = "";

echo'
	<nav class="navbar navbar-default">
		<div class="container-fluid navbar-inverse navbar-fixed-top">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="index.php">View Factures<br>
					<!--<img alt="Brand" src="...">-->
				</a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li class="active"><a href="#">Link<span class="sr-only">(current)</span></a></li>
					<li><a href="#">Link</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="#">Action</a></li>
							<li><a href="#">Another action</a></li>
							<li><a href="#">Something else here</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="#">Separated link</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="#">One more separated link</a></li>
						</ul>
					</li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li><a href="#">Link</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="addclient.php">Ajouter des clients</a></li>
							<li><a href="addfacture.php">Ajouter des factures</a></li>
							<li><a href="#">Something else here</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="#">Separated link</a></li>
						</ul>
					</li>
					<li>
						<div class="navbar-form navbar-left"
							<form class="" action="" method="post">
							<div class="form-group">
								<input type="text" id="searchbox" class="form-control typeahead" name="searchbox" placeholder="Rechercher">
							</div>
							<button type="submit" class="btn btn-default">Ok</button>
							</form>
							<div>
								<a class="btn btn-default" role="button" data-toggle="collapse" data-target="#collapseSearch" aria-expanded="false" aria-controls="collapseExample" style=" width: -webkit-fill-available;">
									Options de recherche
								</a>
								<div class="collapse" id="collapseSearch">
									<div class="well">
										<form method="POST" action="'; echo htmlspecialchars($_SERVER["PHP_SELF"]);echo '">
										<ul class="nav">
										<li><input type="radio" name="category" checked value="nom">Nom de Client</li>
										<li><input type="radio" name="category" value="prenom">Prénom de Client</li>
										<li><input type="radio" name="category" value="num">Numéro de Facture</li>
										<li><input type="radio" name="category" value="somme">Montant de Facture</li>
										<li><input type="radio" name="category" value="date">Date de Facture</li>
										</ul>
										</form>
									</div>
								</div>
							</div>
						</div>
					</li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>
	
	<!--main-->
	<div class="container-fluid">
		<div class="row">
			<!--left-->
			<div class="col-md-2" id="leftCol">
				<ul class="nav nav-stacked" id="sidebar">
					<li><a href="viewClient.php" class="">Clients</a>
					</li>
					<li><a href="#sec1" class="">section1</a>
					</li>
					<li><a href="#sec2" class="">Section 2</a>
					</li>
					<li><a href="#sec3" class="">Section 3</a>
					</li>
					<li><a href="#sec4" class="">Section 4</a>
					</li>
				</ul>
			</div>
			<!--/left-->
			<!--right-->
			<div class="col-md-9">';
			
?>        