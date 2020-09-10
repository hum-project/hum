<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200801074946 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hum DROP FOREIGN KEY FK_D8CED3DC727ACA70');
        $this->addSql('ALTER TABLE hum DROP FOREIGN KEY FK_D8CED3DC82F1BAF4');
        $this->addSql('DROP INDEX IDX_D8CED3DC82F1BAF4 ON hum');
        $this->addSql('DROP INDEX IDX_D8CED3DC727ACA70 ON hum');
        $this->addSql('ALTER TABLE hum DROP language_id, DROP parent_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hum ADD language_id INT DEFAULT NULL, ADD parent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE hum ADD CONSTRAINT FK_D8CED3DC727ACA70 FOREIGN KEY (parent_id) REFERENCES hum (id)');
        $this->addSql('ALTER TABLE hum ADD CONSTRAINT FK_D8CED3DC82F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id)');
        $this->addSql('CREATE INDEX IDX_D8CED3DC82F1BAF4 ON hum (language_id)');
        $this->addSql('CREATE INDEX IDX_D8CED3DC727ACA70 ON hum (parent_id)');
    }
}
