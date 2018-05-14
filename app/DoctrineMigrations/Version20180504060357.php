<?php declare(strict_types = 1);

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180504060357 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE sb_transactions (id INT AUTO_INCREMENT NOT NULL, customer_id INT DEFAULT NULL, amount DOUBLE PRECISION NOT NULL, currency VARCHAR(5) NOT NULL, INDEX IDX_12C6C6D19395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sb_customers (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, stripe_id VARCHAR(100) NOT NULL, paypal_id VARCHAR(100) NOT NULL, card_id VARCHAR(100) NOT NULL, email VARCHAR(75) NOT NULL, created_at DATETIME DEFAULT NULL, INDEX IDX_ECFC3DD8A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sb_orders (id INT AUTO_INCREMENT NOT NULL, customer_id INT DEFAULT NULL, INDEX IDX_3C99896B9395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sb_transactions ADD CONSTRAINT FK_12C6C6D19395C3F3 FOREIGN KEY (customer_id) REFERENCES sb_customers (id)');
        $this->addSql('ALTER TABLE sb_customers ADD CONSTRAINT FK_ECFC3DD8A76ED395 FOREIGN KEY (user_id) REFERENCES sb_users (id)');
        $this->addSql('ALTER TABLE sb_orders ADD CONSTRAINT FK_3C99896B9395C3F3 FOREIGN KEY (customer_id) REFERENCES sb_customers (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sb_transactions DROP FOREIGN KEY FK_12C6C6D19395C3F3');
        $this->addSql('ALTER TABLE sb_orders DROP FOREIGN KEY FK_3C99896B9395C3F3');
        $this->addSql('DROP TABLE sb_transactions');
        $this->addSql('DROP TABLE sb_customers');
        $this->addSql('DROP TABLE sb_orders');
    }
}
