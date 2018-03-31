<?php
	/**	CREATE TABLE clients (
			id int(11) NOT NULL,
			nom varchar(255) NOT NULL,
			prenom varchar(255) NOT NULL
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=43 ;


		ALTER TABLE clients
		ADD PRIMARY KEY (id), ADD KEY id (id);

		ALTER TABLE clients
		MODIFY id int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
	*/
class Client
{
    // déclaration d'une propriété
    private $_id;
	private $_nom;
	private $_prenom;

    public function __construct(array $donnees)
		{
			$this->hydrate($donnees);
		}
		
		public function hydrate(array $donnees)
		{
			foreach ($donnees as $key => $value)
			{
				$method = 'set'.ucfirst($key);
				if (method_exists($this, $method))
				{
					$this->$method($value);
				}
			}
		}
		
		// GETTERS //
		public function id(){
			return $this->_id;
		}
	 	public function nom(){
			return $this->_nom;
		}
		public function prenom(){
			return $this->_prenom;
		}

		//  SETTERS  //
		public function setId($id)
		{
			$this->_id = $id;
		}
		public function setNom($nom)
		{
			$this->_nom = $nom;
		}
		public function setPrenom($prenom)
		{
			$this->_prenom = $prenom;
		}
		
	}
?>