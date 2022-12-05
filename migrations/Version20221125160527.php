<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221125160527 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE atelier (id INT AUTO_INCREMENT NOT NULL, nb_participants INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE inscrits ADD relation_atelier_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE inscrits ADD CONSTRAINT FK_2644257F68F2152C FOREIGN KEY (relation_atelier_id) REFERENCES atelier (id)');
        $this->addSql('CREATE INDEX IDX_2644257F68F2152C ON inscrits (relation_atelier_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inscrits DROP FOREIGN KEY FK_2644257F68F2152C');
        $this->addSql('DROP TABLE atelier');
        $this->addSql('DROP INDEX IDX_2644257F68F2152C ON inscrits');
        $this->addSql('ALTER TABLE inscrits DROP relation_atelier_id');
    }
}
