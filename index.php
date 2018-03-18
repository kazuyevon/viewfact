<?php
include 'header.php';
include 'inc/misc.php';
include './class/ClientsManager.php';

/* if (isset($_GET['idclient'])) {
    $something = $_GET['idclient'];
	echo $something;
} */
echo '

	<table class="table">
		<thead class="thead-dark">
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
	$ids = array();
	$noms = array();
	$prenoms = array();
	
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
		<form action="viewClient.php" method="GET">
			<input id="idform" name="idclient" type="hidden" value="'.$id.'">
			<tr>
				<td>
					'.$nom.'
				</td>
				<td>
					'.$prenom.'
				</td>
				<td>
					<button type="submit" class="btn btn-default">Voir</button>
				</td>
			</tr>
		</form>';
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
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
	echo '
	</tbody>
	</table>
	</body>

	</html>';
?>