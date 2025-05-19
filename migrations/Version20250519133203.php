<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250519133203 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE vehicle (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, immat VARCHAR(15) NOT NULL, marque VARCHAR(50) NOT NULL, modele VARCHAR(100) NOT NULL, date_mise_en_circulation DATETIME DEFAULT NULL, energie VARCHAR(20) DEFAULT NULL, co2 INT DEFAULT NULL, puissance_fiscale INT DEFAULT NULL, puissance_reelle INT DEFAULT NULL, carrosserie VARCHAR(50) DEFAULT NULL, boite_vitesse VARCHAR(10) DEFAULT NULL, nb_passagers INT DEFAULT NULL, nb_portes INT DEFAULT NULL, nom_commercial VARCHAR(100) DEFAULT NULL, vin VARCHAR(30) DEFAULT NULL, couleur VARCHAR(30) DEFAULT NULL, logo_marque VARCHAR(255) DEFAULT NULL, INDEX IDX_1B80E486A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E486A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON user (username)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E486A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE vehicle
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX UNIQ_8D93D649F85E0677 ON user
        SQL);
    }
}
