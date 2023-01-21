<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210623074643 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_C7440455ECEA3675 ON client');
        $this->addSql('CREATE FULLTEXT INDEX IDX_C7440455ECEA3675BA6B8568D226037E ON client (nom_societe, representant_nom, representant_prenom)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_C7440455ECEA3675BA6B8568D226037E ON client');
        $this->addSql('CREATE FULLTEXT INDEX IDX_C7440455ECEA3675 ON client (nom_societe)');
    }
}
