<?php

namespace AppBundle\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170416140920 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE properties_product ADD image_id INT DEFAULT NULL, DROP image');
        $this->addSql('ALTER TABLE properties_product ADD CONSTRAINT FK_4DCF05803DA5256D FOREIGN KEY (image_id) REFERENCES media__media (id)');
        $this->addSql('CREATE INDEX IDX_4DCF05803DA5256D ON properties_product (image_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE properties_product DROP FOREIGN KEY FK_4DCF05803DA5256D');
        $this->addSql('DROP INDEX IDX_4DCF05803DA5256D ON properties_product');
        $this->addSql('ALTER TABLE properties_product ADD image VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, DROP image_id');
    }
}
