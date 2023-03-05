Start: 11:00

1) Einrichten Umgebung & Funktions Test 
    - http://localhost:8080/api zeigt Api Platform aber ohne CSS Ursache der public/bundles existiert nicht
    - bin/console assets:install public 
2) Entities erstellen mit symfony/maker-bundle
3) PHPstan und PHPcs
   - einige phpstan rulset erstellt als fix für erkannte Fehler die aus PHPstan Version Bugs auftreten und gewollte
     Zustände wie das die Entities IDs nur lesbar sind
4) Entities verfügbar gemacht für die API-Platform