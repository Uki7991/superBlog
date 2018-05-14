<?php declare(strict_types = 1);

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180504104136 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sb_transactions ADD order_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sb_transactions ADD CONSTRAINT FK_12C6C6D18D9F6D38 FOREIGN KEY (order_id) REFERENCES sb_orders (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_12C6C6D18D9F6D38 ON sb_transactions (order_id)');
        $this->addSql('ALTER TABLE sb_orders ADD transaction_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sb_orders ADD CONSTRAINT FK_3C99896B2FC0CB0F FOREIGN KEY (transaction_id) REFERENCES sb_transactions (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3C99896B2FC0CB0F ON sb_orders (transaction_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sb_orders DROP FOREIGN KEY FK_3C99896B2FC0CB0F');
        $this->addSql('DROP INDEX UNIQ_3C99896B2FC0CB0F ON sb_orders');
        $this->addSql('ALTER TABLE sb_orders DROP transaction_id');
        $this->addSql('ALTER TABLE sb_transactions DROP FOREIGN KEY FK_12C6C6D18D9F6D38');
        $this->addSql('DROP INDEX UNIQ_12C6C6D18D9F6D38 ON sb_transactions');
        $this->addSql('ALTER TABLE sb_transactions DROP order_id');
    }
}
