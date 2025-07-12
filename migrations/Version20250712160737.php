<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250712160737 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Initial migration for lypage-v3';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE block_group (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE block_link (id INT AUTO_INCREMENT NOT NULL, block_id INT NOT NULL, url VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, INDEX IDX_F0C2CB8AE9ED820C (block_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE footer_link (id INT AUTO_INCREMENT NOT NULL, url VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, priority SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mascot (id INT AUTO_INCREMENT NOT NULL, path VARCHAR(2048) NOT NULL, ext VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mascot_tag (mascot_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_8E5C38BF62BBAE4F (mascot_id), INDEX IDX_8E5C38BFBAD26311 (tag_id), PRIMARY KEY(mascot_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mascot_group (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mascot_group_tag (mascot_group_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_38727E172AD03B70 (mascot_group_id), INDEX IDX_38727E17BAD26311 (tag_id), PRIMARY KEY(mascot_group_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE result (id INT AUTO_INCREMENT NOT NULL, search_id INT NOT NULL, url VARCHAR(2048) NOT NULL, title VARCHAR(2048) NOT NULL, data JSON NOT NULL COMMENT \'(DC2Type:json)\', guid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', seen_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_136AC113650760A9 (search_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE search (id INT AUTO_INCREMENT NOT NULL, source_id INT NOT NULL, query VARCHAR(1024) NOT NULL, directory VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, last_searched_at DATETIME DEFAULT NULL, last_found_at DATETIME DEFAULT NULL, INDEX IDX_B4F0DBA7953C1C61 (source_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE source (id INT AUTO_INCREMENT NOT NULL, url VARCHAR(1024) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, tag_group_id INT NOT NULL, title VARCHAR(255) NOT NULL, meta SMALLINT DEFAULT NULL, INDEX IDX_389B783C865A29C (tag_group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag_group (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wallpaper (id INT AUTO_INCREMENT NOT NULL, path VARCHAR(2048) NOT NULL, ext VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wallpaper_tag (wallpaper_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_5E1613C0488626AA (wallpaper_id), INDEX IDX_5E1613C0BAD26311 (tag_id), PRIMARY KEY(wallpaper_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE block_link ADD CONSTRAINT FK_F0C2CB8AE9ED820C FOREIGN KEY (block_id) REFERENCES block_group (id)');
        $this->addSql('ALTER TABLE mascot_tag ADD CONSTRAINT FK_8E5C38BF62BBAE4F FOREIGN KEY (mascot_id) REFERENCES mascot (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mascot_tag ADD CONSTRAINT FK_8E5C38BFBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mascot_group_tag ADD CONSTRAINT FK_38727E172AD03B70 FOREIGN KEY (mascot_group_id) REFERENCES mascot_group (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mascot_group_tag ADD CONSTRAINT FK_38727E17BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE result ADD CONSTRAINT FK_136AC113650760A9 FOREIGN KEY (search_id) REFERENCES search (id)');
        $this->addSql('ALTER TABLE search ADD CONSTRAINT FK_B4F0DBA7953C1C61 FOREIGN KEY (source_id) REFERENCES source (id)');
        $this->addSql('ALTER TABLE tag ADD CONSTRAINT FK_389B783C865A29C FOREIGN KEY (tag_group_id) REFERENCES tag_group (id)');
        $this->addSql('ALTER TABLE wallpaper_tag ADD CONSTRAINT FK_5E1613C0488626AA FOREIGN KEY (wallpaper_id) REFERENCES wallpaper (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE wallpaper_tag ADD CONSTRAINT FK_5E1613C0BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE block_link DROP FOREIGN KEY FK_F0C2CB8AE9ED820C');
        $this->addSql('ALTER TABLE mascot_tag DROP FOREIGN KEY FK_8E5C38BF62BBAE4F');
        $this->addSql('ALTER TABLE mascot_tag DROP FOREIGN KEY FK_8E5C38BFBAD26311');
        $this->addSql('ALTER TABLE mascot_group_tag DROP FOREIGN KEY FK_38727E172AD03B70');
        $this->addSql('ALTER TABLE mascot_group_tag DROP FOREIGN KEY FK_38727E17BAD26311');
        $this->addSql('ALTER TABLE result DROP FOREIGN KEY FK_136AC113650760A9');
        $this->addSql('ALTER TABLE search DROP FOREIGN KEY FK_B4F0DBA7953C1C61');
        $this->addSql('ALTER TABLE tag DROP FOREIGN KEY FK_389B783C865A29C');
        $this->addSql('ALTER TABLE wallpaper_tag DROP FOREIGN KEY FK_5E1613C0488626AA');
        $this->addSql('ALTER TABLE wallpaper_tag DROP FOREIGN KEY FK_5E1613C0BAD26311');
        $this->addSql('DROP TABLE block_group');
        $this->addSql('DROP TABLE block_link');
        $this->addSql('DROP TABLE footer_link');
        $this->addSql('DROP TABLE mascot');
        $this->addSql('DROP TABLE mascot_tag');
        $this->addSql('DROP TABLE mascot_group');
        $this->addSql('DROP TABLE mascot_group_tag');
        $this->addSql('DROP TABLE result');
        $this->addSql('DROP TABLE search');
        $this->addSql('DROP TABLE source');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE tag_group');
        $this->addSql('DROP TABLE wallpaper');
        $this->addSql('DROP TABLE wallpaper_tag');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
