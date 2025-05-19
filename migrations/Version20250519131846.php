<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250519131846 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E486A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE vehicle
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user ADD username VARCHAR(180) NOT NULL, ADD avatar_name VARCHAR(255) DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON user (username)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE vehicle (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, immat VARCHAR(15) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, marque VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, modele VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, date_mise_en_circulation DATETIME DEFAULT NULL, energie VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, co2 INT DEFAULT NULL, puissance_fiscale INT DEFAULT NULL, puissance_reelle INT DEFAULT NULL, carrosserie VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, boite_vitesse VARCHAR(10) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, nb_passagers INT DEFAULT NULL, nb_portes INT DEFAULT NULL, nom_commercial VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, vin VARCHAR(30) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, couleur VARCHAR(30) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, logo_marque VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_1B80E486A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E486A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX UNIQ_8D93D649F85E0677 ON user
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user DROP username, DROP avatar_name, DROP updated_at
        SQL);
    }
}
