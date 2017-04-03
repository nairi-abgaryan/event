<?php

namespace AppBundle\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170313205304 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE conditions (id INT AUTO_INCREMENT NOT NULL, `condition` VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, phone VARCHAR(255) NOT NULL, adress VARCHAR(255) NOT NULL, emial VARCHAR(255) NOT NULL, admin_emial VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favorites (id INT AUTO_INCREMENT NOT NULL, owner_id INT DEFAULT NULL, property_id INT DEFAULT NULL, category TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_E46960F57E3C61F9 (owner_id), INDEX IDX_E46960F5549213EC (property_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE files (id INT AUTO_INCREMENT NOT NULL, owner_id INT DEFAULT NULL, path VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_63540597E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images (id INT AUTO_INCREMENT NOT NULL, owner_id INT DEFAULT NULL, path VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_E01FBE6A7E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE properties (id INT AUTO_INCREMENT NOT NULL, owner_id INT DEFAULT NULL, type_id INT DEFAULT NULL, category_id INT DEFAULT NULL, file_id INT DEFAULT NULL, financing INT NOT NULL, insurance TINYINT(1) NOT NULL, shipment VARCHAR(255) NOT NULL, advance INT NOT NULL, budget INT NOT NULL, overview LONGTEXT NOT NULL, active INT NOT NULL, start DATE NOT NULL, end DATE NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_87C331C77E3C61F9 (owner_id), INDEX IDX_87C331C7C54C8C93 (type_id), INDEX IDX_87C331C712469DE2 (category_id), INDEX IDX_87C331C793CB796C (file_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE properties_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE properties_product (id INT AUTO_INCREMENT NOT NULL, property_id INT DEFAULT NULL, image_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, count VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_4DCF0580549213EC (property_id), INDEX IDX_4DCF05803DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE properties_types (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_C326967B3DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(255) DEFAULT NULL, phone_number VARCHAR(255) DEFAULT NULL, company_name VARCHAR(255) NOT NULL, adress VARCHAR(255) NOT NULL, business_address VARCHAR(255) DEFAULT NULL, legal_address VARCHAR(255) DEFAULT NULL, tin VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json_array)\', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE favorites ADD CONSTRAINT FK_E46960F57E3C61F9 FOREIGN KEY (owner_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE favorites ADD CONSTRAINT FK_E46960F5549213EC FOREIGN KEY (property_id) REFERENCES properties (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE files ADD CONSTRAINT FK_63540597E3C61F9 FOREIGN KEY (owner_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A7E3C61F9 FOREIGN KEY (owner_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE properties ADD CONSTRAINT FK_87C331C77E3C61F9 FOREIGN KEY (owner_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE properties ADD CONSTRAINT FK_87C331C7C54C8C93 FOREIGN KEY (type_id) REFERENCES properties_types (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE properties ADD CONSTRAINT FK_87C331C712469DE2 FOREIGN KEY (category_id) REFERENCES properties_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE properties ADD CONSTRAINT FK_87C331C793CB796C FOREIGN KEY (file_id) REFERENCES files (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE properties_product ADD CONSTRAINT FK_4DCF0580549213EC FOREIGN KEY (property_id) REFERENCES properties (id)');
        $this->addSql('ALTER TABLE properties_product ADD CONSTRAINT FK_4DCF05803DA5256D FOREIGN KEY (image_id) REFERENCES images (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE properties_types ADD CONSTRAINT FK_C326967B3DA5256D FOREIGN KEY (image_id) REFERENCES images (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE properties DROP FOREIGN KEY FK_87C331C793CB796C');
        $this->addSql('ALTER TABLE properties_product DROP FOREIGN KEY FK_4DCF05803DA5256D');
        $this->addSql('ALTER TABLE properties_types DROP FOREIGN KEY FK_C326967B3DA5256D');
        $this->addSql('ALTER TABLE favorites DROP FOREIGN KEY FK_E46960F5549213EC');
        $this->addSql('ALTER TABLE properties_product DROP FOREIGN KEY FK_4DCF0580549213EC');
        $this->addSql('ALTER TABLE properties DROP FOREIGN KEY FK_87C331C712469DE2');
        $this->addSql('ALTER TABLE properties DROP FOREIGN KEY FK_87C331C7C54C8C93');
        $this->addSql('ALTER TABLE favorites DROP FOREIGN KEY FK_E46960F57E3C61F9');
        $this->addSql('ALTER TABLE files DROP FOREIGN KEY FK_63540597E3C61F9');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A7E3C61F9');
        $this->addSql('ALTER TABLE properties DROP FOREIGN KEY FK_87C331C77E3C61F9');
        $this->addSql('DROP TABLE conditions');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE favorites');
        $this->addSql('DROP TABLE files');
        $this->addSql('DROP TABLE images');
        $this->addSql('DROP TABLE properties');
        $this->addSql('DROP TABLE properties_category');
        $this->addSql('DROP TABLE properties_product');
        $this->addSql('DROP TABLE properties_types');
        $this->addSql('DROP TABLE users');
    }
}
