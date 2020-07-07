<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180118214955 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE instagram_page_categories (instagram_page_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_E1313BB28159ECEA (instagram_page_id), INDEX IDX_E1313BB212469DE2 (category_id), PRIMARY KEY(instagram_page_id, category_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE instagram_page_categories ADD CONSTRAINT FK_E1313BB28159ECEA FOREIGN KEY (instagram_page_id) REFERENCES instagram_page (id)');
        $this->addSql('ALTER TABLE instagram_page_categories ADD CONSTRAINT FK_E1313BB212469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE instagram_page ADD image_link VARCHAR(150) NOT NULL, ADD description VARCHAR(400) NOT NULL, ADD price INT NOT NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE instagram_page_categories');
        $this->addSql('ALTER TABLE instagram_page DROP image_link, DROP description, DROP price');
    }
}
