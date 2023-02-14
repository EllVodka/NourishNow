<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230214072820 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE restaurant ADD fk_personne_id INT DEFAULT NULL, ADD fk_type_resto_id INT DEFAULT NULL, ADD fk_ville_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE restaurant ADD CONSTRAINT FK_EB95123FCBED7D26 FOREIGN KEY (fk_personne_id) REFERENCES personne (id)');
        $this->addSql('ALTER TABLE restaurant ADD CONSTRAINT FK_EB95123F80CDBAEF FOREIGN KEY (fk_type_resto_id) REFERENCES type_resto (id)');
        $this->addSql('ALTER TABLE restaurant ADD CONSTRAINT FK_EB95123F951743E8 FOREIGN KEY (fk_ville_id) REFERENCES ville (id)');
        $this->addSql('CREATE INDEX IDX_EB95123FCBED7D26 ON restaurant (fk_personne_id)');
        $this->addSql('CREATE INDEX IDX_EB95123F80CDBAEF ON restaurant (fk_type_resto_id)');
        $this->addSql('CREATE INDEX IDX_EB95123F951743E8 ON restaurant (fk_ville_id)');
        $this->addSql('ALTER TABLE ville ADD fk_secteur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ville ADD CONSTRAINT FK_43C3D9C36F108E96 FOREIGN KEY (fk_secteur_id) REFERENCES secteur (id)');
        $this->addSql('CREATE INDEX IDX_43C3D9C36F108E96 ON ville (fk_secteur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE restaurant DROP FOREIGN KEY FK_EB95123FCBED7D26');
        $this->addSql('ALTER TABLE restaurant DROP FOREIGN KEY FK_EB95123F80CDBAEF');
        $this->addSql('ALTER TABLE restaurant DROP FOREIGN KEY FK_EB95123F951743E8');
        $this->addSql('DROP INDEX IDX_EB95123FCBED7D26 ON restaurant');
        $this->addSql('DROP INDEX IDX_EB95123F80CDBAEF ON restaurant');
        $this->addSql('DROP INDEX IDX_EB95123F951743E8 ON restaurant');
        $this->addSql('ALTER TABLE restaurant DROP fk_personne_id, DROP fk_type_resto_id, DROP fk_ville_id');
        $this->addSql('ALTER TABLE ville DROP FOREIGN KEY FK_43C3D9C36F108E96');
        $this->addSql('DROP INDEX IDX_43C3D9C36F108E96 ON ville');
        $this->addSql('ALTER TABLE ville DROP fk_secteur_id');
    }
}
