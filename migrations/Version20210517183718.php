<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210517183718 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ingredient (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, amount VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__recipe AS SELECT id, name, difficulty, image FROM recipe');
        $this->addSql('DROP TABLE recipe');
        $this->addSql('CREATE TABLE recipe (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(50) NOT NULL COLLATE BINARY, difficulty VARCHAR(20) NOT NULL COLLATE BINARY, image VARCHAR(255) DEFAULT NULL COLLATE BINARY)');
        $this->addSql('INSERT INTO recipe (id, name, difficulty, image) SELECT id, name, difficulty, image FROM __temp__recipe');
        $this->addSql('DROP TABLE __temp__recipe');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE ingredient');
        $this->addSql('ALTER TABLE recipe ADD COLUMN ingredients VARCHAR(255) NOT NULL COLLATE BINARY');
        $this->addSql('ALTER TABLE recipe ADD COLUMN direction VARCHAR(255) DEFAULT NULL COLLATE BINARY');
    }
}
