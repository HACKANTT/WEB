<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230509134730 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE evenements (id INT AUTO_INCREMENT NOT NULL, hackathon INT NOT NULL, libelle VARCHAR(255) NOT NULL, date_event DATE NOT NULL, heure TIME NOT NULL, duree TIME NOT NULL, salle VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_E10AD4008B3AF64F (hackathon), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE evenements ADD CONSTRAINT FK_E10AD4008B3AF64F FOREIGN KEY (hackathon) REFERENCES hackatons (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE atelier DROP FOREIGN KEY FK_E1BB1823BF396750');
        $this->addSql('ALTER TABLE conference DROP FOREIGN KEY FK_911533C8BF396750');
        $this->addSql('ALTER TABLE evenements DROP FOREIGN KEY FK_E10AD4008B3AF64F');
        $this->addSql('DROP TABLE evenements');
    }
}
