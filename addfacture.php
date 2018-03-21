<?php
include 'header.php';
include 'inc/misc.php';
include 'class/ClientsManager.php';
include 'class/FacturesManager.php';
if (isset($_POST['nombre'])){
	
	
	$nombre = $_POST['nombre'];
	$somme;
	$date;
	
	
	function generateRandomSomme() {
	$symbol = '.';
    $randomString = '';
    $randomString .= mt_rand(0, 99);
	$randomString .= $symbol;
    $randomString .= mt_rand(0, 99);

    return $randomString;
	}
	
	
	function generateRandomDate() {
	$symbol = '-';
    $randomString = '';
    $randomString .= mt_rand(1980, 2018);
  
	$randomString .= $symbol;
	$rand = mt_rand(1, 12);
	if (strlen($rand) == 1){$rand = '0'.$rand;}
    $randomString .= $rand;
	
	$randomString .= $symbol;
	$rand = mt_rand(1, 30);
	if (strlen($rand) == 1){$rand = '0'.$rand;}
    $randomString .= $rand;
    
    return $randomString;
	}
	
	try
	{
		$pdo = new PDO($dsn, $username, $password, $options);
		//sleep(5);
	}
	catch (Exception $e)
	{
        die('Erreur : ' . $e->getMessage());
	}
	
	$managerClients = new ClientsManager($pdo);
	$nbClients = (int)$managerClients->count();
	
	$managerFactures = new FacturesManager($pdo);
	
	
	for ($i=0; $i<$nombre; $i++){
		
		$id_client = (int)mt_rand(1, $nbClients);
		$facture = new Facture([
			'idclient' => $id_client,
			'somme' => generateRandomSomme(),
			'date' => generateRandomDate()
		]);
		$managerFactures->add($facture);
	}
	echo'
			<!--right-->
			<div class="col-md-9">
			<div class="alert alert-success" role="alert">Factures ajoutées</div>';
	
}

	echo '
			<!--right-->
			<div class="col-md-9">
				<div class="col-md-8">
				<label for="basic-addon1">Générateur de facture</label>
					<form action="addfacture.php" method="post">
						<div class="input-group">
							<span class="input-group-addon" id="basic-addon1">nb</span>
							<input type="number" name="nombre" class="form-control" placeholder=Nombre de cleint à générer" aria-describedby="basic-addon1">
							<span class="input-group-btn">
								<button class="btn btn-default" type="submit" value"submit">Go!</button>
							</span>
						</div>
					</form>
				</div>
				<div class="col-md-4">
				</div>';
	
	include 'footer.php';

?>