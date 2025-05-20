<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250520102353 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE appointment DROP FOREIGN KEY FK_FE38F844545317D1
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE appointment DROP FOREIGN KEY FK_FE38F844ED5CA9E6
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE parametre_user DROP FOREIGN KEY FK_9E37452FA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE chat_message DROP FOREIGN KEY FK_FAB3FC16613FECDF
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE chat_session
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE appointment
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE parametre_user
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE service
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE chat_message
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user ADD address_street VARCHAR(255) NOT NULL, ADD address_postal_code VARCHAR(50) NOT NULL, ADD address_city VARCHAR(100) NOT NULL, ADD address_country VARCHAR(2) NOT NULL, DROP address
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE chat_session (id INT AUTO_INCREMENT NOT NULL, started_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE appointment (id INT AUTO_INCREMENT NOT NULL, vehicle_id INT NOT NULL, service_id INT NOT NULL, client_name VARCHAR(128) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, client_phone VARCHAR(32) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, scheduled_at DATETIME NOT NULL, created_at DATETIME NOT NULL, status VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_FE38F844545317D1 (vehicle_id), INDEX IDX_FE38F844ED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE parametre_user (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, site_color VARCHAR(10) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, font VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, layout_width VARCHAR(10) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, logo_url VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, dark_mode TINYINT(1) NOT NULL, show_footer TINYINT(1) NOT NULL, button_style VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_9E37452FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, price NUMERIC(8, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE chat_message (id INT AUTO_INCREMENT NOT NULL, session_id INT NOT NULL, content LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, author VARCHAR(10) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, sent_at DATETIME NOT NULL, INDEX IDX_FAB3FC16613FECDF (session_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE appointment ADD CONSTRAINT FK_FE38F844545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE appointment ADD CONSTRAINT FK_FE38F844ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE parametre_user ADD CONSTRAINT FK_9E37452FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE chat_message ADD CONSTRAINT FK_FAB3FC16613FECDF FOREIGN KEY (session_id) REFERENCES chat_session (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user ADD address VARCHAR(255) DEFAULT NULL, DROP address_street, DROP address_postal_code, DROP address_city, DROP address_country
        SQL);
    }
}
