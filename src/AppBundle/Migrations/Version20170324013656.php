<?php

namespace AppBundle\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170324013656 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE properties_product ADD price_owner_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE properties_product ADD CONSTRAINT FK_4DCF05801C8A5AEE FOREIGN KEY (price_owner_id) REFERENCES price (id)');
        $this->addSql('CREATE INDEX IDX_4DCF05801C8A5AEE ON properties_product (price_owner_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE properties_product DROP FOREIGN KEY FK_4DCF05801C8A5AEE');
        $this->addSql('DROP INDEX IDX_4DCF05801C8A5AEE ON properties_product');
        $this->addSql('ALTER TABLE properties_product DROP price_owner_id');
    }
}
