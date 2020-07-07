<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180117174727 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(60) NOT NULL, password VARCHAR(64) NOT NULL, city VARCHAR(20) NOT NULL, first_name VARCHAR(60) NOT NULL, second_name VARCHAR(60) NOT NULL, is_active TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE facebook_page (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, page_name VARCHAR(60) NOT NULL, is_vertified TINYINT(1) NOT NULL, page_link VARCHAR(100) NOT NULL, INDEX IDX_7F3B5EDA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE facebook_page ADD CONSTRAINT FK_7F3B5EDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE facebook_page DROP FOREIGN KEY FK_7F3B5EDA76ED395');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE facebook_page');
    }
}
