<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250520091456 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE appointment (id INT AUTO_INCREMENT NOT NULL, vehicle_id INT NOT NULL, service_id INT NOT NULL, client_name VARCHAR(128) NOT NULL, client_phone VARCHAR(32) NOT NULL, scheduled_at DATETIME NOT NULL, created_at DATETIME NOT NULL, status VARCHAR(20) NOT NULL, INDEX IDX_FE38F844545317D1 (vehicle_id), INDEX IDX_FE38F844ED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE chat_message (id INT AUTO_INCREMENT NOT NULL, session_id INT NOT NULL, content LONGTEXT NOT NULL, author VARCHAR(10) NOT NULL, sent_at DATETIME NOT NULL, INDEX IDX_FAB3FC16613FECDF (session_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE chat_session (id INT AUTO_INCREMENT NOT NULL, started_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, description LONGTEXT DEFAULT NULL, price NUMERIC(8, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE appointment ADD CONSTRAINT FK_FE38F844545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE appointment ADD CONSTRAINT FK_FE38F844ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE chat_message ADD CONSTRAINT FK_FAB3FC16613FECDF FOREIGN KEY (session_id) REFERENCES chat_session (id)
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX UNIQ_8D93D649E7927C74 ON user
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user DROP profile_complete, DROP first_name, DROP last_name, DROP phone, DROP address
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE appointment DROP FOREIGN KEY FK_FE38F844545317D1
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE appointment DROP FOREIGN KEY FK_FE38F844ED5CA9E6
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE chat_message DROP FOREIGN KEY FK_FAB3FC16613FECDF
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE appointment
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE chat_message
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE chat_session
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE service
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user ADD profile_complete TINYINT(1) NOT NULL, ADD first_name VARCHAR(100) DEFAULT NULL, ADD last_name VARCHAR(100) DEFAULT NULL, ADD phone VARCHAR(20) DEFAULT NULL, ADD address VARCHAR(255) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)
        SQL);
    }
}
