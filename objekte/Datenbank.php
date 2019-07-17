<?php

class Datenbank
{	
	// Datenbankkonfiguration Anfang
	private $host = "";
	private $datenbankName = "";
	private $benutzerName = "";
    private $passwort = "";
	// Datenbankkonfiguration Ende
	
	public $verbindung;

	public function erstelleVerbindung()
	{
		$this->verbindung = null;
		try {
			$this->verbindung = new PDO("mysql:host=". $this->host .";dbname=". $this->datenbankName, $this->benutzerName, $this->passwort);
			$this->verbindung->exec("set names utf8");

		} catch( PDOException $ausnahme ) {
			return false;
		}
		return $this->verbindung;
	}
}

?>
