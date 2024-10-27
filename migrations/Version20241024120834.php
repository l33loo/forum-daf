<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241024120834 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE questions (id CHAR(36) NOT NULL COMMENT \'(DC2Type:UserId)\', author_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:UserId)\', post_id CHAR(36) NOT NULL COMMENT \'(DC2Type:UserId)\', published TINYINT(1) DEFAULT 0 NOT NULL, body LONGTEXT NOT NULL, published_on DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', accepted TINYINT(1) DEFAULT 0 NOT NULL, reject_reason VARCHAR(255) DEFAULT NULL, question VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8ADC54D54B89032C (post_id), INDEX IDX_8ADC54D5F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE questions ADD CONSTRAINT FK_8ADC54D5F675F31B FOREIGN KEY (author_id) REFERENCES users (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE questions DROP FOREIGN KEY FK_8ADC54D5F675F31B');
        $this->addSql('DROP TABLE questions');
    }
}
