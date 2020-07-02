<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200702092220 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE argument (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, side VARCHAR(255) NOT NULL, text LONGTEXT NOT NULL, UNIQUE INDEX UNIQ_D113B0A727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blog_image (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, blog_post_id INT DEFAULT NULL, ordering INT NOT NULL, subtext LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_35D247973DA5256D (image_id), INDEX IDX_35D24797A77FBEAF (blog_post_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE institution (id INT AUTO_INCREMENT NOT NULL, policy_theme_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, text LONGTEXT NOT NULL, INDEX IDX_3A9F98E578D5AC8A (policy_theme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE argument ADD CONSTRAINT FK_D113B0A727ACA70 FOREIGN KEY (parent_id) REFERENCES argument (id)');
        $this->addSql('ALTER TABLE blog_image ADD CONSTRAINT FK_35D247973DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE blog_image ADD CONSTRAINT FK_35D24797A77FBEAF FOREIGN KEY (blog_post_id) REFERENCES blog_post (id)');
        $this->addSql('ALTER TABLE institution ADD CONSTRAINT FK_3A9F98E578D5AC8A FOREIGN KEY (policy_theme_id) REFERENCES policy_theme (id)');
        $this->addSql('ALTER TABLE blog_post ADD language_id INT DEFAULT NULL, ADD parent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE blog_post ADD CONSTRAINT FK_BA5AE01D82F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id)');
        $this->addSql('ALTER TABLE blog_post ADD CONSTRAINT FK_BA5AE01D727ACA70 FOREIGN KEY (parent_id) REFERENCES blog_post (id)');
        $this->addSql('CREATE INDEX IDX_BA5AE01D82F1BAF4 ON blog_post (language_id)');
        $this->addSql('CREATE INDEX IDX_BA5AE01D727ACA70 ON blog_post (parent_id)');
        $this->addSql('ALTER TABLE hum ADD policy_id INT DEFAULT NULL, ADD institution_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE hum ADD CONSTRAINT FK_D8CED3DC2D29E3C6 FOREIGN KEY (policy_id) REFERENCES policy (id)');
        $this->addSql('ALTER TABLE hum ADD CONSTRAINT FK_D8CED3DC10405986 FOREIGN KEY (institution_id) REFERENCES institution (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D8CED3DC2D29E3C6 ON hum (policy_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D8CED3DC10405986 ON hum (institution_id)');
        $this->addSql('ALTER TABLE policy ADD argument_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE policy ADD CONSTRAINT FK_F07D05163DD48F21 FOREIGN KEY (argument_id) REFERENCES argument (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F07D05163DD48F21 ON policy (argument_id)');
        $this->addSql('ALTER TABLE user ADD username VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE argument DROP FOREIGN KEY FK_D113B0A727ACA70');
        $this->addSql('ALTER TABLE policy DROP FOREIGN KEY FK_F07D05163DD48F21');
        $this->addSql('ALTER TABLE hum DROP FOREIGN KEY FK_D8CED3DC10405986');
        $this->addSql('DROP TABLE argument');
        $this->addSql('DROP TABLE blog_image');
        $this->addSql('DROP TABLE institution');
        $this->addSql('ALTER TABLE blog_post DROP FOREIGN KEY FK_BA5AE01D82F1BAF4');
        $this->addSql('ALTER TABLE blog_post DROP FOREIGN KEY FK_BA5AE01D727ACA70');
        $this->addSql('DROP INDEX IDX_BA5AE01D82F1BAF4 ON blog_post');
        $this->addSql('DROP INDEX IDX_BA5AE01D727ACA70 ON blog_post');
        $this->addSql('ALTER TABLE blog_post DROP language_id, DROP parent_id');
        $this->addSql('ALTER TABLE hum DROP FOREIGN KEY FK_D8CED3DC2D29E3C6');
        $this->addSql('DROP INDEX UNIQ_D8CED3DC2D29E3C6 ON hum');
        $this->addSql('DROP INDEX UNIQ_D8CED3DC10405986 ON hum');
        $this->addSql('ALTER TABLE hum DROP policy_id, DROP institution_id');
        $this->addSql('DROP INDEX UNIQ_F07D05163DD48F21 ON policy');
        $this->addSql('ALTER TABLE policy DROP argument_id');
        $this->addSql('ALTER TABLE user DROP username');
    }
}
