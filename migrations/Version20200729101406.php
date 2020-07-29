<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200729101406 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE institution ADD translation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE institution ADD CONSTRAINT FK_3A9F98E59CAA2B25 FOREIGN KEY (translation_id) REFERENCES institution (id)');
        $this->addSql('CREATE INDEX IDX_3A9F98E59CAA2B25 ON institution (translation_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE institution DROP FOREIGN KEY FK_3A9F98E59CAA2B25');
        $this->addSql('DROP INDEX IDX_3A9F98E59CAA2B25 ON institution');
        $this->addSql('ALTER TABLE institution DROP translation_id');
    }
}
