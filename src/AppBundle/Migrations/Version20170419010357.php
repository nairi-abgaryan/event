<?php

namespace AppBundle\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170419010357 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE properties_product DROP FOREIGN KEY FK_4DCF0580C54C8C93');
        $this->addSql('DROP INDEX IDX_4DCF0580C54C8C93 ON properties_product');
        $this->addSql('ALTER TABLE properties_product ADD type VARCHAR(255) DEFAULT NULL, DROP type_id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE properties_product ADD type_id INT DEFAULT NULL, DROP type');
        $this->addSql('ALTER TABLE properties_product ADD CONSTRAINT FK_4DCF0580C54C8C93 FOREIGN KEY (type_id) REFERENCES product_type (id)');
        $this->addSql('CREATE INDEX IDX_4DCF0580C54C8C93 ON properties_product (type_id)');
    }
}
