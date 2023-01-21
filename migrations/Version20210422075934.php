<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210422075934 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE enquete_client (id INT AUTO_INCREMENT NOT NULL, planif_id INT DEFAULT NULL, offre_disponible INT NOT NULL, formalites_clair INT NOT NULL, infos_avant_formation INT NOT NULL, elements_contractuels INT NOT NULL, formation_utile_competences INT NOT NULL, apprecie_relation_of INT NOT NULL, recommande TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_BCDBB2DD9DBEEA35 (planif_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE enquete_client ADD CONSTRAINT FK_BCDBB2DD9DBEEA35 FOREIGN KEY (planif_id) REFERENCES planif (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE enquete_client');
    }
}
