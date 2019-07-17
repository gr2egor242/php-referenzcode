<?php
    header("Access-Control-Allow-Methods: GET");
    header("Content-type: application/json; charset=utf-8");

    include_once '../konfiguration.php';
    include_once '../objekte/Datenbank.php';
    include_once '../objekte/Token.php';
    
    $datenbank = new Datenbank();

    if (!( $datenbankVerbindung = $datenbank->erstelleVerbindung() )) {
        exit('{
    "status" : "error",
    "nachricht" : "Datenbankverbindungsfehler"
}');
    }
    
    $token = new Token( $datenbankVerbindung );
    $token->wert = trim(bin2hex( openssl_random_pseudo_bytes(64) ));

    if ( $token->erstelleToken() )
        exit('{
    "status" : "ok",
    "wert" : "'. $token->wert .'"
}');
    else
        exit('{
    "status" : "error",
    "nachricht" : "Token konnte nicht erstellt werden."
}');

?>