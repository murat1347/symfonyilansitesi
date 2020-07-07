<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180123181308 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE communicate (id INT AUTO_INCREMENT NOT NULL, sender INT DEFAULT NULL, reciver INT DEFAULT NULL, UNIQUE INDEX UNIQ_6A1E99F45F004ACF (sender), UNIQUE INDEX UNIQ_6A1E99F4D0E3AE91 (reciver), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE communicate ADD CONSTRAINT FK_6A1E99F45F004ACF FOREIGN KEY (sender) REFERENCES user (id)');
        $this->addSql('ALTER TABLE communicate ADD CONSTRAINT FK_6A1E99F4D0E3AE91 FOREIGN KEY (reciver) REFERENCES user (id)');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F5F004ACF');
        $this->addSql('DROP INDEX UNIQ_B6BD307F5F004ACF ON message');
        $this->addSql('ALTER TABLE message CHANGE sender communicate_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F8E001266 FOREIGN KEY (communicate_id) REFERENCES communicate (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F8E001266 ON message (communicate_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F8E001266');
        $this->addSql('DROP TABLE communicate');
        $this->addSql('DROP INDEX IDX_B6BD307F8E001266 ON message');
        $this->addSql('ALTER TABLE message CHANGE communicate_id sender INT DEFAULT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F5F004ACF FOREIGN KEY (sender) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B6BD307F5F004ACF ON message (sender)');
    }
}
