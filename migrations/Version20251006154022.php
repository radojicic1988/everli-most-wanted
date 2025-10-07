<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251006154022 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE witness_report ADD processed_by_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE witness_report ADD CONSTRAINT FK_8EDE5E6F2FFD4FD3 FOREIGN KEY (processed_by_id) REFERENCES "user" (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_8EDE5E6F2FFD4FD3 ON witness_report (processed_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE witness_report DROP CONSTRAINT FK_8EDE5E6F2FFD4FD3');
        $this->addSql('DROP INDEX IDX_8EDE5E6F2FFD4FD3');
        $this->addSql('ALTER TABLE witness_report DROP processed_by_id');
    }
}
