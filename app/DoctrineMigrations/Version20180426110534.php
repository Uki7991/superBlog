<?php declare(strict_types = 1);

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180426110534 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql('CREATE TABLE book (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(150) NOT NULL, author VARCHAR(100) NOT NULL, price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE sb_charges');
        $this->addSql('DROP TABLE sb_stripe_cards');
    }

    public function down(Schema $schema)
    {
        $this->addSql('CREATE TABLE sb_charges (id INT AUTO_INCREMENT NOT NULL, stripe_id VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, balance_transaction VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, amount INT NOT NULL, status VARCHAR(50) NOT NULL COLLATE utf8_unicode_ci, customer VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sb_stripe_cards (id INT AUTO_INCREMENT NOT NULL, stripe_card_id VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, brand VARCHAR(50) NOT NULL COLLATE utf8_unicode_ci, country VARCHAR(5) NOT NULL COLLATE utf8_unicode_ci, email VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE book');
    }
}
