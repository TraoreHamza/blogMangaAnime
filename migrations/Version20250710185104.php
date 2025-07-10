<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250710185104 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, title VARCHAR(50) NOT NULL, image VARCHAR(255) NOT NULL, slug VARCHAR(50) NOT NULL, content VARCHAR(255) DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_23A0E66F675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_23A0E66F675F31B ON article (author_id)');
        $this->addSql('CREATE TABLE block (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(50) NOT NULL, content CLOB DEFAULT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE TABLE category (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(50) DEFAULT NULL)');
        $this->addSql('CREATE TABLE category_manga_anime (category_id INTEGER NOT NULL, manga_anime_id INTEGER NOT NULL, PRIMARY KEY(category_id, manga_anime_id), CONSTRAINT FK_32C9E74E12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_32C9E74EED239CA FOREIGN KEY (manga_anime_id) REFERENCES manga_anime (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_32C9E74E12469DE2 ON category_manga_anime (category_id)');
        $this->addSql('CREATE INDEX IDX_32C9E74EED239CA ON category_manga_anime (manga_anime_id)');
        $this->addSql('CREATE TABLE comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, article_id INTEGER NOT NULL, reviews_id INTEGER DEFAULT NULL, content CLOB NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , is_moderated BOOLEAN NOT NULL, is_published BOOLEAN NOT NULL, CONSTRAINT FK_9474526CF675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_9474526C7294869C FOREIGN KEY (article_id) REFERENCES article (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_9474526C8092D97F FOREIGN KEY (reviews_id) REFERENCES review (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_9474526CF675F31B ON comment (author_id)');
        $this->addSql('CREATE INDEX IDX_9474526C7294869C ON comment (article_id)');
        $this->addSql('CREATE INDEX IDX_9474526C8092D97F ON comment (reviews_id)');
        $this->addSql('CREATE TABLE favori (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, users_id INTEGER DEFAULT NULL, manga_animes_id INTEGER DEFAULT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_EF85A2CC67B3B43D FOREIGN KEY (users_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_EF85A2CC9CCE44B2 FOREIGN KEY (manga_animes_id) REFERENCES manga_anime (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_EF85A2CC67B3B43D ON favori (users_id)');
        $this->addSql('CREATE INDEX IDX_EF85A2CC9CCE44B2 ON favori (manga_animes_id)');
        $this->addSql('CREATE TABLE manga_anime (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(50) NOT NULL, type VARCHAR(50) NOT NULL, release_date DATETIME DEFAULT NULL, popularity INTEGER NOT NULL, synopsis CLOB NOT NULL, author VARCHAR(50) NOT NULL, studio VARCHAR(50) NOT NULL, number_of_volumes INTEGER NOT NULL, number_of_episodes INTEGER NOT NULL, cover_image VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE recommendation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, users_id INTEGER DEFAULT NULL, manga_animes_id INTEGER DEFAULT NULL, score INTEGER NOT NULL, CONSTRAINT FK_433224D267B3B43D FOREIGN KEY (users_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_433224D29CCE44B2 FOREIGN KEY (manga_animes_id) REFERENCES manga_anime (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_433224D267B3B43D ON recommendation (users_id)');
        $this->addSql('CREATE INDEX IDX_433224D29CCE44B2 ON recommendation (manga_animes_id)');
        $this->addSql('CREATE TABLE review (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, users_id INTEGER DEFAULT NULL, manga_animes_id INTEGER DEFAULT NULL, content CLOB DEFAULT NULL, rating INTEGER NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , status VARCHAR(50) DEFAULT NULL, CONSTRAINT FK_794381C667B3B43D FOREIGN KEY (users_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_794381C69CCE44B2 FOREIGN KEY (manga_animes_id) REFERENCES manga_anime (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_794381C667B3B43D ON review (users_id)');
        $this->addSql('CREATE INDEX IDX_794381C69CCE44B2 ON review (manga_animes_id)');
        $this->addSql('CREATE TABLE "user" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(180) NOT NULL, email VARCHAR(50) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, avatar VARCHAR(50) DEFAULT NULL, warning_count INTEGER NOT NULL, bio VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , is_active BOOLEAN NOT NULL, is_banned BOOLEAN NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME ON "user" (username)');
        $this->addSql('CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , available_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , delivered_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE block');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE category_manga_anime');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE favori');
        $this->addSql('DROP TABLE manga_anime');
        $this->addSql('DROP TABLE recommendation');
        $this->addSql('DROP TABLE review');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
