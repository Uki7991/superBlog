<?php declare(strict_types = 1);

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180426114005 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql('CREATE TABLE sb_books (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(150) NOT NULL, author VARCHAR(100) NOT NULL, price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('INSERT INTO sb_books (title, author, price) VALUES ("Earth Book", "Kubanov Tilek", 21)');
        $this->addSql('INSERT INTO sb_books (title, author, price) VALUES ("Sport Book", "Kubanov Tilek", 15)');
        $this->addSql('DROP TABLE book');
    }

    public function down(Schema $schema)
    {
        $this->addSql('CREATE TABLE book (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(150) NOT NULL COLLATE utf8_unicode_ci, author VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci, price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('INSERT INTO book (title, author, price) VALUES ("Sport Book", "Kubanov Tilek", 15)');
        $this->addSql('INSERT INTO book (title, author, price) VALUES ("Earth Book", "Kubanov Tilek", 21)');
        $this->addSql('DROP TABLE sb_books');
    }
}
