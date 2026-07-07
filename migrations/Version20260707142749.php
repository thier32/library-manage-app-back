<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260707142749 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE transaction (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, transaction_id BIGINT NOT NULL, amount BIGINT NOT NULL, currency VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, reference_id VARCHAR(255) NOT NULL, payment_method VARCHAR(255) NOT NULL, member_id INT NOT NULL, UNIQUE INDEX UNIQ_723705D12FC0CB0F (transaction_id), INDEX IDX_723705D17597D3FE (member_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D17597D3FE FOREIGN KEY (member_id) REFERENCES `member` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D17597D3FE');
        $this->addSql('DROP TABLE transaction');
    }
}
