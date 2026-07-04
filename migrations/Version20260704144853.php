<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260704144853 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book CHANGE book_id book_id BIGINT NOT NULL');
        $this->addSql('ALTER TABLE borrow CHANGE member_id member_id BIGINT NOT NULL, CHANGE book_id book_id BIGINT NOT NULL');
        $this->addSql('ALTER TABLE borrow ADD CONSTRAINT FK_55DBA8B07597D3FE FOREIGN KEY (member_id) REFERENCES `member` (member_id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE borrow ADD CONSTRAINT FK_55DBA8B016A2B381 FOREIGN KEY (book_id) REFERENCES book (book_id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book CHANGE book_id book_id BIGINT UNSIGNED NOT NULL');
        $this->addSql('ALTER TABLE borrow DROP FOREIGN KEY FK_55DBA8B07597D3FE');
        $this->addSql('ALTER TABLE borrow DROP FOREIGN KEY FK_55DBA8B016A2B381');
        $this->addSql('ALTER TABLE borrow CHANGE member_id member_id BIGINT UNSIGNED NOT NULL, CHANGE book_id book_id BIGINT UNSIGNED NOT NULL');
    }
}
