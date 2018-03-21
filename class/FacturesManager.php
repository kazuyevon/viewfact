<?php
include 'class/Facture.php';
class FacturesManager
{
  private $_pdo; // Instance de PDO
  
  public function __construct($pdo)
  {
    $this->setDb($pdo);
  }
  
  public function add(Facture $facture)
  {
    $q = $this->_pdo->prepare('INSERT INTO factures(idclient, date, somme) VALUES(:id_client, :date, :somme)');
    $q->bindValue(':id_client', $facture->id_client());
	$q->bindValue(':date', $facture->date());
	$q->bindValue(':somme', $facture->somme());
    $q->execute();
    
    $facture->hydrate([
      'num' => $this->_pdo->lastInsertId(),
      'idclient' => 100,
	  'somme' => 0,
	  'date' => date("Y-m-d"),
    ]);
  }
  
  public function count()
  {
    return $this->_pdo->query('SELECT COUNT(*) FROM factures')->fetchColumn();
  }
  
  public function somme()
  {
	  return $this->_pdo->query('SELECT SUM(somme) FROM factures')->fetchColumn();
  }
  
  public function sommeAnnee($annee)
  {
	return $this->_pdo->query('SELECT SUM(somme) FROM factures WHERE YEAR(date) = '.$annee)->fetchColumn();
  }
  
  public function nbFact($id_client)
  {
	$nombre = $this->_pdo->query('SELECT COUNT(*) FROM factures WHERE idclient = '.$id_client)->fetchColumn();
	return $nombre;
  }
  
  public function nbFactAnnee($id_client, $annee)
  {
	$nombre = $this->_pdo->query('SELECT COUNT(*) FROM factures WHERE idclient = '.$id_client.' AND YEAR(date) = '.$annee)->fetchColumn();
	return $nombre;
  }
  
  public function montantFact($id_client)
  {
	$montant = $this->_pdo->query('SELECT SUM(somme) FROM factures WHERE idclient = '.$id_client)->fetchColumn();
	return round($montant, 2);
  }
  
  public function montantFactAnnee($id_client, $annee)
  {
	$montant = $this->_pdo->query('SELECT SUM(somme) FROM factures WHERE idclient = '.$id_client.' AND YEAR(date) = '.$annee)->fetchColumn();
	return round($montant, 2);
  }
  
  public function delete(Facture $facture)
  {
    $this->_pdo->exec('DELETE FROM factures WHERE num = '.$facture->num());
  }
  
  public function exists($info)
  {
    if (is_int($info)) // On veut voir si tel facture ayant pour num $info existe.
    {
      return (bool) $this->_pdo->query('SELECT COUNT(*) FROM factures WHERE num = '.$info)->fetchColumn();
    }
    
    // Sinon, c'est qu'on veut vérifier que le date existe ou pas.
    
    $q = $this->_pdo->prepare('SELECT COUNT(*) FROM factures WHERE date = :date');
    $q->execute([':date' => $info]);
    
    return (bool) $q->fetchColumn();
  }
  
  public function existsAnnee($id_client, $annee)
  {
    // on veut vérifier qu'il existe des factures pour l'année donnée.
    
    $q = $this->_pdo->prepare('SELECT COUNT(*) FROM factures WHERE idclient = :id_client AND YEAR(date) = :annee');
    $q->execute([':id_client' => $id_client, ':annee' => $annee]);
    
    return (bool) $q->fetchColumn();
  }
  
  public function arrayExistsAnnee($id_client)
  {
    // on veut recupérer les années existantes.
    $annees = array();
    $q = $this->_pdo->prepare('SELECT DISTINCT YEAR(date) AS an FROM factures WHERE idclient = :id_client ORDER BY date');
	$q->execute([':id_client' => $id_client]);
	
	while ($an = $q->fetch(PDO::FETCH_ASSOC))
    {
      $annees[] = $an['an'];
    }
    
    return $annees;
  }
  
   public function lastExistsAnnee($id_client)
  {
    // on veut recupérer la derniere année existante.
    $annee;
    $q = $this->_pdo->prepare('SELECT MAX(YEAR(date)) AS an FROM factures WHERE idclient = :id_client');
	$q->execute([':id_client' => $id_client]);
	
	while ($an = $q->fetch(PDO::FETCH_ASSOC))
    {
      $annee = $an['an'];
    }
    
    return $annee;
  }
  
