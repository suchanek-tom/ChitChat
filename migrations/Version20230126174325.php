<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230126174325 extends AbstractMigration
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
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F6B92BD7B');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F9D86650F');
        $this->addSql('DROP INDEX IDX_B6BD307F6B92BD7B ON message');
        $this->addSql('DROP INDEX IDX_B6BD307F9D86650F ON message');
        $this->addSql('ALTER TABLE message ADD conversation_id INT NOT NULL, ADD user_id INT NOT NULL, DROP conversation_id_id, DROP user_id_id');
    }
}
