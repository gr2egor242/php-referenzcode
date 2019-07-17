<?php

class Adressen
{
	private $verbindung;
    private $tabellenName = array(
        "erstTabelle" => "adressen"
    );
    public $id;
    public $wert;
    public $token_id;
	private $ip_addr;
	
    public function __construct( $datenbankVerbindung )
    {
		$this->verbindung = $datenbankVerbindung;
	}

    function erstelleAdresse()
    {
		$anfrage = "INSERT INTO ". $this->tabellenName["erstTabelle"] ." SET wert=:wert, token_id=:token_id, ip_addr=:ip_addr";
		$aufruf = $this->verbindung->prepare( $anfrage );

		$this->ip_addr = $_SERVER['REMOTE_ADDR'];

        $aufruf->bindParam( ":wert", $this->wert );
        $aufruf->bindParam( ":token_id", $this->token_id );
		$aufruf->bindParam( ":ip_addr", $this->ip_addr );

        if ( $aufruf->execute() )
			return true;
        else
		    return false;
	}

    function sucheVorhandeneAdresse()
    {
        $anfrage = "SELECT id FROM ". $this->tabellenName["erstTabelle"] ." WHERE wert='". $this->wert ."'";
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