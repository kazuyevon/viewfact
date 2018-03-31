<?php

	include 'inc/misc.php';
	include './class/ClientsManager.php';
	include './class/FacturesManager.php';
	
	try
	{
		$pdo = new PDO($dsn, $username, $password, $options);
		//sleep(5);
	}
	catch (Exception $e)
	{
        die('Erreur : ' . $e->getMessage());
	}
	
	// echo strlen(2018) == 4;
	// $test = (int)"2018";
	// echo $test;
	// echo is_int((int)"2018");
	// echo is_int((int)"test");
	// $test = (int)"parararara";
	// echo $test;
	
	$managerClients = new ClientsManager($pdo);
	$managerFactures = new FacturesManager($pdo);
	
	//test getListClientAnnee
	/* $liste = $managerFactures->getListClientAnnee(0, 2018);
	$liste1 = $managerFactures->getListClientAnnee(0, "2018-03-13");
	$liste2 = $managerFactures->getListClientAnnee(3, 0);
	$liste3 = $managerFactures->getListClientAnnee(3, 2018);
	$liste4 = $managerFactures->getListClientAnnee(3, "2018");
	$liste5 = $managerFactures->getListClientAnnee(3, "test");
	$liste6 = $managerFactures->getListClientAnnee(3, "2018-03-13");
	
	// var_dump($liste);
	echo 'Test 0, 2018<br>';
	foreach($liste as $item){
		echo 'num: "'.$item->num().'" id_client : "'.$item->id_client().'" somme: "'.$item->somme().'" date : "'.$item->date().'"<br>';
	}
	echo '<br><br>Test 0, "2018-03-13"<br>';
	// var_dump($liste);
	foreach($liste1 as $item){
		echo 'num: "'.$item->num().'" id_client : "'.$item->id_client().'" somme: "'.$item->somme().'" date : "'.$item->date().'"<br>';
	}
	echo '<br><br>Test 3, 0<br>';
	// var_dump($liste);
	foreach($liste2 as $item){
		echo 'num: "'.$item->num().'" id_client : "'.$item->id_client().'" somme: "'.$item->somme().'" date : "'.$item->date().'"<br>';
	}
	echo '<br><br>Test 3, 2018<br>';
	// var_dump($liste);
	foreach($liste3 as $item){
		echo 'num: "'.$item->num().'" id_client : "'.$item->id_client().'" somme: "'.$item->somme().'" date : "'.$item->date().'"<br>';
	}
	echo '<br><br>Test 3, "2018"<br>';
	// var_dump($liste);
	foreach($liste4 as $item){
		echo 'num: "'.$item->num().'" id_client : "'.$item->id_client().'" somme: "'.$item->somme().'" date : "'.$item->date().'"<br>';
	}
	echo '<br><br>Test 3, "test" correspond a 0<br>';
	// var_dump($liste);
	foreach($liste5 as $item){
		echo 'num: "'.$item->num().'" id_client : "'.$item->id_client().'" somme: "'.$item->somme().'" date : "'.$item->date().'"<br>';
	}
	echo '<br><br>Test 3, "2018-03-13"<br>';
	// var_dump($liste);
	foreach($liste6 as $item){
		echo 'num: "'.$item->num().'" id_client : "'.$item->id_client().'" somme: "'.$item->somme().'" date : "'.$item->date().'"<br>';
	} */
?>