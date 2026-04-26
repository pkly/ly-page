<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260426102451 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'add api link stuff';
    }

    public function up(
        Schema $schema
    ): void {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE api_link (id INT UNSIGNED AUTO_INCREMENT NOT NULL, mascot_group_id INT NOT NULL, user_identifier VARCHAR(255) NOT NULL, INDEX IDX_175BEF022AD03B70 (mascot_group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE api_link ADD CONSTRAINT FK_175BEF022AD03B70 FOREIGN KEY (mascot_group_id) REFERENCES mascot_group (id)');
        $this->addSql('DROP INDEX IDX_75EA56E0FB7336F0 ON messenger_messages');
        $this->addSql('DROP INDEX IDX_75EA56E0E3BD61CE ON messenger_messages');
        $this->addSql('DROP INDEX IDX_75EA56E016BA31DB ON messenger_messages');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 ON messenger_messages (queue_name, available_at, delivered_at, id)');
    }

    public function down(
        Schema $schema
    ): void {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE api_link DROP FOREIGN KEY FK_175BEF022AD03B70');
        $this->addSql('DROP TABLE api_link');
        $this->addSql('DROP INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 ON messenger_messages');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
    }
}
