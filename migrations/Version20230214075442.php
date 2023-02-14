<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230214075442 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande ADD fk_livreur_id INT DEFAULT NULL, ADD fk_client_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D80AAD92 FOREIGN KEY (fk_livreur_id) REFERENCES personne (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D78B2BEB1 FOREIGN KEY (fk_client_id) REFERENCES personne (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D80AAD92 ON commande (fk_livreur_id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D78B2BEB1 ON commande (fk_client_id)');
        $this->addSql('ALTER TABLE personne ADD fk_ville_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE personne ADD CONSTRAINT FK_FCEC9EF951743E8 FOREIGN KEY (fk_ville_id) REFERENCES ville (id)');
        $this->addSql('CREATE INDEX IDX_FCEC9EF951743E8 ON personne (fk_ville_id)');
        $this->addSql('ALTER TABLE plat ADD fk_restaurant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE plat ADD CONSTRAINT FK_2038A207D5AD05AC FOREIGN KEY (fk_restaurant_id) REFERENCES restaurant (id)');
        $this->addSql('CREATE INDEX IDX_2038A207D5AD05AC ON plat (fk_restaurant_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE plat DROP FOREIGN KEY FK_2038A207D5AD05AC');
        $this->addSql('DROP INDEX IDX_2038A207D5AD05AC ON plat');
        $this->addSql('ALTER TABLE plat DROP fk_restaurant_id');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D80AAD92');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D78B2BEB1');
        $this->addSql('DROP INDEX IDX_6EEAA67D80AAD92 ON commande');
        $this->addSql('DROP INDEX IDX_6EEAA67D78B2BEB1 ON commande');
        $this->addSql('ALTER TABLE commande DROP fk_livreur_id, DROP fk_client_id');
        $this->addSql('ALTER TABLE personne DROP FOREIGN KEY FK_FCEC9EF951743E8');
        $this->addSql('DROP INDEX IDX_FCEC9EF951743E8 ON personne');
        $this->addSql('ALTER TABLE personne DROP fk_ville_id');
    }
}
