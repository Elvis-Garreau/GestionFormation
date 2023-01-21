<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210421092834 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE enquete_froid (id INT AUTO_INCREMENT NOT NULL, planif_id INT DEFAULT NULL, stagiaire_id INT DEFAULT NULL, duree_stage INT NOT NULL, support_formation INT NOT NULL, formateur_clair INT NOT NULL, formateur_adapte INT NOT NULL, programme_clair INT NOT NULL, programme_adapte INT NOT NULL, objectif_formation INT NOT NULL, compris_objectif INT NOT NULL, exercices_pertinents INT NOT NULL, competences_ameliorees INT NOT NULL, condition_accueil INT NOT NULL, apprecie_global INT NOT NULL, recommande TINYINT(1) NOT NULL, points_forts LONGTEXT DEFAULT NULL, points_faibles LONGTEXT DEFAULT NULL, autres_remarques LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_8290C29F9DBEEA35 (planif_id), UNIQUE INDEX UNIQ_8290C29FBBA93DD6 (stagiaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE enquete_froid ADD CONSTRAINT FK_8290C29F9DBEEA35 FOREIGN KEY (planif_id) REFERENCES planif (id)');
        $this->addSql('ALTER TABLE enquete_froid ADD CONSTRAINT FK_8290C29FBBA93DD6 FOREIGN KEY (stagiaire_id) REFERENCES stagiaire (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE enquete_froid');
    }
}
