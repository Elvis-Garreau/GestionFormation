<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210407063637 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE organisme_representant_of (organisme_id INT NOT NULL, representant_of_id INT NOT NULL, INDEX IDX_303181BF5DDD38F5 (organisme_id), INDEX IDX_303181BFE8481CFF (representant_of_id), PRIMARY KEY(organisme_id, representant_of_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE representant_of (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE organisme_representant_of ADD CONSTRAINT FK_303181BF5DDD38F5 FOREIGN KEY (organisme_id) REFERENCES organisme (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE organisme_representant_of ADD CONSTRAINT FK_303181BFE8481CFF FOREIGN KEY (representant_of_id) REFERENCES representant_of (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE organisme_representant_of DROP FOREIGN KEY FK_303181BFE8481CFF');
        $this->addSql('DROP TABLE organisme_representant_of');
        $this->addSql('DROP TABLE representant_of');
    }
}
