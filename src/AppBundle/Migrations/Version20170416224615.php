<?php

namespace AppBundle\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170416224615 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE price DROP FOREIGN KEY FK_CAC822D97BE036FC');
        $this->addSql('DROP INDEX IDX_CAC822D97BE036FC ON price');
        $this->addSql('ALTER TABLE price ADD shipment TINYINT(1) NOT NULL, DROP shipment_id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE price ADD shipment_id INT DEFAULT NULL, DROP shipment');
        $this->addSql('ALTER TABLE price ADD CONSTRAINT FK_CAC822D97BE036FC FOREIGN KEY (shipment_id) REFERENCES shipment (id)');
        $this->addSql('CREATE INDEX IDX_CAC822D97BE036FC ON price (shipment_id)');
    }
}
