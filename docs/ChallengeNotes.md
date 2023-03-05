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
      Fix noch offen