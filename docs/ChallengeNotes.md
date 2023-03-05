Start: 11:00

1) Einrichten Umgebung & Funktions Test 
    - http://localhost:8080/api zeigt Api Platform aber ohne CSS Ursache der public/bundles existiert nicht
    - bin/console assets:install public 
2) Entities erstellen mit symfony/maker-bundle
3) PHPstan und PHPcs
   - einige phpstan rulset erstellt als fix für erkannte Fehler die aus PHPstan Version Bugs auftreten und gewollte
     Zustände wie das die Entities IDs nur lesbar sind
4) Entities verfügbar gemacht für die API-Platform
   - beim Testen sind folgende Fehler aufgekommen:
     - bei `curl -X GET "http://localhost:8080/api/adressen?page=1" -H  "accept: application/ld+json"`
       Fehler:
      ``json
       {
       "@context": "/api/contexts/Error",
       "@type": "hydra:Error",
       "hydra:title": "An error occurred",
       "hydra:description": "An exception occurred while executing 'SELECT t0.kuerzel AS kuerzel_1, t0.name AS name_2 FROM public.bundesland t0 WHERE t0.kuerzel = ?' with params [\"BE\"]:\n\nSQLSTATE[42501]: Insufficient privilege: 7 ERROR:  permission denied for table bundesland",
       ....
       }
      ``
       Fix siehe Punkt 8
       ``json
       {
       "@context": "/api/contexts/Adresse",
       "@id": "/api/adressen",
       "@type": "hydra:Collection",
       "hydra:member": [
       {
       "@id": "/api/adressen/1",
       "@type": "Adresse",
       "id": 1,
       "strasse": "Invalidenstr. 23",
       "plz": "10115",
       "ort": "Berlin",
       "bundesland": {
       "kuerzel": "BE",
       "name": "Berlin",
       "__initializer__": null,
       "__cloner__": null,
       "__isInitialized__": true
       }
       },
       ....
       }
       ``
       - bei `curl -X GET "http://localhost:8080/api/tbl_kundens?page=1" -H  "accept: application/ld+json"`
         Fehler:
         ``json
         {
         "@context": "/api/contexts/Error",
         "@type": "hydra:Error",
         "hydra:title": "An error occurred",
         "hydra:description": "A circular reference has been detected when serializing the object of class \"Proxies\\__CG__\\App\\Entity\\Vermittler\" (configured limit: 1).",
         ....
         }
         ``
         Fix durch Vermittler Entity für Api-Platform verfügbar machen.

         ``json
         {
         "@context": "/api/contexts/TblKunden",
         "@id": "/api/tbl_kundens",
         "@type": "hydra:Collection",
         "hydra:member": [
             {
             "@id": "/api/tbl_kundens/05EEC268",
             "@type": "TblKunden",
             "id": "05EEC268",
             "name": "von Burgenstaedt",
             "vorname": "Max",
             "geburtsdatum": "1999-12-15T00:00:00+00:00",
             "geloescht": 0,
             "vermittlerId": "/api/vermittlers/4000"
             },
            ....
         }    
         ``
     - bei `curl -X GET "http://localhost:8080/api/users?page=1" -H  "accept: application/ld+json"`
       Fehler:
       ``json
       {
       "@context": "/api/contexts/Error",
       "@type": "hydra:Error",
       "hydra:title": "An error occurred",
       "hydra:description": "The property \"App\\Entity\\User::$kundenid\" is not readable because it is typed \"App\\Entity\\TblKunden\". You should initialize it or declare a default value instead.",
       ....
       }
       ``
      Fix wurde anscheind durch die Groups behoben aus Punkt 5
       ``json
       {
       "@context": "/api/contexts/User",
       "@id": "/api/users",
       "@type": "hydra:Collection",
       "hydra:member": [
       {
         "@id": "/api/users/1",
         "@type": "User",
         "email": "kari@example.com",
         "aktiv": 1,
         "last_login": "2023-03-05T08:09:20+00:00"
       },
       ....
       }    
       ``
5) Einfügen in User Entity der Einschränkung was Sichtbar ist durch Groups, so das Passwort nicht mehr angezeigt wird und nur die drei Elemente aus "Erwartetes JSON Format" angezeigt wird
6) Einfügen in TblKunden & Adressen Entity "collectionOperations" und "itemOperations" das der Uri-Path der Anforderungen aus "Folgende Ressourcen werden erwartet" angezeigt wird.
7) Erweitern in TblKunden Entity "itemOperations" von Controller Klassen für die "Sub-Ressourcen" Anforderung
    - bei `curl -X GET "http://localhost:8080/api/kunden/05EEC268/adressen" -H  "accept: application/ld+json"` gab es den selben Fehler wie bei Adressen.
      Fehler:
      ``json
      {
      "@context": "/api/contexts/Error",
      "@type": "hydra:Error",
      "hydra:title": "An error occurred",
      "hydra:description": "An exception occurred while executing 'SELECT t0.kuerzel AS kuerzel_1, t0.name AS name_2 FROM public.bundesland t0 WHERE t0.kuerzel = ?' with params [\"BB\"]:\n\nSQLSTATE[42501]: Insufficient privilege: 7 ERROR:  permission denied for table bundesland",
      ....
      }
      ``
      Fix siehe Punkt 8
      ``json
      {
      "@context": "/api/contexts/TblKunden",
      "@id": "/api/kunden",
      "@type": "hydra:Collection",
      "hydra:member": [
      {
      "kundeId": {
      "@id": "/api/kunden/05EEC268",
      "@type": "TblKunden",
      "id": "05EEC268",
      "name": "von Burgenstaedt",
      "vorname": "Max",
      "firma": null,
      "geburtsdatum": "1999-12-15T00:00:00+00:00",
      "geloescht": 0,
      "geschlecht": null,
      "email": null,
      "vermittlerId": "/api/vermittlers/4000"
      },
      ....
      }
      ``
    - Bei `curl -X GET "http://localhost:8080/api/kunden/3/adressen/{adress_id}/details" -H  "accept: application/ld+json"` konnte per APi-Platform keine Lösung gefunden werden
      wie ein Zweiter Parameter bereitgestellt wurde. Daher Test per Curl Konsole `curl -X GET http://localhost:8080/api/kunden/05EEC268/adressen/6/details?page=1 -H  "accept: application/json"`.
      Respone:
      ``json
      {
      "kundeId": {
      "id": "05EEC268",
      "name": "von Burgenstaedt",
      "vorname": "Max",
      "firma": null,
      "geburtsdatum": "1999-12-15T00:00:00+00:00",
      "geloescht": 0,
      "geschlecht": null,
      "email": null,
      "vermittlerId": "\/api\/vermittlers\/4000"
      },
      "adresseId": {
      "id": 6,
      "strasse": "Müllerdamm Allee 178",
      "plz": "11447",
      "ort": "Burgenstaedt",
      "bundesland": {
      "kuerzel": "BB",
      "name": "Brandenburg",
      "__initializer__": null,
      "__cloner__": null,
      "__isInitialized__": true
      }
      },
      "geschaeftlich": false,
      "rechnungsadresse": true,
      "geloescht": false
      }
      ``


8) Recherche was der Fehler sein kann von "permission denied for table bundesland"
   - Fix durch Einfügen folgender Zeilen in das SQL Statement beim erstellen der Datenbank
   ``SQL
     GRANT ALL ON SCHEMA public TO sadmin WITH GRANT OPTION;
     GRANT USAGE ON SCHEMA public TO web;
     ALTER DEFAULT PRIVILEGES IN SCHEMA public
     GRANT INSERT, SELECT, UPDATE, DELETE, TRUNCATE ON TABLES
     TO web;
   ``

9) Einschränken der Sichtbarkeit von Vermittler da dieser nun in der Api Platform sichtbar ist auf das Notwendigste, bis bessere Lösung gefunden ist.


Fazit:
- Login und JWT konnten nicht mehr umgesetzt werden
- Passwort Bedingungen konnten nicht mehr umgesetzt werden
- Formatierung des "Erwartetes JSON Format" konnte nicht vollständig umgesetzt werden
- Das nur Informationen für den angemeldeten Vermittler angezeigt werden konnte nicht mehr umgesetzt werden

Diese Erweiterungen müssten dann noch nachgearbeitet werden.

Ende 13:57