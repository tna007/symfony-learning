<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210517154950 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__recipe AS SELECT id, name, ingredients, difficulty, image, direction FROM recipe');
        $this->addSql('DROP TABLE recipe');
        $this->addSql('CREATE TABLE recipe (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(50) NOT NULL COLLATE BINARY, ingredients VARCHAR(255) NOT NULL COLLATE BINARY, difficulty VARCHAR(20) NOT NULL COLLATE BINARY, image VARCHAR(255) DEFAULT NULL COLLATE BINARY, direction VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO recipe (id, name, ingredients, difficulty, image, direction) SELECT id, name, ingredients, difficulty, image, direction FROM __temp__recipe');
        $this->addSql('DROP TABLE __temp__recipe');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__recipe AS SELECT id, name, ingredients, difficulty, image, direction FROM recipe');
        $this->addSql('DROP TABLE recipe');
        $this->addSql('CREATE TABLE recipe (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(50) NOT NULL, ingredients VARCHAR(255) NOT NULL, difficulty VARCHAR(20) NOT NULL, image VARCHAR(255) DEFAULT NULL, direction VARCHAR(255) DEFAULT NULL COLLATE BINARY)');
        $this->addSql('INSERT INTO recipe (id, name, ingredients, difficulty, image, direction) SELECT id, name, ingredients, difficulty, image, direction FROM __temp__recipe');
        $this->addSql('DROP TABLE __temp__recipe');
    }
}
