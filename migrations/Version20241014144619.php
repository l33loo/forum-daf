<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241014144619 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE email_confirmation_requests (id CHAR(36) NOT NULL COMMENT \'(DC2Type:UserId)\', user_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:UserId)\', expire_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', verified TINYINT(1) NOT NULL, INDEX IDX_8D749470A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE email_confirmation_requests ADD CONSTRAINT FK_8D749470A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE email_confirmation_requests DROP FOREIGN KEY FK_8D749470A76ED395');
        $this->addSql('DROP TABLE email_confirmation_requests');
    }
}
