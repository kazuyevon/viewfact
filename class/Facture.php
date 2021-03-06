<?php
	/**		CREATE TABLE factures (
				num int(11) NOT NULL,
				idclient int(11) NOT NULL,
				`date` date NOT NULL,
				somme double NOT NULL
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8714 ;


			ALTER TABLE factures
			ADD PRIMARY KEY (num), ADD KEY num (num), ADD KEY num_2 (num);

			ALTER TABLE factures
			MODIFY num int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
	*/

class Facture 
{
		private $_num;
		private $_id_client;
		private $_date;
		private $_somme;
		
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
		public function num(){
			return $this->_num;
		}
	 	public function id_client(){
			return $this->_id_client;
		}
		public function somme(){
			return $this->_somme;
		}
		public function date(){
			return $this->_date;
		}

		//  SETTERS  //
		public function setNum($num)
		{
			$this->_num = $num;
		}
		public function setIdClient($id_client)
		{
			$this->_id_client = $id_client;
		}
		public function setSomme($somme)
		{
			$this->_somme = $somme;
		}
		public function setDate($date)
		{
			$this->_date = $date;
		}
	}
?>