<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231211123205 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE accessoire (id INT AUTO_INCREMENT NOT NULL, instrument_id INT DEFAULT NULL, libelle VARCHAR(50) NOT NULL, INDEX IDX_8FD026ACF11D9C (instrument_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE eleve_responsable (eleve_id INT NOT NULL, responsable_id INT NOT NULL, INDEX IDX_D7350730A6CC7B2 (eleve_id), INDEX IDX_D735073053C59D72 (responsable_id), PRIMARY KEY(eleve_id, responsable_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE intervention_contrat (intervention_id INT NOT NULL, contrat_id INT NOT NULL, INDEX IDX_2BDAEDF68EAE3863 (intervention_id), INDEX IDX_2BDAEDF61823061F (contrat_id), PRIMARY KEY(intervention_id, contrat_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE responsable (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, num_rue INT DEFAULT NULL, rue VARCHAR(255) DEFAULT NULL, copos INT DEFAULT NULL, ville VARCHAR(255) DEFAULT NULL, tel INT NOT NULL, mail VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE accessoire ADD CONSTRAINT FK_8FD026ACF11D9C FOREIGN KEY (instrument_id) REFERENCES instrument (id)');
        $this->addSql('ALTER TABLE eleve_responsable ADD CONSTRAINT FK_D7350730A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleve (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE eleve_responsable ADD CONSTRAINT FK_D735073053C59D72 FOREIGN KEY (responsable_id) REFERENCES responsable (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE intervention_contrat ADD CONSTRAINT FK_2BDAEDF68EAE3863 FOREIGN KEY (intervention_id) REFERENCES intervention (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE intervention_contrat ADD CONSTRAINT FK_2BDAEDF61823061F FOREIGN KEY (contrat_id) REFERENCES contrat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contrat ADD eleve_id INT DEFAULT NULL, ADD instrument_id INT DEFAULT NULL, CHANGE date_fin date_fin DATE DEFAULT NULL, CHANGE attestation_assurance attestation_assurance VARCHAR(255) DEFAULT NULL, CHANGE etat_detaille_fin etat_detaille_fin VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE contrat ADD CONSTRAINT FK_60349993A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleve (id)');
        $this->addSql('ALTER TABLE contrat ADD CONSTRAINT FK_60349993CF11D9C FOREIGN KEY (instrument_id) REFERENCES instrument (id)');
        $this->addSql('CREATE INDEX IDX_60349993A6CC7B2 ON contrat (eleve_id)');
        $this->addSql('CREATE INDEX IDX_60349993CF11D9C ON contrat (instrument_id)');
        $this->addSql('ALTER TABLE instrument ADD name VARCHAR(10) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE accessoire DROP FOREIGN KEY FK_8FD026ACF11D9C');
        $this->addSql('ALTER TABLE eleve_responsable DROP FOREIGN KEY FK_D7350730A6CC7B2');
        $this->addSql('ALTER TABLE eleve_responsable DROP FOREIGN KEY FK_D735073053C59D72');
        $this->addSql('ALTER TABLE intervention_contrat DROP FOREIGN KEY FK_2BDAEDF68EAE3863');
        $this->addSql('ALTER TABLE intervention_contrat DROP FOREIGN KEY FK_2BDAEDF61823061F');
        $this->addSql('DROP TABLE accessoire');
        $this->addSql('DROP TABLE eleve_responsable');
        $this->addSql('DROP TABLE intervention_contrat');
        $this->addSql('DROP TABLE responsable');
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE contrat DROP FOREIGN KEY FK_60349993A6CC7B2');
        $this->addSql('ALTER TABLE contrat DROP FOREIGN KEY FK_60349993CF11D9C');
        $this->addSql('DROP INDEX IDX_60349993A6CC7B2 ON contrat');
        $this->addSql('DROP INDEX IDX_60349993CF11D9C ON contrat');
        $this->addSql('ALTER TABLE contrat DROP eleve_id, DROP instrument_id, CHANGE date_fin date_fin DATE NOT NULL, CHANGE attestation_assurance attestation_assurance VARCHAR(255) NOT NULL, CHANGE etat_detaille_fin etat_detaille_fin VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE instrument DROP name');
    }
}
