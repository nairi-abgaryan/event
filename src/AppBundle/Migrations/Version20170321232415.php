<?php

namespace AppBundle\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170321232415 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE price (id INT AUTO_INCREMENT NOT NULL, property_id INT DEFAULT NULL, owner_id INT DEFAULT NULL, shipment_id INT DEFAULT NULL, price INT NOT NULL, description VARCHAR(255) NOT NULL, financing VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_CAC822D9549213EC (property_id), INDEX IDX_CAC822D97E3C61F9 (owner_id), INDEX IDX_CAC822D97BE036FC (shipment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE price_product (id INT AUTO_INCREMENT NOT NULL, owner_id INT DEFAULT NULL, file_id INT DEFAULT NULL, price INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_B86CCCF17E3C61F9 (owner_id), INDEX IDX_B86CCCF193CB796C (file_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shipment (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE price ADD CONSTRAINT FK_CAC822D9549213EC FOREIGN KEY (property_id) REFERENCES properties (id)');
        $this->addSql('ALTER TABLE price ADD CONSTRAINT FK_CAC822D97E3C61F9 FOREIGN KEY (owner_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE price ADD CONSTRAINT FK_CAC822D97BE036FC FOREIGN KEY (shipment_id) REFERENCES shipment (id)');
        $this->addSql('ALTER TABLE price_product ADD CONSTRAINT FK_B86CCCF17E3C61F9 FOREIGN KEY (owner_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE price_product ADD CONSTRAINT FK_B86CCCF193CB796C FOREIGN KEY (file_id) REFERENCES files (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE price DROP FOREIGN KEY FK_CAC822D97BE036FC');
        $this->addSql('DROP TABLE price');
        $this->addSql('DROP TABLE price_product');
        $this->addSql('DROP TABLE shipment');
    }
}
