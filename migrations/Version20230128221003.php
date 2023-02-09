<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230128221003 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message ADD conversation_id_id INT DEFAULT NULL, ADD user_id_id INT DEFAULT NULL, DROP conversation_id, DROP user_id');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F6B92BD7B FOREIGN KEY (conversation_id_id) REFERENCES conversation (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F6B92BD7B ON message (conversation_id_id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F9D86650F ON message (user_id_id)');
        $this->addSql('ALTER TABLE participant ADD participant_id INT DEFAULT NULL, DROP user_id, CHANGE conversation_id conversation_id INT DEFAULT NULL, CHANGE messages_read_at messages_read_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE participant ADD CONSTRAINT FK_D79F6B119D1C3019 FOREIGN KEY (participant_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE participant ADD CONSTRAINT FK_D79F6B119AC0396 FOREIGN KEY (conversation_id) REFERENCES conversation (id)');
        $this->addSql('CREATE INDEX IDX_D79F6B119D1C3019 ON participant (participant_id)');
        $this->addSql('CREATE INDEX IDX_D79F6B119AC0396 ON participant (conversation_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F6B92BD7B');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F9D86650F');
        $this->addSql('DROP INDEX IDX_B6BD307F6B92BD7B ON message');
        $this->addSql('DROP INDEX IDX_B6BD307F9D86650F ON message');
        $this->addSql('ALTER TABLE message ADD conversation_id INT NOT NULL, ADD user_id INT NOT NULL, DROP conversation_id_id, DROP user_id_id');
        $this->addSql('ALTER TABLE participant DROP FOREIGN KEY FK_D79F6B119D1C3019');
        $this->addSql('ALTER TABLE participant DROP FOREIGN KEY FK_D79F6B119AC0396');
        $this->addSql('DROP INDEX IDX_D79F6B119D1C3019 ON participant');
        $this->addSql('DROP INDEX IDX_D79F6B119AC0396 ON participant');
        $this->addSql('ALTER TABLE participant ADD user_id INT NOT NULL, DROP participant_id, CHANGE conversation_id conversation_id INT NOT NULL, CHANGE messages_read_at messages_read_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }
}
