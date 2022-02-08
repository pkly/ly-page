<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220208172810 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(
        Schema $schema
    ): void {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rss__result ADD search_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rss__result ADD CONSTRAINT FK_E2AA83D1650760A9 FOREIGN KEY (search_id) REFERENCES rss__search (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_E2AA83D1650760A9 ON rss__result (search_id)');
        $this->addSql('ALTER TABLE rss__search ADD directory VARCHAR(255) DEFAULT NULL');
    }

    public function down(
        Schema $schema
    ): void {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE rss__result DROP CONSTRAINT FK_E2AA83D1650760A9');
        $this->addSql('DROP INDEX IDX_E2AA83D1650760A9');
        $this->addSql('ALTER TABLE rss__result DROP search_id');
        $this->addSql('ALTER TABLE rss__search DROP directory');
    }
}
