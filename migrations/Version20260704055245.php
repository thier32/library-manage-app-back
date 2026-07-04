<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260704055245 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE borrow (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, loan_id BIGINT NOT NULL, loan_date DATE NOT NULL, return_due_date DATE NOT NULL, returned_at DATE DEFAULT NULL, is_active TINYINT NOT NULL, member_id INT NOT NULL, book_id INT NOT NULL, UNIQUE INDEX UNIQ_55DBA8B0CE73868F (loan_id), INDEX IDX_55DBA8B07597D3FE (member_id), INDEX IDX_55DBA8B016A2B381 (book_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, user_id BIGINT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, api_token VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649A76ED395 (user_id), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE borrow ADD CONSTRAINT FK_55DBA8B07597D3FE FOREIGN KEY (member_id) REFERENCES `member` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE borrow ADD CONSTRAINT FK_55DBA8B016A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE RESTRICT');
        $this->addSql('ALTER TABLE loan DROP FOREIGN KEY `FK_C5D30D0316A2B381`');
        $this->addSql('ALTER TABLE loan DROP FOREIGN KEY `FK_C5D30D037597D3FE`');
        $this->addSql('DROP TABLE loan');
        $this->addSql('ALTER TABLE book ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL, ADD book_id BIGINT NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CBE5A33116A2B381 ON book (book_id)');
        $this->addSql('ALTER TABLE `member` ADD updated_at DATETIME NOT NULL, ADD member_id BIGINT NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_70E4FA787597D3FE ON `member` (member_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE loan (id INT AUTO_INCREMENT NOT NULL, loan_date DATE NOT NULL, return_due_date DATE NOT NULL, returned_at DATE DEFAULT NULL, is_active TINYINT NOT NULL, member_id INT NOT NULL, book_id INT NOT NULL, INDEX IDX_C5D30D037597D3FE (member_id), INDEX IDX_C5D30D0316A2B381 (book_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE loan ADD CONSTRAINT `FK_C5D30D0316A2B381` FOREIGN KEY (book_id) REFERENCES book (id) ON UPDATE NO ACTION');
        $this->addSql('ALTER TABLE loan ADD CONSTRAINT `FK_C5D30D037597D3FE` FOREIGN KEY (member_id) REFERENCES `member` (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE borrow DROP FOREIGN KEY FK_55DBA8B07597D3FE');
        $this->addSql('ALTER TABLE borrow DROP FOREIGN KEY FK_55DBA8B016A2B381');
        $this->addSql('DROP TABLE borrow');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP INDEX UNIQ_CBE5A33116A2B381 ON book');
        $this->addSql('ALTER TABLE book DROP created_at, DROP updated_at, DROP book_id');
        $this->addSql('DROP INDEX UNIQ_70E4FA787597D3FE ON `member`');
        $this->addSql('ALTER TABLE `member` DROP updated_at, DROP member_id');
    }
}
