<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230611132609 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE facture ADD exp_unitprice_range_5 DOUBLE PRECISION NOT NULL, ADD exp_unitprice_range_15 DOUBLE PRECISION NOT NULL, ADD exp_unitprice_range_10 DOUBLE PRECISION NOT NULL, ADD exp_unitprice_range_20 DOUBLE PRECISION NOT NULL, ADD exp_unitprice_range_25 DOUBLE PRECISION NOT NULL, ADD exp_unitprice_range_30 DOUBLE PRECISION NOT NULL, ADD imp_unitprice_range_5 DOUBLE PRECISION NOT NULL, ADD imp_unitprice_range_10 DOUBLE PRECISION NOT NULL, ADD imp_unitprice_range_15 DOUBLE PRECISION NOT NULL, ADD imp_unitprice_range_20 DOUBLE PRECISION NOT NULL, ADD imp_unitprice_range_25 DOUBLE PRECISION NOT NULL, ADD imp_unitprice_range_30 DOUBLE PRECISION NOT NULL, ADD total_qte_import DOUBLE PRECISION NOT NULL, ADD total_qte_export DOUBLE PRECISION NOT NULL, ADD total_prix_import DOUBLE PRECISION NOT NULL, ADD total_prix_export DOUBLE PRECISION NOT NULL, ADD prix_global DOUBLE PRECISION NOT NULL, ADD remise DOUBLE PRECISION NOT NULL, ADD prix_global_net DOUBLE PRECISION NOT NULL, CHANGE imp_prix_range_5 imp_prix_range_5 DOUBLE PRECISION NOT NULL, CHANGE exp_prix_range_5 exp_prix_range_5 DOUBLE PRECISION NOT NULL, CHANGE imp_prix_range_10 imp_prix_range_10 DOUBLE PRECISION NOT NULL, CHANGE exp_prix_range_10 exp_prix_range_10 DOUBLE PRECISION NOT NULL, CHANGE imp_prix_range_15 imp_prix_range_15 DOUBLE PRECISION NOT NULL, CHANGE exp_prix_range_15 exp_prix_range_15 DOUBLE PRECISION NOT NULL, CHANGE imp_prix_range_20 imp_prix_range_20 DOUBLE PRECISION NOT NULL, CHANGE exp_prix_range_20 exp_prix_range_20 DOUBLE PRECISION NOT NULL, CHANGE imp_prix_range_25 imp_prix_range_25 DOUBLE PRECISION NOT NULL, CHANGE exp_prix_range_25 exp_prix_range_25 DOUBLE PRECISION NOT NULL, CHANGE imp_prix_range_30 imp_prix_range_30 DOUBLE PRECISION NOT NULL, CHANGE exp_prix_range_30 exp_prix_range_30 DOUBLE PRECISION NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE facture DROP exp_unitprice_range_5, DROP exp_unitprice_range_15, DROP exp_unitprice_range_10, DROP exp_unitprice_range_20, DROP exp_unitprice_range_25, DROP exp_unitprice_range_30, DROP imp_unitprice_range_5, DROP imp_unitprice_range_10, DROP imp_unitprice_range_15, DROP imp_unitprice_range_20, DROP imp_unitprice_range_25, DROP imp_unitprice_range_30, DROP total_qte_import, DROP total_qte_export, DROP total_prix_import, DROP total_prix_export, DROP prix_global, DROP remise, DROP prix_global_net, CHANGE imp_prix_range_5 imp_prix_range_5 INT NOT NULL, CHANGE exp_prix_range_5 exp_prix_range_5 INT NOT NULL, CHANGE imp_prix_range_10 imp_prix_range_10 INT NOT NULL, CHANGE exp_prix_range_10 exp_prix_range_10 INT NOT NULL, CHANGE imp_prix_range_15 imp_prix_range_15 INT NOT NULL, CHANGE exp_prix_range_15 exp_prix_range_15 INT NOT NULL, CHANGE imp_prix_range_20 imp_prix_range_20 INT NOT NULL, CHANGE exp_prix_range_20 exp_prix_range_20 INT NOT NULL, CHANGE imp_prix_range_25 imp_prix_range_25 INT NOT NULL, CHANGE exp_prix_range_25 exp_prix_range_25 INT NOT NULL, CHANGE imp_prix_range_30 imp_prix_range_30 INT NOT NULL, CHANGE exp_prix_range_30 exp_prix_range_30 INT NOT NULL');
    }
}
