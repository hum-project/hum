<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200812040845 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE question ADD translation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E9CAA2B25 FOREIGN KEY (translation_id) REFERENCES question (id)');
        $this->addSql('CREATE INDEX IDX_B6F7494E9CAA2B25 ON question (translation_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E9CAA2B25');
        $this->addSql('DROP INDEX IDX_B6F7494E9CAA2B25 ON question');
        $this->addSql('ALTER TABLE question DROP translation_id');
    }
}
