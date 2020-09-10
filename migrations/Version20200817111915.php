<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200817111915 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE continuous_answer ADD minimum DOUBLE PRECISION NOT NULL, ADD maximum DOUBLE PRECISION NOT NULL, DROP value');
        $this->addSql('ALTER TABLE ordinal_answer DROP value');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE continuous_answer ADD value INT NOT NULL, DROP minimum, DROP maximum');
        $this->addSql('ALTER TABLE ordinal_answer ADD value INT NOT NULL');
    }
}
