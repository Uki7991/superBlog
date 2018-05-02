<?php declare(strict_types = 1);

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180426091254 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql('ALTER TABLE sb_posts DROP popularity');
    }

    public function down(Schema $schema)
    {
        $this->addSql('ALTER TABLE sb_posts ADD popularity INT DEFAULT NULL');
    }
}