<?php
    header("Access-Control-Allow-Methods: POST");
    header("Content-type: application/json; charset=utf-8");

    include_once '../konfiguration.php';
    include_once '../objekte/Datenbank.php';
    include_once '../objekte/Token.php';
    include_once '../objekte/Adressen.php';

    $datenbank = new Datenbank();

    if (!( $datenbankVerbindung = $datenbank->erstelleVerbindung() ))
        exit('{
    "status" : "error",
    "nachricht" : "Datenbankverbindungsfehler"
}');

    $token = new Token( $datenbankVerbindung );
    $adressen = new Adressen( $datenbankVerbindung );

    // Die Aufrufvalidierung

    if (isset( $_POST['anfrage'] ))
        $anfrage = $_POST['anfrage'];
    else
        exit('{
    "status" : "error",
    "nachricht" : "Aufruf ohne Anfrage empfangen."
}');

    if (isset( $anfrage['token'] ))
        $token->wert = trim(htmlspecialchars(strip_tags( $anfrage['token'] )));
    else 
        exit('{
    "status" : "error",
    "nachricht" : "Anfrage ohne Token empfangen."
}');

    if ( $token->sucheToken() )
        $adressen->token_id = $token->id;
    else
        exit('{
    "status" : "error",
    "nachricht" : "Dieser Token ist nicht vorhanden.",
    "token" : "'. $token->wert .'"
}');

    if ( $token->sucheVerbrauchtenToken() )
        exit('{
    "status" : "error",
    "nachricht" : "Dieser Token ist bereits verbraucht.",
    "token" : "'. $token->wert .'"
}');

    if (empty( $anfrage['adresse'] ))
        exit('{
    "status" : "error",
    "nachricht" : "Anfrage ohne e-Mail Adresse empfangen."
}');

    elseif (filter_var( $anfrage['adresse'], FILTER_VALIDATE_EMAIL ))
        $adressen->wert = trim(htmlspecialchars(strip_tags( $anfrage['adresse'] )));
    else
        exit('{
    "status" : "error",
    "nachricht" : "Anfrage mit ungültiger e-Mail Adresse empfangen."
}'); 

    // Der Datenbankeintrag

    if ( $adressen->sucheVorhandeneAdresse() )
        exit('{
    "status" : "error",
    "nachricht" : "Diese Adresse ist bereits vorhanden.",
    "token" : "'. $token->wert .'"
}');
    elseif ( $adressen->erstelleAdresse() )
        exit('{
    "status" : "ok",
    "token" : "'. $token->wert .'"
}');
    else
        die("divide");

?>