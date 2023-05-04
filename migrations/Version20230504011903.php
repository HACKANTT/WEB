<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230504011903 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE atelier (id INT NOT NULL, nb_participants INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE conference (id INT NOT NULL, theme VARCHAR(20) NOT NULL, intervenant VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE atelier ADD CONSTRAINT FK_E1BB1823BF396750 FOREIGN KEY (id) REFERENCES evenements (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE conference ADD CONSTRAINT FK_911533C8BF396750 FOREIGN KEY (id) REFERENCES evenements (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0B0FE4F5A FOREIGN KEY (id_a_id) REFERENCES atelier (id)');
        $this->addSql('ALTER TABLE inscrits ADD CONSTRAINT FK_2644257FE1BB1823 FOREIGN KEY (atelier) REFERENCES atelier (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF0B0FE4F5A');
        $this->addSql('ALTER TABLE inscrits DROP FOREIGN KEY FK_2644257FE1BB1823');
        $this->addSql('ALTER TABLE atelier DROP FOREIGN KEY FK_E1BB1823BF396750');
        $this->addSql('ALTER TABLE conference DROP FOREIGN KEY FK_911533C8BF396750');
        $this->addSql('DROP TABLE atelier');
        $this->addSql('DROP TABLE conference');
    }
}
