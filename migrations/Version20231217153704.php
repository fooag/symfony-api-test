<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231217153704 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE std.adresse1_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE std.kunde_adresse1_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE std.tbl_kunden1_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE std.vermittler1_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE std.adresse1_address_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE sec.user1_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE sec.vermittler_user1_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE sec.vermittler_user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('ALTER TABLE std.adresse ALTER adresse_id TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE std.adresse ALTER bundesland TYPE VARCHAR(2)');
        $this->addSql('ALTER TABLE bundesland ALTER kuerzel TYPE VARCHAR(2)');
        $this->addSql('ALTER TABLE std.kunde_adresse ALTER kunde_id SET DEFAULT \'upper("left"((gen_random_uuid())::text, 8))\'');
        $this->addSql('ALTER TABLE std.kunde_adresse ALTER adresse_id TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE std.kunde_adresse ADD CONSTRAINT FK_7097EEC84DE7DC5C FOREIGN KEY (adresse_id) REFERENCES std.adresse (adresse_id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE std.kunde_adresse ADD CONSTRAINT FK_7097EEC89D4738BC FOREIGN KEY (kunde_id) REFERENCES std.tbl_kunden (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_7097EEC84DE7DC5C ON std.kunde_adresse (adresse_id)');
        $this->addSql('CREATE INDEX IDX_7097EEC89D4738BC ON std.kunde_adresse (kunde_id)');
        $this->addSql('ALTER TABLE std.kunde_adresse ADD PRIMARY KEY (adresse_id, kunde_id)');
        $this->addSql('ALTER TABLE std.tbl_kunden ALTER geschlecht TYPE VARCHAR(10)');
        $this->addSql('CREATE SEQUENCE sec.user_id_seq');
        $this->addSql('SELECT setval(\'sec.user_id_seq\', (SELECT MAX(id) FROM sec."user"))');
        $this->addSql('ALTER TABLE sec."user" ALTER id SET DEFAULT nextval(\'sec.user_id_seq\')');
        $this->addSql('ALTER TABLE sec."user" ALTER kundenid SET DEFAULT \'upper("left"((gen_random_uuid())::text, 8))\'');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C235CF9CE7927C74 ON sec."user" (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE sec.vermittler_user_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE std.adresse1_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE std.kunde_adresse1_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE std.tbl_kunden1_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE std.vermittler1_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE std.adresse1_address_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE sec.user1_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE sec.vermittler_user1_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('ALTER TABLE std.tbl_kunden ALTER geschlecht TYPE VARCHAR(8)');
        $this->addSql('ALTER TABLE std.adresse ALTER adresse_id TYPE INT');
        $this->addSql('ALTER TABLE std.adresse ALTER bundesland TYPE CHAR(2)');
        $this->addSql('ALTER TABLE std.kunde_adresse DROP CONSTRAINT FK_7097EEC84DE7DC5C');
        $this->addSql('ALTER TABLE std.kunde_adresse DROP CONSTRAINT FK_7097EEC89D4738BC');
        $this->addSql('DROP INDEX IDX_7097EEC84DE7DC5C');
        $this->addSql('DROP INDEX IDX_7097EEC89D4738BC');
        $this->addSql('DROP INDEX "primary"');
        $this->addSql('ALTER TABLE std.kunde_adresse ALTER adresse_id TYPE INT');
        $this->addSql('ALTER TABLE std.kunde_adresse ALTER kunde_id DROP DEFAULT');
        $this->addSql('ALTER TABLE public.bundesland ALTER kuerzel TYPE CHAR(2)');
        $this->addSql('DROP INDEX UNIQ_C235CF9CE7927C74');
        $this->addSql('ALTER TABLE sec."user" ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE sec."user" ALTER kundenid DROP DEFAULT');
    }
}
