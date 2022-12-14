<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221202160854 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenements ADD hackaton_id INT NOT NULL');
        $this->addSql('ALTER TABLE evenements ADD CONSTRAINT FK_E10AD400B333DC5B FOREIGN KEY (hackaton_id) REFERENCES hackatons (id)');
        $this->addSql('CREATE INDEX IDX_E10AD400B333DC5B ON evenements (hackaton_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenements DROP FOREIGN KEY FK_E10AD400B333DC5B');
        $this->addSql('DROP INDEX IDX_E10AD400B333DC5B ON evenements');
        $this->addSql('ALTER TABLE evenements DROP hackaton_id');
    }
}
