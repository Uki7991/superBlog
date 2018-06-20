<?php declare(strict_types = 1);

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180620110506 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sb_card DROP FOREIGN KEY FK_88C3A44CB171EB6C');
        $this->addSql('DROP INDEX IDX_88C3A44CB171EB6C ON sb_card');
        $this->addSql('ALTER TABLE sb_card CHANGE customer_id_id customer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sb_card ADD CONSTRAINT FK_88C3A44C9395C3F3 FOREIGN KEY (customer_id) REFERENCES sb_customers (id)');
        $this->addSql('CREATE INDEX IDX_88C3A44C9395C3F3 ON sb_card (customer_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sb_card DROP FOREIGN KEY FK_88C3A44C9395C3F3');
        $this->addSql('DROP INDEX IDX_88C3A44C9395C3F3 ON sb_card');
        $this->addSql('ALTER TABLE sb_card CHANGE customer_id customer_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sb_card ADD CONSTRAINT FK_88C3A44CB171EB6C FOREIGN KEY (customer_id_id) REFERENCES sb_customers (id)');
        $this->addSql('CREATE INDEX IDX_88C3A44CB171EB6C ON sb_card (customer_id_id)');
    }
}
