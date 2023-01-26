<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230126170458 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participant ADD participant_id INT DEFAULT NULL, DROP user_id');
        $this->addSql('ALTER TABLE participant ADD CONSTRAINT FK_D79F6B119D1C3019 FOREIGN KEY (participant_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D79F6B119D1C3019 ON participant (participant_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participant DROP FOREIGN KEY FK_D79F6B119D1C3019');
        $this->addSql('DROP INDEX UNIQ_D79F6B119D1C3019 ON participant');
        $this->addSql('ALTER TABLE participant ADD user_id INT NOT NULL, DROP participant_id');
    }
}
