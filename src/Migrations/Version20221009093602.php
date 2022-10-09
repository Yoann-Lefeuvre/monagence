<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221009093602 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE "Option" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE property (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, file_name VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, surface INTEGER NOT NULL, rooms INTEGER NOT NULL, bedrooms INTEGER NOT NULL, floor INTEGER NOT NULL, price INTEGER NOT NULL, heat INTEGER NOT NULL, city VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, postal_code VARCHAR(255) NOT NULL, sold BOOLEAN DEFAULT \'0\' NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL)');
        $this->addSql('CREATE TABLE property_option (property_id INTEGER NOT NULL, option_id INTEGER NOT NULL, PRIMARY KEY(property_id, option_id))');
        $this->addSql('CREATE INDEX IDX_24F16FCC549213EC ON property_option (property_id)');
        $this->addSql('CREATE INDEX IDX_24F16FCCA7C41D6F ON property_option (option_id)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE "Option"');
        $this->addSql('DROP TABLE property');
        $this->addSql('DROP TABLE property_option');
        $this->addSql('DROP TABLE user');
    }
}
