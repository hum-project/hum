<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200701175724 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE blog_post (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, slug VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, text LONGTEXT NOT NULL, entered DATETIME NOT NULL, modified DATETIME DEFAULT NULL, publish_time DATETIME DEFAULT NULL, INDEX IDX_BA5AE01DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE continuous_answer (id INT AUTO_INCREMENT NOT NULL, question_id INT DEFAULT NULL, value INT NOT NULL, UNIQUE INDEX UNIQ_C340DA9F1E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hum (id INT AUTO_INCREMENT NOT NULL, language_id INT DEFAULT NULL, parent_id INT DEFAULT NULL, date DATETIME NOT NULL, INDEX IDX_D8CED3DC82F1BAF4 (language_id), INDEX IDX_D8CED3DC727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, alt VARCHAR(255) NOT NULL, data LONGBLOB NOT NULL, width INT NOT NULL, height INT NOT NULL, length INT NOT NULL, filetype VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE language (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nominal_answer (id INT AUTO_INCREMENT NOT NULL, question_id INT DEFAULT NULL, value VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_9FEA0F561E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ordinal_answer (id INT AUTO_INCREMENT NOT NULL, question_id INT DEFAULT NULL, value INT NOT NULL, scale INT NOT NULL, UNIQUE INDEX UNIQ_6C6712151E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE policy (id INT AUTO_INCREMENT NOT NULL, policy_theme_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, text LONGTEXT NOT NULL, source VARCHAR(255) NOT NULL, INDEX IDX_F07D051678D5AC8A (policy_theme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE policy_theme (id INT AUTO_INCREMENT NOT NULL, symbol_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, text LONGTEXT NOT NULL, UNIQUE INDEX UNIQ_2CB36EF3C0F75674 (symbol_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, hum_id INT DEFAULT NULL, text LONGTEXT NOT NULL, INDEX IDX_B6F7494E341B70D7 (hum_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vote (id INT AUTO_INCREMENT NOT NULL, policy_id INT DEFAULT NULL, yes INT NOT NULL, no INT NOT NULL, abstain INT NOT NULL, absent INT NOT NULL, UNIQUE INDEX UNIQ_5A1085642D29E3C6 (policy_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE blog_post ADD CONSTRAINT FK_BA5AE01DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE continuous_answer ADD CONSTRAINT FK_C340DA9F1E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE hum ADD CONSTRAINT FK_D8CED3DC82F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id)');
        $this->addSql('ALTER TABLE hum ADD CONSTRAINT FK_D8CED3DC727ACA70 FOREIGN KEY (parent_id) REFERENCES hum (id)');
        $this->addSql('ALTER TABLE nominal_answer ADD CONSTRAINT FK_9FEA0F561E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE ordinal_answer ADD CONSTRAINT FK_6C6712151E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE policy ADD CONSTRAINT FK_F07D051678D5AC8A FOREIGN KEY (policy_theme_id) REFERENCES policy_theme (id)');
        $this->addSql('ALTER TABLE policy_theme ADD CONSTRAINT FK_2CB36EF3C0F75674 FOREIGN KEY (symbol_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E341B70D7 FOREIGN KEY (hum_id) REFERENCES hum (id)');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A1085642D29E3C6 FOREIGN KEY (policy_id) REFERENCES policy (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hum DROP FOREIGN KEY FK_D8CED3DC727ACA70');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E341B70D7');
        $this->addSql('ALTER TABLE policy_theme DROP FOREIGN KEY FK_2CB36EF3C0F75674');
        $this->addSql('ALTER TABLE hum DROP FOREIGN KEY FK_D8CED3DC82F1BAF4');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A1085642D29E3C6');
        $this->addSql('ALTER TABLE policy DROP FOREIGN KEY FK_F07D051678D5AC8A');
        $this->addSql('ALTER TABLE continuous_answer DROP FOREIGN KEY FK_C340DA9F1E27F6BF');
        $this->addSql('ALTER TABLE nominal_answer DROP FOREIGN KEY FK_9FEA0F561E27F6BF');
        $this->addSql('ALTER TABLE ordinal_answer DROP FOREIGN KEY FK_6C6712151E27F6BF');
        $this->addSql('ALTER TABLE blog_post DROP FOREIGN KEY FK_BA5AE01DA76ED395');
        $this->addSql('DROP TABLE blog_post');
        $this->addSql('DROP TABLE continuous_answer');
        $this->addSql('DROP TABLE hum');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE language');
        $this->addSql('DROP TABLE nominal_answer');
        $this->addSql('DROP TABLE ordinal_answer');
        $this->addSql('DROP TABLE policy');
        $this->addSql('DROP TABLE policy_theme');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE vote');
    }
}
