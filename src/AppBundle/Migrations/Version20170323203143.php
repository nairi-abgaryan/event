<?php

namespace AppBundle\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170323203143 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE price ADD file_id INT DEFAULT NULL, DROP price');
        $this->addSql('ALTER TABLE price ADD CONSTRAINT FK_CAC822D993CB796C FOREIGN KEY (file_id) REFERENCES files (id)');
        $this->addSql('CREATE INDEX IDX_CAC822D993CB796C ON price (file_id)');
        $this->addSql('ALTER TABLE properties DROP FOREIGN KEY FK_87C331C793CB796C');
        $this->addSql('ALTER TABLE properties ADD CONSTRAINT FK_87C331C793CB796C FOREIGN KEY (file_id) REFERENCES files (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE price DROP FOREIGN KEY FK_CAC822D993CB796C');
        $this->addSql('DROP INDEX IDX_CAC822D993CB796C ON price');
        $this->addSql('ALTER TABLE price ADD price INT NOT NULL, DROP file_id');
        $this->addSql('ALTER TABLE properties DROP FOREIGN KEY FK_87C331C793CB796C');
        $this->addSql('ALTER TABLE properties ADD CONSTRAINT FK_87C331C793CB796C FOREIGN KEY (file_id) REFERENCES files (id)');
    }
}
