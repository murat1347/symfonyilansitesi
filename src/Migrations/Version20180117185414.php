<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180117185414 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE facebook_page_categories DROP FOREIGN KEY FK_7878EE8B13AF32A0');
        $this->addSql('DROP INDEX IDX_7878EE8B13AF32A0 ON facebook_page_categories');
        $this->addSql('ALTER TABLE facebook_page_categories DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE facebook_page_categories CHANGE faceboo_page_id facebook_page_id INT NOT NULL');
        $this->addSql('ALTER TABLE facebook_page_categories ADD CONSTRAINT FK_7878EE8B7A7D7F9F FOREIGN KEY (facebook_page_id) REFERENCES facebook_page (id)');
        $this->addSql('CREATE INDEX IDX_7878EE8B7A7D7F9F ON facebook_page_categories (facebook_page_id)');
        $this->addSql('ALTER TABLE facebook_page_categories ADD PRIMARY KEY (facebook_page_id, category_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE facebook_page_categories DROP FOREIGN KEY FK_7878EE8B7A7D7F9F');
        $this->addSql('DROP INDEX IDX_7878EE8B7A7D7F9F ON facebook_page_categories');
        $this->addSql('ALTER TABLE facebook_page_categories DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE facebook_page_categories CHANGE facebook_page_id faceboo_page_id INT NOT NULL');
        $this->addSql('ALTER TABLE facebook_page_categories ADD CONSTRAINT FK_7878EE8B13AF32A0 FOREIGN KEY (faceboo_page_id) REFERENCES facebook_page (id)');
        $this->addSql('CREATE INDEX IDX_7878EE8B13AF32A0 ON facebook_page_categories (faceboo_page_id)');
        $this->addSql('ALTER TABLE facebook_page_categories ADD PRIMARY KEY (faceboo_page_id, category_id)');
    }
}
