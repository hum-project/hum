<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200729061102 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE argument ADD translation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE argument ADD CONSTRAINT FK_D113B0A9CAA2B25 FOREIGN KEY (translation_id) REFERENCES argument (id)');
        $this->addSql('CREATE INDEX IDX_D113B0A9CAA2B25 ON argument (translation_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE argument DROP FOREIGN KEY FK_D113B0A9CAA2B25');
        $this->addSql('DROP INDEX IDX_D113B0A9CAA2B25 ON argument');
        $this->addSql('ALTER TABLE argument DROP translation_id');
    }
}
