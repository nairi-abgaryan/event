<?php

namespace AppBundle\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170323212401 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE price_product DROP FOREIGN KEY FK_B86CCCF193CB796C');
        $this->addSql('DROP INDEX IDX_B86CCCF193CB796C ON price_product');
        $this->addSql('ALTER TABLE price_product ADD property VARCHAR(255) NOT NULL, ADD established TINYINT(1) DEFAULT NULL, DROP file_id, DROP price');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B86CCCF18BF21CDE ON price_product (property)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_B86CCCF18BF21CDE ON price_product');
        $this->addSql('ALTER TABLE price_product ADD file_id INT DEFAULT NULL, ADD price INT NOT NULL, DROP property, DROP established');
        $this->addSql('ALTER TABLE price_product ADD CONSTRAINT FK_B86CCCF193CB796C FOREIGN KEY (file_id) REFERENCES files (id)');
        $this->addSql('CREATE INDEX IDX_B86CCCF193CB796C ON price_product (file_id)');
    }
}
