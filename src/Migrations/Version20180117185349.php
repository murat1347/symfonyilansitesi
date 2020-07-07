<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180117185349 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE facebook_page_categories (faceboo_page_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_7878EE8B13AF32A0 (faceboo_page_id), INDEX IDX_7878EE8B12469DE2 (category_id), PRIMARY KEY(faceboo_page_id, category_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE facebook_page_categories ADD CONSTRAINT FK_7878EE8B13AF32A0 FOREIGN KEY (faceboo_page_id) REFERENCES facebook_page (id)');
        $this->addSql('ALTER TABLE facebook_page_categories ADD CONSTRAINT FK_7878EE8B12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C17A7D7F9F');
        $this->addSql('DROP INDEX IDX_64C19C17A7D7F9F ON category');
        $this->addSql('ALTER TABLE category DROP facebook_page_id');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE facebook_page_categories');
        $this->addSql('ALTER TABLE category ADD facebook_page_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C17A7D7F9F FOREIGN KEY (facebook_page_id) REFERENCES facebook_page (id)');
        $this->addSql('CREATE INDEX IDX_64C19C17A7D7F9F ON category (facebook_page_id)');
    }
}
