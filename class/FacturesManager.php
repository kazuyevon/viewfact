<?php
include 'class/Facture.php';
class FacturesManager
{
  private $_pdo; // Instance de PDO
  private $_annee;
  
  public function __construct($pdo)
  {
    $this->setDb($pdo);
  }
  
  public function add(Facture $facture)
  {
    $q = $this->_pdo->prepare('INSERT INTO factures(date) VALUES(:date)');
    $q->bindValue(':date', $facture->date());
    $q->execute();
    
    $facture->hydrate([
      'num' => $this->_pdo->lastInsertId(),
      'somme' => 0,
	  'date' => date("Y-m-d"),
    ]);
  }
  
  public function count()
  {
    return $this->_pdo->query('SELECT COUNT(*) FROM factures')->fetchColumn();
  }
  
  public function nbFactAnnee($id_client, $annee)
  {
	$this->_annee = $annee;
	$nombre = $this->_pdo->query('SELECT COUNT(*) FROM factures WHERE id_client = '.$id_client.' AND YEAR(date) = '.$annee)->fetchColumn();
	return $nombre;
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
  
  public function getFactures($info) //par num ou par date
  {
    if (is_int($info))
    {
      $q = $this->_pdo->query('SELECT num, id_client, date, somme FROM factures WHERE num = '.$info);
      $donnees = $q->fetch(PDO::FETCH_ASSOC);
      
      return new Facture($donnees);
    }
    else
    {
      $q = $this->_pdo->prepare('SELECT num, id_client, date, somme FROM factures WHERE date = :date');
      $q->execute([':date' => $info]);
    
      return new Facture($q->fetch(PDO::FETCH_ASSOC));
    }
  }
  
  public function getListAll()
  {
    $factures = [];
    
    $q = $this->_pdo->prepare('SELECT num, id_client, date, somme FROM factures ORDER BY date');
    
    while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
    {
      $factures[] = new Facture($donnees);
    }
    
    return $factures;
  }
  
  public function getList($id_client)
  {
    $factures = [];
    
    $q = $this->_pdo->prepare('SELECT num, id_client, date, somme FROM factures WHERE id_client = :id_client ORDER BY date');
    $q->execute([':id_client' => $id_client]);
    
    while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
    {
      $factures[] = new Facture($donnees);
    }
    
    return $factures;
  }
  
   public function getListAnnee($id_client, $annee)
  {
    $factures = [];
	$this->_annee = (string)$annee;
    
	$q = $this->_pdo->prepare("SELECT num, id_client, date, somme FROM factures WHERE id_client = :id_client AND YEAR(date) = :annee ORDER BY date ASC");
	$q->execute([':id_client' => $id_client, ':annee' => $annee]);
    
    while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
    {
      $factures[] = new Facture($donnees);
    }
    
    return $factures;
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