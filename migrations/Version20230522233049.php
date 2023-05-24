<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230522233049 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE export (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, date DATE NOT NULL, range_5 INT NOT NULL, range_10 INT NOT NULL, range_15 INT NOT NULL, range_20 INT NOT NULL, range_25 INT NOT NULL, range_30 INT NOT NULL, INDEX IDX_428C169419EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE import (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, date DATE NOT NULL, range_5 INT NOT NULL, range_10 INT NOT NULL, range_15 INT NOT NULL, range_20 INT NOT NULL, range_25 INT NOT NULL, range_30 INT NOT NULL, INDEX IDX_9D4ECE1D19EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE export ADD CONSTRAINT FK_428C169419EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE import ADD CONSTRAINT FK_9D4ECE1D19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE export DROP FOREIGN KEY FK_428C169419EB6921');
        $this->addSql('ALTER TABLE import DROP FOREIGN KEY FK_9D4ECE1D19EB6921');
        $this->addSql('DROP TABLE export');
        $this->addSql('DROP TABLE import');
    }
}
