<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210322092206 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, organisme_id INT DEFAULT NULL, nom_societe VARCHAR(255) NOT NULL, adresse_rue VARCHAR(255) NOT NULL, adresse_cp VARCHAR(255) NOT NULL, adresse_ville VARCHAR(255) NOT NULL, siret VARCHAR(255) NOT NULL, representant_nom VARCHAR(255) NOT NULL, representant_prenom VARCHAR(255) NOT NULL, representant_mail VARCHAR(255) NOT NULL, representant_telephone VARCHAR(255) NOT NULL, INDEX IDX_C74404555DDD38F5 (organisme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dates (id INT AUTO_INCREMENT NOT NULL, planif_id INT DEFAULT NULL, date_annee VARCHAR(255) NOT NULL, date_mois VARCHAR(255) NOT NULL, date_jour VARCHAR(255) NOT NULL, heure_debut_matin VARCHAR(255) DEFAULT NULL, minute_debut_matin VARCHAR(255) DEFAULT NULL, heure_fin_matin VARCHAR(255) DEFAULT NULL, minute_fin_matin VARCHAR(255) DEFAULT NULL, heure_debut_am VARCHAR(255) DEFAULT NULL, minute_debut_am VARCHAR(255) DEFAULT NULL, heure_fin_am VARCHAR(255) DEFAULT NULL, minute_fin_am VARCHAR(255) DEFAULT NULL, INDEX IDX_AB74C91E9DBEEA35 (planif_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formateur (id INT AUTO_INCREMENT NOT NULL, organisme_id INT DEFAULT NULL, filename VARCHAR(255) NOT NULL, formateur_nom VARCHAR(255) NOT NULL, formateur_prenom VARCHAR(255) NOT NULL, formateur_mail VARCHAR(255) NOT NULL, formateur_phone VARCHAR(255) NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_ED767E4F5DDD38F5 (organisme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation (id INT AUTO_INCREMENT NOT NULL, organisme_id INT DEFAULT NULL, nom_formation VARCHAR(255) NOT NULL, public LONGTEXT NOT NULL, INDEX IDX_404021BF5DDD38F5 (organisme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE module_formation (id INT AUTO_INCREMENT NOT NULL, formation_id INT DEFAULT NULL, nom_module VARCHAR(255) NOT NULL, nombre_heure DOUBLE PRECISION NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_1A213E775200282E (formation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE objectif (id INT AUTO_INCREMENT NOT NULL, formation_id INT DEFAULT NULL, nom_objectif LONGTEXT NOT NULL, INDEX IDX_E2F868515200282E (formation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE organisme (id INT AUTO_INCREMENT NOT NULL, filename VARCHAR(255) NOT NULL, nom_of VARCHAR(255) NOT NULL, adresse_voie VARCHAR(255) NOT NULL, adresse_cp VARCHAR(255) NOT NULL, adresse_ville VARCHAR(255) NOT NULL, declaration_activite VARCHAR(255) NOT NULL, siret VARCHAR(255) NOT NULL, representant_nom VARCHAR(255) NOT NULL, representant_prenom VARCHAR(255) NOT NULL, updated_at DATETIME DEFAULT NULL, telephone VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, capital VARCHAR(255) NOT NULL, code_ape VARCHAR(255) NOT NULL, tva_fr VARCHAR(255) NOT NULL, rcp VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE planif (id INT AUTO_INCREMENT NOT NULL, programme_id INT DEFAULT NULL, client_id INT DEFAULT NULL, formateur_id INT DEFAULT NULL, organisme_id INT DEFAULT NULL, adresse VARCHAR(255) NOT NULL, code_postal VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, etage VARCHAR(255) NOT NULL, salle VARCHAR(255) NOT NULL, prix VARCHAR(255) NOT NULL, INDEX IDX_371F54E162BB7AEE (programme_id), INDEX IDX_371F54E119EB6921 (client_id), INDEX IDX_371F54E1155D8F51 (formateur_id), INDEX IDX_371F54E15DDD38F5 (organisme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prerequi (id INT AUTO_INCREMENT NOT NULL, formation_id INT DEFAULT NULL, nom_prerequi LONGTEXT NOT NULL, INDEX IDX_5643F3A45200282E (formation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stagiaire (id INT AUTO_INCREMENT NOT NULL, planif_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, qualite VARCHAR(255) NOT NULL, INDEX IDX_4F62F7319DBEEA35 (planif_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, organisme_id INT DEFAULT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, role_admin TINYINT(1) NOT NULL, INDEX IDX_8D93D6495DDD38F5 (organisme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C74404555DDD38F5 FOREIGN KEY (organisme_id) REFERENCES organisme (id)');
        $this->addSql('ALTER TABLE dates ADD CONSTRAINT FK_AB74C91E9DBEEA35 FOREIGN KEY (planif_id) REFERENCES planif (id)');
        $this->addSql('ALTER TABLE formateur ADD CONSTRAINT FK_ED767E4F5DDD38F5 FOREIGN KEY (organisme_id) REFERENCES organisme (id)');
        $this->addSql('ALTER TABLE formation ADD CONSTRAINT FK_404021BF5DDD38F5 FOREIGN KEY (organisme_id) REFERENCES organisme (id)');
        $this->addSql('ALTER TABLE module_formation ADD CONSTRAINT FK_1A213E775200282E FOREIGN KEY (formation_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE objectif ADD CONSTRAINT FK_E2F868515200282E FOREIGN KEY (formation_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE planif ADD CONSTRAINT FK_371F54E162BB7AEE FOREIGN KEY (programme_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE planif ADD CONSTRAINT FK_371F54E119EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE planif ADD CONSTRAINT FK_371F54E1155D8F51 FOREIGN KEY (formateur_id) REFERENCES formateur (id)');
        $this->addSql('ALTER TABLE planif ADD CONSTRAINT FK_371F54E15DDD38F5 FOREIGN KEY (organisme_id) REFERENCES organisme (id)');
        $this->addSql('ALTER TABLE prerequi ADD CONSTRAINT FK_5643F3A45200282E FOREIGN KEY (formation_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE stagiaire ADD CONSTRAINT FK_4F62F7319DBEEA35 FOREIGN KEY (planif_id) REFERENCES planif (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6495DDD38F5 FOREIGN KEY (organisme_id) REFERENCES organisme (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE planif DROP FOREIGN KEY FK_371F54E119EB6921');
        $this->addSql('ALTER TABLE planif DROP FOREIGN KEY FK_371F54E1155D8F51');
        $this->addSql('ALTER TABLE module_formation DROP FOREIGN KEY FK_1A213E775200282E');
        $this->addSql('ALTER TABLE objectif DROP FOREIGN KEY FK_E2F868515200282E');
        $this->addSql('ALTER TABLE planif DROP FOREIGN KEY FK_371F54E162BB7AEE');
        $this->addSql('ALTER TABLE prerequi DROP FOREIGN KEY FK_5643F3A45200282E');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C74404555DDD38F5');
        $this->addSql('ALTER TABLE formateur DROP FOREIGN KEY FK_ED767E4F5DDD38F5');
        $this->addSql('ALTER TABLE formation DROP FOREIGN KEY FK_404021BF5DDD38F5');
        $this->addSql('ALTER TABLE planif DROP FOREIGN KEY FK_371F54E15DDD38F5');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6495DDD38F5');
        $this->addSql('ALTER TABLE dates DROP FOREIGN KEY FK_AB74C91E9DBEEA35');
        $this->addSql('ALTER TABLE stagiaire DROP FOREIGN KEY FK_4F62F7319DBEEA35');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE dates');
        $this->addSql('DROP TABLE formateur');
        $this->addSql('DROP TABLE formation');
        $this->addSql('DROP TABLE module_formation');
        $this->addSql('DROP TABLE objectif');
        $this->addSql('DROP TABLE organisme');
        $this->addSql('DROP TABLE planif');
        $this->addSql('DROP TABLE prerequi');
        $this->addSql('DROP TABLE stagiaire');
        $this->addSql('DROP TABLE user');
    }
}
