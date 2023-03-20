<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230320141316 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis ADD id_a_id INT NOT NULL');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0B0FE4F5A FOREIGN KEY (id_a_id) REFERENCES atelier (id)');
        $this->addSql('CREATE INDEX IDX_8F91ABF0B0FE4F5A ON avis (id_a_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF0B0FE4F5A');
        $this->addSql('DROP INDEX IDX_8F91ABF0B0FE4F5A ON avis');
        $this->addSql('ALTER TABLE avis DROP id_a_id');
    }
}
