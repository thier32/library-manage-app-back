<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260704001301 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE book (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, author VARCHAR(255) NOT NULL, published_at DATE DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE loan (id INT AUTO_INCREMENT NOT NULL, loan_date DATE NOT NULL, return_due_date DATE NOT NULL, returned_at DATE DEFAULT NULL, is_active TINYINT NOT NULL, member_id INT NOT NULL, book_id INT NOT NULL, INDEX IDX_C5D30D037597D3FE (member_id), INDEX IDX_C5D30D0316A2B381 (book_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE `member` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, email VARCHAR(180) NOT NULL, created_at DATETIME NOT NULL, is_active TINYINT NOT NULL, UNIQUE INDEX UNIQ_70E4FA78E7927C74 (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE loan ADD CONSTRAINT FK_C5D30D037597D3FE FOREIGN KEY (member_id) REFERENCES `member` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE loan ADD CONSTRAINT FK_C5D30D0316A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE RESTRICT');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE loan DROP FOREIGN KEY FK_C5D30D037597D3FE');
        $this->addSql('ALTER TABLE loan DROP FOREIGN KEY FK_C5D30D0316A2B381');
        $this->addSql('DROP TABLE book');
        $this->addSql('DROP TABLE loan');
        $this->addSql('DROP TABLE `member`');
    }
}
