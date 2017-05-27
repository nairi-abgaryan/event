<?php

namespace AppBundle\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170527105830 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE price_product DROP FOREIGN KEY FK_B86CCCF1549213EC');
        $this->addSql('ALTER TABLE price_product ADD CONSTRAINT FK_B86CCCF1549213EC FOREIGN KEY (property_id) REFERENCES properties (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE price_product DROP FOREIGN KEY FK_B86CCCF1549213EC');
        $this->addSql('ALTER TABLE price_product ADD CONSTRAINT FK_B86CCCF1549213EC FOREIGN KEY (property_id) REFERENCES properties (id)');
    }
}
