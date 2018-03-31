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

echo'

';
require 'footer.php';
?>