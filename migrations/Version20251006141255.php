<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251006141255 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE witness_report (id SERIAL NOT NULL, uuid UUID NOT NULL, phone VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, case_title VARCHAR(255) NOT NULL, ip VARCHAR(255) NOT NULL, country VARCHAR(2) NOT NULL, is_processed BOOLEAN DEFAULT false NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8EDE5E6FD17F50A6 ON witness_report (uuid)');
        $this->addSql('CREATE INDEX IDX_8EDE5E6FD17F50A6 ON witness_report (uuid)');
        $this->addSql('COMMENT ON COLUMN witness_report.uuid IS \'(DC2Type:uuid)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE witness_report');
    }
}
