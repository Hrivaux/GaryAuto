<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250520090650 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE user ADD profile_complete TINYINT(1) NOT NULL, ADD first_name VARCHAR(100) DEFAULT NULL, ADD last_name VARCHAR(100) DEFAULT NULL, ADD phone VARCHAR(20) DEFAULT NULL, ADD address VARCHAR(255) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON user (username)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user RENAME INDEX uniq_identifier_email TO UNIQ_8D93D649E7927C74
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP INDEX UNIQ_8D93D649F85E0677 ON user
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user DROP profile_complete, DROP first_name, DROP last_name, DROP phone, DROP address
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user RENAME INDEX uniq_8d93d649e7927c74 TO UNIQ_IDENTIFIER_EMAIL
        SQL);
    }
}
