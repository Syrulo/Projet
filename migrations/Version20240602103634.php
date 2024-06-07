<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240602103634 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur ADD utilisateur_details_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B389A2C534 FOREIGN KEY (utilisateur_details_id) REFERENCES utilisateur_details (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B389A2C534 ON utilisateur (utilisateur_details_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B389A2C534');
        $this->addSql('DROP INDEX UNIQ_1D1C63B389A2C534 ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur DROP utilisateur_details_id');
    }
}
