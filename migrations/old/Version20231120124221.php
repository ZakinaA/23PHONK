<?php

declare(strict_types=1);

namespace DoctrineMigrations\old;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231120124221 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE eleve ADD contrat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE eleve ADD CONSTRAINT FK_ECA105F71823061F FOREIGN KEY (contrat_id) REFERENCES contrat (id)');
        $this->addSql('CREATE INDEX IDX_ECA105F71823061F ON eleve (contrat_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE eleve DROP FOREIGN KEY FK_ECA105F71823061F');
        $this->addSql('DROP INDEX IDX_ECA105F71823061F ON eleve');
        $this->addSql('ALTER TABLE eleve DROP contrat_id');
    }
}
