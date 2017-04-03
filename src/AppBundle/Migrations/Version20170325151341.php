<?php

namespace AppBundle\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170325151341 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE property_property_product');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE property_property_product (property_id INT NOT NULL, property_product_id INT NOT NULL, INDEX IDX_FFEA5649549213EC (property_id), INDEX IDX_FFEA5649F0254669 (property_product_id), PRIMARY KEY(property_id, property_product_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE property_property_product ADD CONSTRAINT FK_FFEA5649549213EC FOREIGN KEY (property_id) REFERENCES properties (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE property_property_product ADD CONSTRAINT FK_FFEA5649F0254669 FOREIGN KEY (property_product_id) REFERENCES properties_product (id) ON DELETE CASCADE');
    }
}
