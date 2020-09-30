<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200930041132 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client_answer (id INT AUTO_INCREMENT NOT NULL, hum_id INT DEFAULT NULL, nominal_answer_id INT DEFAULT NULL, ordinal_answer_id INT DEFAULT NULL, continuous_answer_id INT DEFAULT NULL, id_hash VARCHAR(255) DEFAULT NULL, INDEX IDX_8F7B0196341B70D7 (hum_id), INDEX IDX_8F7B0196C9378004 (nominal_answer_id), INDEX IDX_8F7B0196D78E20EF (ordinal_answer_id), INDEX IDX_8F7B01969D05563B (continuous_answer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE client_answer ADD CONSTRAINT FK_8F7B0196341B70D7 FOREIGN KEY (hum_id) REFERENCES hum (id)');
        $this->addSql('ALTER TABLE client_answer ADD CONSTRAINT FK_8F7B0196C9378004 FOREIGN KEY (nominal_answer_id) REFERENCES nominal_answer (id)');
        $this->addSql('ALTER TABLE client_answer ADD CONSTRAINT FK_8F7B0196D78E20EF FOREIGN KEY (ordinal_answer_id) REFERENCES ordinal_answer (id)');
        $this->addSql('ALTER TABLE client_answer ADD CONSTRAINT FK_8F7B01969D05563B FOREIGN KEY (continuous_answer_id) REFERENCES continuous_answer (id)');
        $this->addSql('DROP TABLE client_continuous_answer');
        $this->addSql('DROP TABLE client_nominal_answer');
        $this->addSql('DROP TABLE client_ordinal_answer');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client_continuous_answer (id INT AUTO_INCREMENT NOT NULL, continuous_answer_id INT DEFAULT NULL, INDEX IDX_E90B388E9D05563B (continuous_answer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE client_nominal_answer (id INT AUTO_INCREMENT NOT NULL, nominal_answer_id INT DEFAULT NULL, INDEX IDX_BE294DD9C9378004 (nominal_answer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE client_ordinal_answer (id INT AUTO_INCREMENT NOT NULL, ordinal_answer_id INT DEFAULT NULL, value INT NOT NULL, INDEX IDX_4DA4509AD78E20EF (ordinal_answer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE client_continuous_answer ADD CONSTRAINT FK_E90B388E9D05563B FOREIGN KEY (continuous_answer_id) REFERENCES continuous_answer (id)');
        $this->addSql('ALTER TABLE client_nominal_answer ADD CONSTRAINT FK_BE294DD9C9378004 FOREIGN KEY (nominal_answer_id) REFERENCES nominal_answer (id)');
        $this->addSql('ALTER TABLE client_ordinal_answer ADD CONSTRAINT FK_4DA4509AD78E20EF FOREIGN KEY (ordinal_answer_id) REFERENCES ordinal_answer (id)');
        $this->addSql('DROP TABLE client_answer');
    }
}
