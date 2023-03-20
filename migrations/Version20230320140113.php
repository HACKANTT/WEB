<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230320140113 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE avis (id INT AUTO_INCREMENT NOT NULL, mail VARCHAR(255) NOT NULL, commentaire VARCHAR(2000) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favoris (id INT AUTO_INCREMENT NOT NULL, id_u_id INT NOT NULL, id_h_id INT NOT NULL, favori TINYINT(1) NOT NULL, INDEX IDX_8933C4326F858F92 (id_u_id), INDEX IDX_8933C432CDF600D0 (id_h_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C4326F858F92 FOREIGN KEY (id_u_id) REFERENCES utilisateurs (id)');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C432CDF600D0 FOREIGN KEY (id_h_id) REFERENCES hackatons (id)');
        $this->addSql('ALTER TABLE inscrits DROP FOREIGN KEY FK_2644257F68F2152C');
        $this->addSql('DROP INDEX IDX_2644257F68F2152C ON inscrits');
        $this->addSql('ALTER TABLE inscrits CHANGE relation_atelier_id atelier INT DEFAULT NULL');
        $this->addSql('ALTER TABLE inscrits ADD CONSTRAINT FK_2644257FE1BB1823 FOREIGN KEY (atelier) REFERENCES atelier (id)');
        $this->addSql('CREATE INDEX IDX_2644257FE1BB1823 ON inscrits (atelier)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C4326F858F92');
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C432CDF600D0');
        $this->addSql('DROP TABLE avis');
        $this->addSql('DROP TABLE favoris');
        $this->addSql('ALTER TABLE inscrits DROP FOREIGN KEY FK_2644257FE1BB1823');
        $this->addSql('DROP INDEX IDX_2644257FE1BB1823 ON inscrits');
        $this->addSql('ALTER TABLE inscrits CHANGE atelier relation_atelier_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE inscrits ADD CONSTRAINT FK_2644257F68F2152C FOREIGN KEY (relation_atelier_id) REFERENCES atelier (id)');
        $this->addSql('CREATE INDEX IDX_2644257F68F2152C ON inscrits (relation_atelier_id)');
    }
}
