<?php

namespace AppBundle\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170323213410 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_B86CCCF18BF21CDE ON price_product');
        $this->addSql('ALTER TABLE price_product ADD property_id INT DEFAULT NULL, DROP property');
        $this->addSql('ALTER TABLE price_product ADD CONSTRAINT FK_B86CCCF1549213EC FOREIGN KEY (property_id) REFERENCES properties (id)');
        $this->addSql('CREATE INDEX IDX_B86CCCF1549213EC ON price_product (property_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE price_product DROP FOREIGN KEY FK_B86CCCF1549213EC');
        $this->addSql('DROP INDEX IDX_B86CCCF1549213EC ON price_product');
        $this->addSql('ALTER TABLE price_product ADD property VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, DROP property_id');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B86CCCF18BF21CDE ON price_product (property)');
    }
}
