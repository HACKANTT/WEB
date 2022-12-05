<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221202152959 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE atelier CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE atelier ADD CONSTRAINT FK_E1BB1823BF396750 FOREIGN KEY (id) REFERENCES evenements (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE conference CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE conference ADD CONSTRAINT FK_911533C8BF396750 FOREIGN KEY (id) REFERENCES evenements (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evenements ADD type VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conference DROP FOREIGN KEY FK_911533C8BF396750');
        $this->addSql('ALTER TABLE conference CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE atelier DROP FOREIGN KEY FK_E1BB1823BF396750');
        $this->addSql('ALTER TABLE atelier CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE evenements DROP type');
    }
}
