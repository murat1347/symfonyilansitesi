<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180125203111 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE communicate DROP INDEX UNIQ_6A1E99F45F004ACF, ADD INDEX IDX_6A1E99F45F004ACF (sender)');
        $this->addSql('ALTER TABLE communicate DROP INDEX UNIQ_6A1E99F4D0E3AE91, ADD INDEX IDX_6A1E99F4D0E3AE91 (reciver)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE communicate DROP INDEX IDX_6A1E99F45F004ACF, ADD UNIQUE INDEX UNIQ_6A1E99F45F004ACF (sender)');
        $this->addSql('ALTER TABLE communicate DROP INDEX IDX_6A1E99F4D0E3AE91, ADD UNIQUE INDEX UNIQ_6A1E99F4D0E3AE91 (reciver)');
    }
}
