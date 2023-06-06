<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230525014906 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE facture (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, date DATE NOT NULL, qte_range_5 INT NOT NULL, imp_qte_range_5 INT NOT NULL, imp_prix_range_5 INT NOT NULL, exp_qte_range_5 INT NOT NULL, exp_prix_range_5 INT NOT NULL, imp_qte_range_10 INT NOT NULL, imp_prix_range_10 INT NOT NULL, exp_qte_range_10 INT NOT NULL, exp_prix_range_10 INT NOT NULL, imp_qte_range_15 INT NOT NULL, imp_prix_range_15 INT NOT NULL, exp_qte_range_15 INT NOT NULL, exp_prix_range_15 INT NOT NULL, imp_qte_range_20 INT NOT NULL, imp_prix_range_20 INT NOT NULL, exp_qte_range_20 INT NOT NULL, exp_prix_range_20 INT NOT NULL, imp_qte_range_25 INT NOT NULL, imp_prix_range_25 INT NOT NULL, exp_qte_range_25 INT NOT NULL, exp_prix_range_25 INT NOT NULL, imp_qte_range_30 INT NOT NULL, imp_prix_range_30 INT NOT NULL, exp_qte_range_30 INT NOT NULL, exp_prix_range_30 INT NOT NULL, periode DATE NOT NULL, INDEX IDX_FE86641019EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE86641019EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE86641019EB6921');
        $this->addSql('DROP TABLE facture');
    }
}
