<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210407083916 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE organisme DROP FOREIGN KEY FK_DD0F4533A55B8657');
        $this->addSql('DROP INDEX IDX_DD0F4533A55B8657 ON organisme');
        $this->addSql('ALTER TABLE organisme DROP charge_formations_id, DROP representant_nom, DROP representant_prenom');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE organisme ADD charge_formations_id INT DEFAULT NULL, ADD representant_nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD representant_prenom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE organisme ADD CONSTRAINT FK_DD0F4533A55B8657 FOREIGN KEY (charge_formations_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_DD0F4533A55B8657 ON organisme (charge_formations_id)');
    }
}
