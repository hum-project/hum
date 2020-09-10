<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200729052329 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE policy ADD parent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE policy ADD CONSTRAINT FK_F07D0516727ACA70 FOREIGN KEY (parent_id) REFERENCES policy (id)');
        $this->addSql('CREATE INDEX IDX_F07D0516727ACA70 ON policy (parent_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE policy DROP FOREIGN KEY FK_F07D0516727ACA70');
        $this->addSql('DROP INDEX IDX_F07D0516727ACA70 ON policy');
        $this->addSql('ALTER TABLE policy DROP parent_id');
    }
}
