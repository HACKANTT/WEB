<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230504011208 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenements DROP FOREIGN KEY FK_E10AD40094F5EFD7');
        $this->addSql('DROP INDEX IDX_E10AD40094F5EFD7 ON evenements');
        $this->addSql('ALTER TABLE evenements CHANGE hackaton_id_id hackathon_id INT NOT NULL');
        $this->addSql('ALTER TABLE evenements ADD CONSTRAINT FK_E10AD400996D90CF FOREIGN KEY (hackathon_id) REFERENCES hackatons (id)');
        $this->addSql('CREATE INDEX IDX_E10AD400996D90CF ON evenements (hackathon_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenements DROP FOREIGN KEY FK_E10AD400996D90CF');
        $this->addSql('DROP INDEX IDX_E10AD400996D90CF ON evenements');
        $this->addSql('ALTER TABLE evenements CHANGE hackathon_id hackaton_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE evenements ADD CONSTRAINT FK_E10AD40094F5EFD7 FOREIGN KEY (hackaton_id_id) REFERENCES hackatons (id)');
        $this->addSql('CREATE INDEX IDX_E10AD40094F5EFD7 ON evenements (hackaton_id_id)');
    }
}
