<?php

declare(strict_types=1);

namespace DoctrineMigrations\old;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231120151100 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE intervention_contrat (intervention_id INT NOT NULL, contrat_id INT NOT NULL, INDEX IDX_2BDAEDF68EAE3863 (intervention_id), INDEX IDX_2BDAEDF61823061F (contrat_id), PRIMARY KEY(intervention_id, contrat_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE intervention_pret (id INT AUTO_INCREMENT NOT NULL, quotite VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE intervention_contrat ADD CONSTRAINT FK_2BDAEDF68EAE3863 FOREIGN KEY (intervention_id) REFERENCES intervention (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE intervention_contrat ADD CONSTRAINT FK_2BDAEDF61823061F FOREIGN KEY (contrat_id) REFERENCES contrat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE intervention ADD intervention_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE intervention ADD CONSTRAINT FK_D11814AB8EAE3863 FOREIGN KEY (intervention_id) REFERENCES intervention_pret (id)');
        $this->addSql('CREATE INDEX IDX_D11814AB8EAE3863 ON intervention (intervention_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE intervention DROP FOREIGN KEY FK_D11814AB8EAE3863');
        $this->addSql('ALTER TABLE intervention_contrat DROP FOREIGN KEY FK_2BDAEDF68EAE3863');
        $this->addSql('ALTER TABLE intervention_contrat DROP FOREIGN KEY FK_2BDAEDF61823061F');
        $this->addSql('DROP TABLE intervention_contrat');
        $this->addSql('DROP TABLE intervention_pret');
        $this->addSql('DROP INDEX IDX_D11814AB8EAE3863 ON intervention');
        $this->addSql('ALTER TABLE intervention DROP intervention_id');
    }
}
