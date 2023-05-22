<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230522132743 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inscrits DROP FOREIGN KEY FK_2644257FF2D657D1');
        $this->addSql('DROP INDEX IDX_2644257FF2D657D1 ON inscrits');
        $this->addSql('ALTER TABLE inscrits ADD atelier INT DEFAULT NULL, DROP relation_evenement_id');
        $this->addSql('ALTER TABLE inscrits ADD CONSTRAINT FK_2644257FE1BB1823 FOREIGN KEY (atelier) REFERENCES atelier (id)');
        $this->addSql('CREATE INDEX IDX_2644257FE1BB1823 ON inscrits (atelier)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inscrits DROP FOREIGN KEY FK_2644257FE1BB1823');
        $this->addSql('DROP INDEX IDX_2644257FE1BB1823 ON inscrits');
        $this->addSql('ALTER TABLE inscrits ADD relation_evenement_id INT NOT NULL, DROP atelier');
        $this->addSql('ALTER TABLE inscrits ADD CONSTRAINT FK_2644257FF2D657D1 FOREIGN KEY (relation_evenement_id) REFERENCES evenements (id)');
        $this->addSql('CREATE INDEX IDX_2644257FF2D657D1 ON inscrits (relation_evenement_id)');
    }
}
