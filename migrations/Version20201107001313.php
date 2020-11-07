<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201107001313 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE std.adresse_adresse_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE std.tbl_kunden_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE std.vermittler_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE std.adresse (adresse_id INT NOT NULL, bundesland VARCHAR(2) NOT NULL, strasse TEXT NOT NULL, plz VARCHAR(10) NOT NULL, ort TEXT NOT NULL, PRIMARY KEY(adresse_id))');
        $this->addSql('CREATE INDEX IDX_40A5D758593BEEEC ON std.adresse (bundesland)');
        $this->addSql('CREATE TABLE bundesland (kuerzel VARCHAR(2) NOT NULL, name TEXT NOT NULL, PRIMARY KEY(kuerzel))');
        $this->addSql('CREATE TABLE std.kunde_adresse (kunde_id VARCHAR(36) NOT NULL, adresse_id INT NOT NULL, geschaeftlich BOOLEAN DEFAULT \'false\' NOT NULL, rechnungsadresse BOOLEAN DEFAULT NULL, geloescht BOOLEAN DEFAULT \'false\' NOT NULL, PRIMARY KEY(kunde_id))');
        $this->addSql('CREATE TABLE std.tbl_kunden (id VARCHAR(36) NOT NULL, vermittler_id INT NOT NULL, name VARCHAR(255) NOT NULL, vorname VARCHAR(255) NOT NULL, firma TEXT DEFAULT NULL, geburtsdatum DATE NOT NULL, geloescht INT DEFAULT NULL, email TEXT NOT NULL, geschlecht VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_680E0AD091EC85B5 ON std.tbl_kunden (vermittler_id)');
        $this->addSql('CREATE TABLE sec."user" (id SERIAL NOT NULL, kunden_id VARCHAR(36) NOT NULL, email VARCHAR(200) NOT NULL, passwd VARCHAR(200) NOT NULL, aktiv INT DEFAULT 1 NOT NULL, last_login TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C235CF9C87488AF8 ON sec."user" (kunden_id)');
        $this->addSql('CREATE TABLE std.vermittler (id INT NOT NULL, nummer VARCHAR(36) NOT NULL, vorname VARCHAR(255) NOT NULL, nachname VARCHAR(255) NOT NULL, firma VARCHAR(255) NOT NULL, geloescht BOOLEAN DEFAULT \'false\' NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE sec.vermittler_user (id SERIAL NOT NULL, vermittler_id INT NOT NULL, email VARCHAR(200) NOT NULL, passwd VARCHAR(60) NOT NULL, aktiv INT DEFAULT 1 NOT NULL, last_login TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_222EB99D91EC85B5 ON sec.vermittler_user (vermittler_id)');
        $this->addSql('ALTER TABLE std.adresse ADD CONSTRAINT FK_40A5D758593BEEEC FOREIGN KEY (bundesland) REFERENCES bundesland (kuerzel) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE std.tbl_kunden ADD CONSTRAINT FK_680E0AD091EC85B5 FOREIGN KEY (vermittler_id) REFERENCES std.vermittler (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sec."user" ADD CONSTRAINT FK_C235CF9C87488AF8 FOREIGN KEY (kunden_id) REFERENCES std.tbl_kunden (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sec.vermittler_user ADD CONSTRAINT FK_222EB99D91EC85B5 FOREIGN KEY (vermittler_id) REFERENCES std.vermittler (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE std.adresse DROP CONSTRAINT FK_40A5D758593BEEEC');
        $this->addSql('ALTER TABLE sec."user" DROP CONSTRAINT FK_C235CF9C87488AF8');
        $this->addSql('ALTER TABLE std.tbl_kunden DROP CONSTRAINT FK_680E0AD091EC85B5');
        $this->addSql('ALTER TABLE sec.vermittler_user DROP CONSTRAINT FK_222EB99D91EC85B5');
        $this->addSql('DROP SEQUENCE std.adresse_adresse_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE std.tbl_kunden_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE std.vermittler_id_seq CASCADE');
        $this->addSql('DROP TABLE std.adresse');
        $this->addSql('DROP TABLE bundesland');
        $this->addSql('DROP TABLE std.kunde_adresse');
        $this->addSql('DROP TABLE std.tbl_kunden');
        $this->addSql('DROP TABLE sec."user"');
        $this->addSql('DROP TABLE std.vermittler');
        $this->addSql('DROP TABLE sec.vermittler_user');
    }
}
