<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200721062922 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE argument ADD language_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE argument ADD CONSTRAINT FK_D113B0A82F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id)');
        $this->addSql('CREATE INDEX IDX_D113B0A82F1BAF4 ON argument (language_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE argument DROP FOREIGN KEY FK_D113B0A82F1BAF4');
        $this->addSql('DROP INDEX IDX_D113B0A82F1BAF4 ON argument');
        $this->addSql('ALTER TABLE argument DROP language_id');
    }
}
