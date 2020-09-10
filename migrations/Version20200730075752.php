<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200730075752 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE policy ADD vote_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE policy ADD CONSTRAINT FK_F07D051672DCDAFC FOREIGN KEY (vote_id) REFERENCES vote (id)');
        $this->addSql('CREATE INDEX IDX_F07D051672DCDAFC ON policy (vote_id)');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A1085642D29E3C6');
        $this->addSql('DROP INDEX UNIQ_5A1085642D29E3C6 ON vote');
        $this->addSql('ALTER TABLE vote DROP policy_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE policy DROP FOREIGN KEY FK_F07D051672DCDAFC');
        $this->addSql('DROP INDEX IDX_F07D051672DCDAFC ON policy');
        $this->addSql('ALTER TABLE policy DROP vote_id');
        $this->addSql('ALTER TABLE vote ADD policy_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A1085642D29E3C6 FOREIGN KEY (policy_id) REFERENCES policy (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5A1085642D29E3C6 ON vote (policy_id)');
    }
}
