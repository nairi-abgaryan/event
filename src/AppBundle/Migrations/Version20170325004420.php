<?php

namespace AppBundle\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170325004420 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE properties_product DROP FOREIGN KEY FK_4DCF05801C8A5AEE');
        $this->addSql('ALTER TABLE properties_product ADD CONSTRAINT FK_4DCF05801C8A5AEE FOREIGN KEY (price_owner_id) REFERENCES users (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE properties_product DROP FOREIGN KEY FK_4DCF05801C8A5AEE');
        $this->addSql('ALTER TABLE properties_product ADD CONSTRAINT FK_4DCF05801C8A5AEE FOREIGN KEY (price_owner_id) REFERENCES price (id)');
    }
}
