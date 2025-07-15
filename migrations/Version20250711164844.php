<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250711164844 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reset_password_request (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , expires_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_7CE748AA76ED395 ON reset_password_request (user_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, username, email, roles, password, avatar, warning_count, bio, created_at, updated_at, is_active, is_banned, is_verified FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(180) NOT NULL, email VARCHAR(50) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, avatar VARCHAR(50) DEFAULT NULL, warning_count INTEGER NOT NULL, bio VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , is_active BOOLEAN NOT NULL, is_banned BOOLEAN NOT NULL, is_verified BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO user (id, username, email, roles, password, avatar, warning_count, bio, created_at, updated_at, is_active, is_banned, is_verified) SELECT id, username, email, roles, password, avatar, warning_count, bio, created_at, updated_at, is_active, is_banned, is_verified FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME ON user (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, username, email, roles, password, avatar, warning_count, bio, created_at, updated_at, is_active, is_banned, is_verified FROM "user"');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('CREATE TABLE "user" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(180) NOT NULL, email VARCHAR(50) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, avatar VARCHAR(50) DEFAULT NULL, warning_count INTEGER NOT NULL, bio VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , is_active BOOLEAN NOT NULL, is_banned BOOLEAN NOT NULL, is_verified BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO "user" (id, username, email, roles, password, avatar, warning_count, bio, created_at, updated_at, is_active, is_banned, is_verified) SELECT id, username, email, roles, password, avatar, warning_count, bio, created_at, updated_at, is_active, is_banned, is_verified FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME ON "user" (username)');
    }
}