  public function getFacture($num)
  {
	// si $num est un int, on admet alors rechercher la facture de num $infos
	if (is_int($num))
    {
      $q = $this->_pdo->query('SELECT num, idclient, date, somme FROM factures WHERE num = '.$num);
      $donnees = $q->fetch(PDO::FETCH_ASSOC);
      
      return new Facture($donnees);
    }
  }
  
   public function getListClientAnnee($id_client, $annee)
  {
	// Si client est 0 et annee est défini en date, on verifie que c'est une date au format 0000-00-00 uniquement et on liste toutes les factures de la date donnée
	if ($id_client == 0 && preg_match("/^[0-9]{4}(-)(0[1-9]|1[0-2])(-)(0[1-9]|[1-2][0-9]|3[0-1])$/", $annee)) {
		$factures = [];
    
		$q = $this->_pdo->prepare("SELECT num, idclient, date, somme FROM factures WHERE date = :date ORDER BY date ASC");
		$q->execute([':date' => $annee]);
    
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$factures[] = new Facture($donnees);
		}
    
		return $factures;
	}
	// Si client est 0 et annee est défini en annee, on verifie que c'est une annee et on liste toutes les factures de la date donnée
	elseif ($id_client == 0 && (strlen($annee) == 4)) {
		$factures = [];
    
		$q = $this->_pdo->prepare("SELECT num, idclient, date, somme FROM factures WHERE YEAR(date) = :annee ORDER BY date ASC");
		$q->execute([':annee' => $annee]);
    
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$factures[] = new Facture($donnees);
		}
    
		return $factures;
	}
	// Si client est 0 et annee est 0
	elseif ($id_client == 0 && $annee == 0) {
		$factures = [];
    
		$q = $this->_pdo->prepare("SELECT num, idclient, date, somme FROM factures ORDER BY date ASC");
		$q->execute();
    
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$factures[] = new Facture($donnees);
		}
    
		return $factures;
	}
	// Si client est défini et annee est 0, si $id_client est un int
	elseif ($id_client != 0 && $annee == 0 && is_int($id_client)) {
		$factures = [];
    
		$q = $this->_pdo->prepare("SELECT num, idclient, date, somme FROM factures WHERE idclient = :id_client ORDER BY date ASC");
		$q->execute([':id_client' => $id_client]);
    
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$factures[] = new Facture($donnees);
		}
    
		return $factures;
	}
	// Si client est défini et annee est défini sur annee
	else if ($id_client != 0 && is_int($id_client) && (strlen($annee) == 4)) {
		$factures = [];
    
		$q = $this->_pdo->prepare("SELECT num, idclient, date, somme FROM factures WHERE idclient = :id_client AND YEAR(date) = :annee ORDER BY date ASC");
		$q->execute([':id_client' => $id_client, ':annee' => $annee]);
    
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$factures[] = new Facture($donnees);
		}
    
		return $factures;
	}
	// Si client est défini et annee est défini sur date, on verifie que c'est une date au format 0000-00-00 uniquement et on liste toutes les factures de la date donnée pour id_client
	else if ($id_client != 0 && is_int($id_client) && preg_match("/^[0-9]{4}(-)(0[1-9]|1[0-2])(-)(0[1-9]|[1-2][0-9]|3[0-1])$/", $annee)) {
		$factures = [];
		$this->_annee = (string)$annee;
    
		$q = $this->_pdo->prepare("SELECT num, idclient, date, somme FROM factures WHERE idclient = :id_client AND date = :date ORDER BY date ASC");
		$q->execute([':id_client' => $id_client, ':date' => $annee]);
    
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$factures[] = new Facture($donnees);
		}
    
		return $factures;
	}
  }
  
  public function update(Facture $facture)
  {
    $q = $this->_pdo->prepare('UPDATE factures SET somme = :somme WHERE num = :num');
    
    $q->bindValue(':somme', $facture->somme(), PDO::PARAM_INT);
    $q->bindValue(':num', $facture->num(), PDO::PARAM_INT);
    
    $q->execute();
  }
  
  public function setDb(PDO $pdo)
  {
    $this->_pdo = $pdo;
  }
  
  /* public function getSommesAnnee($id_client, $annnee){
	  $sommes = []
	  
	  
  } */
  
}