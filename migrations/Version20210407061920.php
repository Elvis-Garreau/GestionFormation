<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210407061920 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE organisme ADD charge_formations_id INT DEFAULT NULL, ADD rcs VARCHAR(255) NOT NULL, ADD forme_juridique VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE organisme ADD CONSTRAINT FK_DD0F4533A55B8657 FOREIGN KEY (charge_formations_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_DD0F4533A55B8657 ON organisme (charge_formations_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE organisme DROP FOREIGN KEY FK_DD0F4533A55B8657');
        $this->addSql('DROP INDEX IDX_DD0F4533A55B8657 ON organisme');
        $this->addSql('ALTER TABLE organisme DROP charge_formations_id, DROP rcs, DROP forme_juridique');
    }
}
