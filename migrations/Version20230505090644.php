<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230505090644 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenements ADD CONSTRAINT FK_E10AD4008B3AF64F FOREIGN KEY (hackathon) REFERENCES hackatons (id)');
        $this->addSql('CREATE INDEX IDX_E10AD4008B3AF64F ON evenements (hackathon)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenements DROP FOREIGN KEY FK_E10AD4008B3AF64F');
        $this->addSql('DROP INDEX IDX_E10AD4008B3AF64F ON evenements');
    }
}
