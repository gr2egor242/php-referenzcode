<?php

class Token
{
	private $verbindung;
    private $tabellenName = array(
		"erstTabelle" => "token",
        "hilfsTabelle" => "adressen"
    );
	public $id;
	public $wert;
	private $ip_addr;

	public function __construct( $datenbankVerbindung )
	{
		$this->verbindung = $datenbankVerbindung;
	}

	function erstelleToken()
	{
		$anfrage = "INSERT INTO ". $this->tabellenName["erstTabelle"] ." SET wert=:wert, ip_addr=:ip_addr";
		$aufruf = $this->verbindung->prepare( $anfrage );

		$this->ip_addr = $_SERVER['REMOTE_ADDR'];

		$aufruf->bindParam( ":wert", $this->wert );
		$aufruf->bindParam( ":ip_addr", $this->ip_addr );

		if ( $aufruf->execute() )
			return true;
		else
			return false;
	}

	function sucheToken()
	{
		$anfrage = "SELECT id FROM ". $this->tabellenName["erstTabelle"] ." WHERE wert='". $this->wert ."'";
		$aufruf = $this->verbindung->prepare( $anfrage );

		if ( $aufruf->execute() )
		{
			if( $zeile = $aufruf->fetch( PDO::FETCH_ASSOC ) )
			{
				$this->id = $zeile['id'];
				if (empty( $this->id ))
					return false;
				else
					return true;
			}
			else
				return false;
		}
		else
			return false;
	}
    
    function sucheVerbrauchtenToken()
    {
        $this->wert = htmlspecialchars(strip_tags( $this->wert ));
        $anfrage = "SELECT t.id AS id FROM ". $this->tabellenName["erstTabelle"] ." t, ". $this->tabellenName["hilfsTabelle"] ." a WHERE t.wert='". $this->wert ."' AND t.id = a.token_id";
        $aufruf = $this->verbindung->prepare( $anfrage );

        if ( $aufruf->execute() )
        {
            if ($zeile = $aufruf->fetch( PDO::FETCH_ASSOC ))
            {
                if (isset( $zeile['id'] ))
					return true;
                else
					return false;
            }
            else
                return false;
        }
        else
            return false;
    }  
    
}	
?>