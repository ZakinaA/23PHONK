<?php

declare(strict_types=1);

namespace DoctrineMigrations\old;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231120150018 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contrat_intervention (contrat_id INT NOT NULL, intervention_id INT NOT NULL, INDEX IDX_9AC61D621823061F (contrat_id), INDEX IDX_9AC61D628EAE3863 (intervention_id), PRIMARY KEY(contrat_id, intervention_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contrat_intervention ADD CONSTRAINT FK_9AC61D621823061F FOREIGN KEY (contrat_id) REFERENCES contrat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contrat_intervention ADD CONSTRAINT FK_9AC61D628EAE3863 FOREIGN KEY (intervention_id) REFERENCES intervention (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contrat ADD contrat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE contrat ADD CONSTRAINT FK_603499931823061F FOREIGN KEY (contrat_id) REFERENCES intervention_pret (id)');
        $this->addSql('CREATE INDEX IDX_603499931823061F ON contrat (contrat_id)');
        $this->addSql('ALTER TABLE intervention ADD intervention_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE intervention ADD CONSTRAINT FK_D11814AB8EAE3863 FOREIGN KEY (contrat_id) REFERENCES intervention_pret (id)');
        $this->addSql('CREATE INDEX IDX_D11814AB8EAE3863 ON intervention (contrat_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contrat_intervention DROP FOREIGN KEY FK_9AC61D621823061F');
        $this->addSql('ALTER TABLE contrat_intervention DROP FOREIGN KEY FK_9AC61D628EAE3863');
        $this->addSql('DROP TABLE contrat_intervention');
        $this->addSql('ALTER TABLE contrat DROP FOREIGN KEY FK_603499931823061F');
        $this->addSql('DROP INDEX IDX_603499931823061F ON contrat');
        $this->addSql('ALTER TABLE contrat DROP contrat_id');
        $this->addSql('ALTER TABLE intervention DROP FOREIGN KEY FK_D11814AB8EAE3863');
        $this->addSql('DROP INDEX IDX_D11814AB8EAE3863 ON intervention');
        $this->addSql('ALTER TABLE intervention DROP intervention_id');
    }
}
