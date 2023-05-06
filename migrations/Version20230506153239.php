<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230506153239 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conference CHANGE theme theme VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE evenements DROP FOREIGN KEY FK_E10AD400996D90CF');
        $this->addSql('DROP INDEX IDX_E10AD400996D90CF ON evenements');
        $this->addSql('ALTER TABLE evenements CHANGE hackathon_id hackathon INT NOT NULL');
        $this->addSql('ALTER TABLE evenements ADD CONSTRAINT FK_E10AD4008B3AF64F FOREIGN KEY (hackathon) REFERENCES hackatons (id)');
        $this->addSql('CREATE INDEX IDX_E10AD4008B3AF64F ON evenements (hackathon)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenements DROP FOREIGN KEY FK_E10AD4008B3AF64F');
        $this->addSql('DROP INDEX IDX_E10AD4008B3AF64F ON evenements');
        $this->addSql('ALTER TABLE evenements CHANGE hackathon hackathon_id INT NOT NULL');
        $this->addSql('ALTER TABLE evenements ADD CONSTRAINT FK_E10AD400996D90CF FOREIGN KEY (hackathon_id) REFERENCES hackatons (id)');
        $this->addSql('CREATE INDEX IDX_E10AD400996D90CF ON evenements (hackathon_id)');
        $this->addSql('ALTER TABLE conference CHANGE theme theme VARCHAR(20) NOT NULL');
    }
}
