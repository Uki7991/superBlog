<?php declare(strict_types = 1);

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180620105534 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE card (id INT AUTO_INCREMENT NOT NULL, card_id VARCHAR(255) NOT NULL, brand VARCHAR(255) DEFAULT NULL, customer_id VARCHAR(255) NOT NULL, name VARCHAR(255) DEFAULT NULL, exp_month INT DEFAULT NULL, exp_year INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP INDEX email ON sb_users');
        $this->addSql('ALTER TABLE sb_customers DROP card_id, CHANGE stripe_id stripe_id VARCHAR(100) DEFAULT NULL, CHANGE paypal_id paypal_id VARCHAR(100) DEFAULT NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE card');
        $this->addSql('ALTER TABLE sb_customers ADD card_id VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci, CHANGE stripe_id stripe_id VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci, CHANGE paypal_id paypal_id VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('CREATE UNIQUE INDEX email ON sb_users (email)');
    }
}
