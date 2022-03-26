<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220326152833 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add active to searches';
    }

    public function up(
        Schema $schema
    ): void {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rss__result ALTER seen_at TYPE DATE');
        $this->addSql('ALTER TABLE rss__result ALTER seen_at DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN rss__result.seen_at IS \'(DC2Type:date_immutable)\'');
        $this->addSql('ALTER TABLE rss__search ADD active BOOLEAN DEFAULT true NOT NULL');
    }

    public function down(
        Schema $schema
    ): void {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE rss__result ALTER seen_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE rss__result ALTER seen_at DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN rss__result.seen_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE rss__search DROP active');
    }
}
