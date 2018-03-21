<?php
include 'header.php';
include 'inc/misc.php';
include 'class/ClientsManager.php';
include 'class/FacturesManager.php';

try
	{
		$pdo = new PDO($dsn, $username, $password, $options);
	}
	catch (Exception $e)
	{
        die('Erreur : ' . $e->getMessage());
	}
	$id;
	$nom;
	$prenom;
	$managerClient = new ClientsManager($pdo);
	$facturesManager = new FacturesManager($pdo);

echo'
			<!--right-->
			<div class="col-md-9">
				<div class="col-md-12" id="tab">
				<table class="table table-hover">
					<thead>
						<tr>
							<th scope="col">Nom</th>
							<th scope="col">Prénom</th>
							<th scope="col">Nombres Factures</th>
							<th scope="col">Montant Factures</th>
							<th scope="col">Dernier Achat</th>
						</tr>
					</thead>
					<tbody>';
	
	
	$clients = $managerClient->getList();
	
	//var_dump($clients);
	foreach ($clients as $unClient)
	{
		$id = $unClient->id();
		$nom = $unClient->nom();
		$prenom = $unClient->prenom();
		//On récupère le nb total de factures par client, si 0, on désactive le lien
		$nbFactures = $facturesManager->nbFact($id);
		$montantFactures = $facturesManager->montantFact($id);
		$derniereFact = $facturesManager->lastExistsAnnee($id);
		if ($nbFactures != 0 && $derniereFact != date("Y")){
			echo'
                            <tr class="clickable-row" data-href="viewFact.php?idclient='.$id.'&annee='.$derniereFact.'">';
		}elseif($nbFactures != 0) {
			echo'
                            <tr class="clickable-row" data-href="viewFact.php?idclient='.$id.'&annee='.date("Y").'">';
		}
		
		
		else{
			echo'
                            <tr>';
		}
		echo'
								<td>'.$nom.'</td>
								<td>'.$prenom.'</td>
								<td>'.$nbFactures.'</td>
								<td>'.$montantFactures.'</td>
								<td>'.$derniereFact.'</td>
							</tr>';
	}  					
echo '
						</tbody>
						<tfoot>
						<tr>
							<th scope="col">Nom</th>
							<th scope="col">Prénom</th>
							<th scope="col">Nombres Factures</th>
							<th scope="col">Montant Factures</th>
							<th scope="col">Dernier Achat</th>
						</tr>
					</tfoot>
					</table>
			</div>';

	$pdo = null;

	require 'footer.php';
?>