<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200930042226 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client_answer DROP FOREIGN KEY FK_8F7B01969D05563B');
        $this->addSql('ALTER TABLE client_answer DROP FOREIGN KEY FK_8F7B0196C9378004');
        $this->addSql('ALTER TABLE client_answer DROP FOREIGN KEY FK_8F7B0196D78E20EF');
        $this->addSql('DROP INDEX IDX_8F7B01969D05563B ON client_answer');
        $this->addSql('DROP INDEX IDX_8F7B0196C9378004 ON client_answer');
        $this->addSql('DROP INDEX IDX_8F7B0196D78E20EF ON client_answer');
        $this->addSql('ALTER TABLE client_answer ADD question_id INT DEFAULT NULL, DROP nominal_answer_id, DROP ordinal_answer_id, DROP continuous_answer_id');
        $this->addSql('ALTER TABLE client_answer ADD CONSTRAINT FK_8F7B01961E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('CREATE INDEX IDX_8F7B01961E27F6BF ON client_answer (question_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client_answer DROP FOREIGN KEY FK_8F7B01961E27F6BF');
        $this->addSql('DROP INDEX IDX_8F7B01961E27F6BF ON client_answer');
        $this->addSql('ALTER TABLE client_answer ADD ordinal_answer_id INT DEFAULT NULL, ADD continuous_answer_id INT DEFAULT NULL, CHANGE question_id nominal_answer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE client_answer ADD CONSTRAINT FK_8F7B01969D05563B FOREIGN KEY (continuous_answer_id) REFERENCES continuous_answer (id)');
        $this->addSql('ALTER TABLE client_answer ADD CONSTRAINT FK_8F7B0196C9378004 FOREIGN KEY (nominal_answer_id) REFERENCES nominal_answer (id)');
        $this->addSql('ALTER TABLE client_answer ADD CONSTRAINT FK_8F7B0196D78E20EF FOREIGN KEY (ordinal_answer_id) REFERENCES ordinal_answer (id)');
        $this->addSql('CREATE INDEX IDX_8F7B01969D05563B ON client_answer (continuous_answer_id)');
        $this->addSql('CREATE INDEX IDX_8F7B0196C9378004 ON client_answer (nominal_answer_id)');
        $this->addSql('CREATE INDEX IDX_8F7B0196D78E20EF ON client_answer (ordinal_answer_id)');
    }
}
