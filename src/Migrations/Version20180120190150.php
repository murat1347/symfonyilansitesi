<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180120190150 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE twitter_page (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, image_link VARCHAR(150) NOT NULL, description VARCHAR(400) NOT NULL, price INT NOT NULL, page_name VARCHAR(60) NOT NULL, is_vertified TINYINT(1) NOT NULL, page_link VARCHAR(100) NOT NULL, INDEX IDX_334EE733A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE twitter_page_categories (twitter_page_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_201C010EC0379776 (twitter_page_id), INDEX IDX_201C010E12469DE2 (category_id), PRIMARY KEY(twitter_page_id, category_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE twitter_page ADD CONSTRAINT FK_334EE733A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE twitter_page_categories ADD CONSTRAINT FK_201C010EC0379776 FOREIGN KEY (twitter_page_id) REFERENCES twitter_page (id)');
        $this->addSql('ALTER TABLE twitter_page_categories ADD CONSTRAINT FK_201C010E12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE twitter_page_categories DROP FOREIGN KEY FK_201C010EC0379776');
        $this->addSql('DROP TABLE twitter_page');
        $this->addSql('DROP TABLE twitter_page_categories');
    }
}
