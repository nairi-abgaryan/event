<?php

namespace AppBundle\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170325143312 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE helpful DROP FOREIGN KEY FK_10E76E9793CB796C');
        $this->addSql('DROP INDEX IDX_10E76E9793CB796C ON helpful');
        $this->addSql('ALTER TABLE helpful ADD file VARCHAR(255) NOT NULL, DROP file_id, CHANGE name name VARCHAR(255) NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE helpful ADD file_id INT DEFAULT NULL, DROP file, CHANGE name name LONGTEXT NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE helpful ADD CONSTRAINT FK_10E76E9793CB796C FOREIGN KEY (file_id) REFERENCES files (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_10E76E9793CB796C ON helpful (file_id)');
    }
}
