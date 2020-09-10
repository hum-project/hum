<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200812072407 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE continuous_answer DROP INDEX UNIQ_C340DA9F1E27F6BF, ADD INDEX IDX_C340DA9F1E27F6BF (question_id)');
        $this->addSql('ALTER TABLE nominal_answer DROP INDEX UNIQ_9FEA0F561E27F6BF, ADD INDEX IDX_9FEA0F561E27F6BF (question_id)');
        $this->addSql('ALTER TABLE ordinal_answer DROP INDEX UNIQ_6C6712151E27F6BF, ADD INDEX IDX_6C6712151E27F6BF (question_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE continuous_answer DROP INDEX IDX_C340DA9F1E27F6BF, ADD UNIQUE INDEX UNIQ_C340DA9F1E27F6BF (question_id)');
        $this->addSql('ALTER TABLE nominal_answer DROP INDEX IDX_9FEA0F561E27F6BF, ADD UNIQUE INDEX UNIQ_9FEA0F561E27F6BF (question_id)');
        $this->addSql('ALTER TABLE ordinal_answer DROP INDEX IDX_6C6712151E27F6BF, ADD UNIQUE INDEX UNIQ_6C6712151E27F6BF (question_id)');
    }
}
