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
       Fix noch offen
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