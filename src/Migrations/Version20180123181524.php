<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180123181524 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FD0E3AE91');
        $this->addSql('DROP INDEX UNIQ_B6BD307FD0E3AE91 ON message');
        $this->addSql('ALTER TABLE message CHANGE reciver user INT DEFAULT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F8D93D649 FOREIGN KEY (user) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F8D93D649 ON message (user)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F8D93D649');
        $this->addSql('DROP INDEX IDX_B6BD307F8D93D649 ON message');
        $this->addSql('ALTER TABLE message CHANGE user reciver INT DEFAULT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FD0E3AE91 FOREIGN KEY (reciver) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B6BD307FD0E3AE91 ON message (reciver)');
    }
}
