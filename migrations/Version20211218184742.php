<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211218184742 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Starting migration';
    }

    public function up(
        Schema $schema
    ): void {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE mascot_group_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE rss__group_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE rss__result_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE rss__search_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE mascot_group (id INT NOT NULL, title VARCHAR(255) NOT NULL, directories TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN mascot_group.directories IS \'(DC2Type:array)\'');
        $this->addSql('CREATE TABLE rss__group (id INT NOT NULL, name VARCHAR(50) NOT NULL, url VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE rss__result (id INT NOT NULL, url TEXT NOT NULL, title TEXT NOT NULL, data JSON NOT NULL, seen_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, guid VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN rss__result.seen_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE rss__search (id INT NOT NULL, rss_group_id INT NOT NULL, query VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_45309965FF875BE4 ON rss__search (rss_group_id)');
        $this->addSql('ALTER TABLE rss__search ADD CONSTRAINT FK_45309965FF875BE4 FOREIGN KEY (rss_group_id) REFERENCES rss__group (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(
        Schema $schema
    ): void {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE rss__search DROP CONSTRAINT FK_45309965FF875BE4');
        $this->addSql('DROP SEQUENCE mascot_group_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE rss__group_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE rss__result_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE rss__search_id_seq CASCADE');
        $this->addSql('DROP TABLE mascot_group');
        $this->addSql('DROP TABLE rss__group');
        $this->addSql('DROP TABLE rss__result');
        $this->addSql('DROP TABLE rss__search');
    }
}
