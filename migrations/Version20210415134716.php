<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210415134716 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE representant_of ADD organisme_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE representant_of ADD CONSTRAINT FK_D41E945A5DDD38F5 FOREIGN KEY (organisme_id) REFERENCES organisme (id)');
        $this->addSql('CREATE INDEX IDX_D41E945A5DDD38F5 ON representant_of (organisme_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE representant_of DROP FOREIGN KEY FK_D41E945A5DDD38F5');
        $this->addSql('DROP INDEX IDX_D41E945A5DDD38F5 ON representant_of');
        $this->addSql('ALTER TABLE representant_of DROP organisme_id');
    }
}
