<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200720071428 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE policy_theme ADD language_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE policy_theme ADD CONSTRAINT FK_2CB36EF382F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id)');
        $this->addSql('CREATE INDEX IDX_2CB36EF382F1BAF4 ON policy_theme (language_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE policy_theme DROP FOREIGN KEY FK_2CB36EF382F1BAF4');
        $this->addSql('DROP INDEX IDX_2CB36EF382F1BAF4 ON policy_theme');
        $this->addSql('ALTER TABLE policy_theme DROP language_id');
    }
}
