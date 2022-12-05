<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221125142830 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hackatons CHANGE date_debut date_debut DATE NOT NULL, CHANGE date_fin date_fin DATE NOT NULL, CHANGE heure_debut heure_debut TIME NOT NULL, CHANGE heure_fin heure_fin TIME NOT NULL, CHANGE lieu lieu VARCHAR(255) NOT NULL, CHANGE rue rue VARCHAR(255) NOT NULL, CHANGE ville ville VARCHAR(255) NOT NULL, CHANGE cp cp VARCHAR(5) NOT NULL, CHANGE theme theme VARCHAR(100) NOT NULL, CHANGE description description VARCHAR(600) NOT NULL, CHANGE date_limite date_limite DATE NOT NULL, CHANGE nb_places nb_places INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hackatons CHANGE date_debut date_debut DATE DEFAULT NULL, CHANGE date_fin date_fin DATE DEFAULT NULL, CHANGE heure_debut heure_debut TIME DEFAULT NULL, CHANGE heure_fin heure_fin TIME DEFAULT NULL, CHANGE lieu lieu VARCHAR(255) DEFAULT NULL, CHANGE rue rue VARCHAR(255) DEFAULT NULL, CHANGE ville ville VARCHAR(255) DEFAULT NULL, CHANGE cp cp VARCHAR(5) DEFAULT NULL, CHANGE theme theme VARCHAR(100) DEFAULT NULL, CHANGE description description VARCHAR(600) DEFAULT NULL, CHANGE date_limite date_limite DATE DEFAULT NULL, CHANGE nb_places nb_places INT DEFAULT NULL');
    }
}
