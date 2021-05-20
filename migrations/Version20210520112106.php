<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210520112106 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__direction AS SELECT id, step, text FROM direction');
        $this->addSql('DROP TABLE direction');
        $this->addSql('CREATE TABLE direction (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, recipe_id INTEGER NOT NULL, step VARCHAR(20) NOT NULL COLLATE BINARY, text VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_3E4AD1B359D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO direction (id, step, text) SELECT id, step, text FROM __temp__direction');
        $this->addSql('DROP TABLE __temp__direction');
        $this->addSql('CREATE INDEX IDX_3E4AD1B359D8A214 ON direction (recipe_id)');
        $this->addSql('DROP INDEX IDX_6BAF787059D8A214');
        $this->addSql('CREATE TEMPORARY TABLE __temp__ingredient AS SELECT id, recipe_id, ingredient_name, amount FROM ingredient');
        $this->addSql('DROP TABLE ingredient');
        $this->addSql('CREATE TABLE ingredient (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, recipe_id INTEGER NOT NULL, ingredient_name VARCHAR(255) NOT NULL COLLATE BINARY, amount VARCHAR(20) NOT NULL COLLATE BINARY, CONSTRAINT FK_6BAF787059D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO ingredient (id, recipe_id, ingredient_name, amount) SELECT id, recipe_id, ingredient_name, amount FROM __temp__ingredient');
        $this->addSql('DROP TABLE __temp__ingredient');
        $this->addSql('CREATE INDEX IDX_6BAF787059D8A214 ON ingredient (recipe_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_3E4AD1B359D8A214');
        $this->addSql('CREATE TEMPORARY TABLE __temp__direction AS SELECT id, step, text FROM direction');
        $this->addSql('DROP TABLE direction');
        $this->addSql('CREATE TABLE direction (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, step VARCHAR(20) NOT NULL, text VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO direction (id, step, text) SELECT id, step, text FROM __temp__direction');
        $this->addSql('DROP TABLE __temp__direction');
        $this->addSql('DROP INDEX IDX_6BAF787059D8A214');
        $this->addSql('CREATE TEMPORARY TABLE __temp__ingredient AS SELECT id, recipe_id, ingredient_name, amount FROM ingredient');
        $this->addSql('DROP TABLE ingredient');
        $this->addSql('CREATE TABLE ingredient (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, recipe_id INTEGER NOT NULL, ingredient_name VARCHAR(255) NOT NULL, amount VARCHAR(20) NOT NULL)');
        $this->addSql('INSERT INTO ingredient (id, recipe_id, ingredient_name, amount) SELECT id, recipe_id, ingredient_name, amount FROM __temp__ingredient');
        $this->addSql('DROP TABLE __temp__ingredient');
        $this->addSql('CREATE INDEX IDX_6BAF787059D8A214 ON ingredient (recipe_id)');
    }
}
