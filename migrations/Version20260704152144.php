<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260704152144 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE borrow DROP FOREIGN KEY `FK_55DBA8B070E4FA78`');
        $this->addSql('ALTER TABLE borrow DROP FOREIGN KEY `FK_55DBA8B0CBE5A331`');
        $this->addSql('DROP INDEX IDX_55DBA8B070E4FA78 ON borrow');
        $this->addSql('DROP INDEX IDX_55DBA8B0CBE5A331 ON borrow');
        $this->addSql('ALTER TABLE borrow ADD member_id BIGINT NOT NULL, ADD book_id BIGINT NOT NULL, DROP `member`, DROP book');
        $this->addSql('ALTER TABLE borrow ADD CONSTRAINT FK_55DBA8B07597D3FE FOREIGN KEY (member_id) REFERENCES `member` (member_id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE borrow ADD CONSTRAINT FK_55DBA8B016A2B381 FOREIGN KEY (book_id) REFERENCES book (book_id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_55DBA8B07597D3FE ON borrow (member_id)');
        $this->addSql('CREATE INDEX IDX_55DBA8B016A2B381 ON borrow (book_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE borrow DROP FOREIGN KEY FK_55DBA8B07597D3FE');
        $this->addSql('ALTER TABLE borrow DROP FOREIGN KEY FK_55DBA8B016A2B381');
        $this->addSql('DROP INDEX IDX_55DBA8B07597D3FE ON borrow');
        $this->addSql('DROP INDEX IDX_55DBA8B016A2B381 ON borrow');
        $this->addSql('ALTER TABLE borrow ADD `member` BIGINT NOT NULL, ADD book BIGINT NOT NULL, DROP member_id, DROP book_id');
        $this->addSql('ALTER TABLE borrow ADD CONSTRAINT `FK_55DBA8B070E4FA78` FOREIGN KEY (`member`) REFERENCES `member` (member_id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE borrow ADD CONSTRAINT `FK_55DBA8B0CBE5A331` FOREIGN KEY (book) REFERENCES book (book_id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_55DBA8B070E4FA78 ON borrow (`member`)');
        $this->addSql('CREATE INDEX IDX_55DBA8B0CBE5A331 ON borrow (book)');
    }
}
