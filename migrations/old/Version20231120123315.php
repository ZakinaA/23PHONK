<?php

declare(strict_types=1);

namespace DoctrineMigrations\old;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231120123315 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contrat ADD quotite VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE eleve ADD eleve_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE eleve ADD CONSTRAINT FK_ECA105F7A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES contrat (id)');
        $this->addSql('CREATE INDEX IDX_ECA105F7A6CC7B2 ON eleve (_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contrat DROP quotite');
        $this->addSql('ALTER TABLE eleve DROP FOREIGN KEY FK_ECA105F7A6CC7B2');
        $this->addSql('DROP INDEX IDX_ECA105F7A6CC7B2 ON eleve');
        $this->addSql('ALTER TABLE eleve DROP eleve_id');
    }
}
