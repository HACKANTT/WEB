<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230509132512 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE atelier (id INT NOT NULL, nb_places INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE avis (id INT AUTO_INCREMENT NOT NULL, id_a_id INT NOT NULL, mail VARCHAR(255) NOT NULL, commentaire VARCHAR(2000) NOT NULL, INDEX IDX_8F91ABF0B0FE4F5A (id_a_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE conference (id INT NOT NULL, theme VARCHAR(50) NOT NULL, intervenant VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenements (id INT AUTO_INCREMENT NOT NULL, hackathon INT NOT NULL, libelle VARCHAR(255) NOT NULL, date_event DATE NOT NULL, heure TIME NOT NULL, duree TIME NOT NULL, salle VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_E10AD4008B3AF64F (hackathon), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favoris (id INT AUTO_INCREMENT NOT NULL, id_u_id INT NOT NULL, id_h_id INT NOT NULL, INDEX IDX_8933C4326F858F92 (id_u_id), INDEX IDX_8933C432CDF600D0 (id_h_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hackatons (id INT AUTO_INCREMENT NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, heure_debut TIME NOT NULL, heure_fin TIME NOT NULL, lieu VARCHAR(255) NOT NULL, rue VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, cp VARCHAR(5) NOT NULL, theme VARCHAR(100) NOT NULL, description VARCHAR(600) NOT NULL, image VARCHAR(255) NOT NULL, date_limite DATE NOT NULL, nb_places INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inscription (id INT AUTO_INCREMENT NOT NULL, id_h_id INT NOT NULL, id_u_id INT NOT NULL, date_inscription DATE NOT NULL, INDEX IDX_5E90F6D6CDF600D0 (id_h_id), INDEX IDX_5E90F6D66F858F92 (id_u_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inscrits (id INT AUTO_INCREMENT NOT NULL, atelier INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, INDEX IDX_2644257FE1BB1823 (atelier), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateurs (id INT AUTO_INCREMENT NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', nom VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, tel VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, date_naissance DATE NOT NULL, lien_portfolio VARCHAR(255) NOT NULL, login VARCHAR(15) NOT NULL, password VARCHAR(512) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE atelier ADD CONSTRAINT FK_E1BB1823BF396750 FOREIGN KEY (id) REFERENCES evenements (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0B0FE4F5A FOREIGN KEY (id_a_id) REFERENCES atelier (id)');
        $this->addSql('ALTER TABLE conference ADD CONSTRAINT FK_911533C8BF396750 FOREIGN KEY (id) REFERENCES evenements (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evenements ADD CONSTRAINT FK_E10AD4008B3AF64F FOREIGN KEY (hackathon) REFERENCES hackatons (id)');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C4326F858F92 FOREIGN KEY (id_u_id) REFERENCES utilisateurs (id)');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C432CDF600D0 FOREIGN KEY (id_h_id) REFERENCES hackatons (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6CDF600D0 FOREIGN KEY (id_h_id) REFERENCES hackatons (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D66F858F92 FOREIGN KEY (id_u_id) REFERENCES utilisateurs (id)');
        $this->addSql('ALTER TABLE inscrits ADD CONSTRAINT FK_2644257FE1BB1823 FOREIGN KEY (atelier) REFERENCES atelier (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE atelier DROP FOREIGN KEY FK_E1BB1823BF396750');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF0B0FE4F5A');
        $this->addSql('ALTER TABLE conference DROP FOREIGN KEY FK_911533C8BF396750');
        $this->addSql('ALTER TABLE evenements DROP FOREIGN KEY FK_E10AD4008B3AF64F');
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C4326F858F92');
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C432CDF600D0');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6CDF600D0');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D66F858F92');
        $this->addSql('ALTER TABLE inscrits DROP FOREIGN KEY FK_2644257FE1BB1823');
        $this->addSql('DROP TABLE atelier');
        $this->addSql('DROP TABLE avis');
        $this->addSql('DROP TABLE conference');
        $this->addSql('DROP TABLE evenements');
        $this->addSql('DROP TABLE favoris');
        $this->addSql('DROP TABLE hackatons');
        $this->addSql('DROP TABLE inscription');
        $this->addSql('DROP TABLE inscrits');
        $this->addSql('DROP TABLE utilisateurs');
    }
}
