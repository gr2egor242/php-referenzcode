/Hausaufgabe
----/objekte                          
    ----/Datenbank.php              Datenbankkonfiguration, erstelleVerbindung()
    ----/Token.php                  erstelleToken(), sucheToken(), sucheVerbrauchtenToken()
    ----/Adressen.php               sucheVorhandeneAdresse(), erstelleAdresse()
----/methoden
    ----/erstelleToken.php          GET Endpunkt
    ----/erstelleAdresse.php        POST Endpunkt
----/index.html                     HTML/JavaScript Seite mit Ajax zu den Endpunkten
----/tabellenErstellen.sql          MySQL Skript zum Erstellen der Tabellen
----/konfiguration.php              dummy Konfigurationsdatei
----/README.txt                     diese Datei

* Getestet unter PHP 7.3 und MariaDB 10.3
* Funktioniert sowohl als auch mit http(s)
* Braucht Anschluss ans Internet (CDN)

Installation:
    1. Dieses Archiv mit unveränderter Dateistruktur in einem Webserververzeichnis auspacken.
    1. Datenbanktabellen mittels "tabellenErstellen.sql" Skript erstellen.
    2. Parameter $host, $datenbankName, $benutzerName und $passwort in "Datenbank.php" anpassen.
    3. Seite index.html auf dem Webserver mittels Browser aufrufen.