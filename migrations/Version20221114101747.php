<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221114101747 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inscription ADD id_h_id INT NOT NULL, ADD id_u_id INT NOT NULL, DROP id_h, DROP id_u');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6CDF600D0 FOREIGN KEY (id_h_id) REFERENCES hackatons (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D66F858F92 FOREIGN KEY (id_u_id) REFERENCES utilisateurs (id)');
        $this->addSql('CREATE INDEX IDX_5E90F6D6CDF600D0 ON inscription (id_h_id)');
        $this->addSql('CREATE INDEX IDX_5E90F6D66F858F92 ON inscription (id_u_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6CDF600D0');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D66F858F92');
        $this->addSql('DROP INDEX IDX_5E90F6D6CDF600D0 ON inscription');
        $this->addSql('DROP INDEX IDX_5E90F6D66F858F92 ON inscription');
        $this->addSql('ALTER TABLE inscription ADD id_h INT NOT NULL, ADD id_u INT NOT NULL, DROP id_h_id, DROP id_u_id');
    }
}
