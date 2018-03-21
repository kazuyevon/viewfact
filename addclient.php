<?php
include 'header.php';
include 'inc/misc.php';
include 'class/ClientsManager.php';
include 'class/FacturesManager.php';
if (isset($_POST['nombre'])){
	
	
	$nombre = $_POST['nombre'];
	$noms;
	$prenom;
	
	
	function generateRandomNom($length) {
	$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
	}
	function generateRandomPrenom($length) {
	$characters = 'abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
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
	
	
	
	for ($i=0; $i<$nombre; $i++){
		
		$client = new Client([
			'nom' => generateRandomNom(10),
			'prenom' => generateRandomPrenom(5)
		]);
		$managerClients->add($client);
	}
	echo'
			<!--right-->
			<div class="col-md-9">
			<div class="alert alert-success" role="alert">Clients ajoutés</div>';
	
}

	echo '
				<div class="col-md-8">
				<label for="basic-addon1">Générateur de client</label>
					<form action="addclient.php" method="post">
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